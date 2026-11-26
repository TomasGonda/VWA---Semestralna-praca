<?php

class CreateLanguage
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function run(): never
    {
        session_start();

        header('Content-Type: application/json; charset=utf-8');

        $this->checkPermissions();
        $this->checkCsrf();

        $translationKey = trim($_POST['translation_key_form'] ?? '');
        $sk = trim($_POST['translation_sk'] ?? '');
        $en = trim($_POST['translation_en'] ?? '');

        if ($translationKey === '' || $sk === '' || $en === '') {
            $this->respond(false, 'Vyplňte všetky polia.', 400);
        }

        $this->createTranslation($translationKey, $sk, $en);
    }

    private function checkPermissions(): void
    {
        if (
            !isset($_SESSION['admin_id']) ||
            ($_SESSION['admin_role'] ?? '') !== 'dev'
        ) {
            $this->respond(false, 'Nemáte oprávnenie vykonať túto akciu.', 403);
        }
    }

    private function checkCsrf(): void
    {
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            $this->respond(false, 'Neplatná požiadavka.', 403);
        }
    }

    private function createTranslation(
        string $translationKey,
        string $sk,
        string $en
    ): never {
        try {
            $this->pdo->beginTransaction();

            $languages = $this->getLanguages();

            if (!isset($languages['sk']) || !isset($languages['en'])) {
                throw new Exception('Jazyky SK alebo EN neboli nájdené.');
            }

            $this->checkExistingTranslation($translationKey);

            $this->insertTranslation(
                $languages['sk'],
                $translationKey,
                $sk
            );

            $this->insertTranslation(
                $languages['en'],
                $translationKey,
                $en
            );

            $this->pdo->commit();

            $this->respond(true, 'Preklad sa úspešne vytvoril.');

        } catch (Throwable $e) {

            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            error_log($e->getMessage());

            $this->respond(
                false,
                'Preklad sa nepodarilo vytvoriť.',
                500
            );
        }
    }

    private function getLanguages(): array
    {
        $sql = 'SELECT code, id FROM languages WHERE code IN ("sk", "en")';

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    private function checkExistingTranslation(string $translationKey): void
    {
        $sql = 'SELECT COUNT(*) FROM translations WHERE translation_key = :key';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':key' => $translationKey]);

        if ((int) $stmt->fetchColumn() > 0) {
            $this->respond(false, 'Tento tag už existuje.', 409);
        }
    }

    private function insertTranslation(
        int $languageId,
        string $translationKey,
        string $value
    ): void {
        $sql = 'INSERT INTO translations
                (language_id, translation_key, translation_value)
                VALUES (:language_id, :key, :value)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':language_id' => $languageId,
            ':key' => $translationKey,
            ':value' => $value
        ]);
    }

    private function respond(
        bool $success,
        string $message,
        int $status = 200
    ): never {
        http_response_code($status);

        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);

        exit;
    }
}



class DeleteLanguage
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function run(): never
    {
        session_start();

        header('Content-Type: application/json; charset=utf-8');

        $this->checkPermissions();
        $this->checkRequestMethod();
        $this->checkCsrf();

        $idSk = filter_var($_POST['id_sk'] ?? null, FILTER_VALIDATE_INT);
        $idEn = filter_var($_POST['id_en'] ?? null, FILTER_VALIDATE_INT);

        if (!$idSk || !$idEn || $idSk < 1 || $idEn < 1 || $idSk === $idEn) {
            $this->respond(false, 'Neplatné ID prekladu.', 400);
        }

        $this->deleteTranslation($idSk, $idEn);
    }

    private function checkPermissions(): void
    {
        if (
            !isset($_SESSION['admin_id']) ||
            !in_array($_SESSION['admin_role'] ?? '', ['admin', 'dev'], true)
        ) {
            $this->respond(false, 'Nemáte oprávnenie vykonať túto akciu.', 403);
        }
    }

    private function checkRequestMethod(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->respond(false, 'Nepovolená metóda požiadavky.', 405);
        }
    }

    private function checkCsrf(): void
    {
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            $this->respond(false, 'Neplatná požiadavka.', 403);
        }
    }

    private function deleteTranslation(int $idSk, int $idEn): never
    {
        try {
            $this->pdo->beginTransaction();

            /**
             * Vygenerovany select pre overovanie, ci zadane id patria rovnakemu tagu a jazykovym verziam
             */
            $sql = 'SELECT COUNT(*)
                    FROM translations sk
                    JOIN languages lang_sk
                        ON lang_sk.id = sk.language_id
                    JOIN translations en
                        ON en.translation_key = sk.translation_key
                    JOIN languages lang_en
                        ON lang_en.id = en.language_id
                    WHERE sk.id = :id_sk
                    AND lang_sk.code = "sk"
                    AND en.id = :id_en
                    AND lang_en.code = "en"';

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_sk' => $idSk,
                ':id_en' => $idEn
            ]);

            if ((int) $stmt->fetchColumn() !== 1) {
                $this->pdo->rollBack();
                $this->respond(false, 'Preklad sa nenašiel alebo nepatrí k sebe.', 404);
            }
            $sql = 'DELETE FROM translations
                    WHERE id IN (:id_sk, :id_en)';

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_sk' => $idSk,
                ':id_en' => $idEn
            ]);

            $this->pdo->commit();

            $this->respond(true, 'Preklad bol úspešne vymazaný.');

        } catch (Throwable $e) {

            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            error_log($e->getMessage());

            $this->respond(false, 'Preklad sa nepodarilo vymazať.', 500);
        }
    }

    private function respond(
        bool $success,
        string $message,
        int $status = 200
    ): never {
        http_response_code($status);

        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);

        exit;
    }
}

require_once __DIR__ . '/../../databaseConections/database.php';

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        (new CreateLanguage($pdo))->run();
        break;

    case 'delete':
        error_log('Delete IDs: ' . ($_POST['id_sk'] ?? 'missing') . ', ' . ($_POST['id_en'] ?? 'missing'));
        (new DeleteLanguage($pdo))->run();
        break;

    default:
        http_response_code(400);
        exit('Neznáma akcia');
}
