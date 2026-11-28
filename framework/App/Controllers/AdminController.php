<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Models\AdminModel;
use Framework\DB\Connection;
use App\Models\ContactModel;

use PDO;
use Exception;
use Throwable;

/** 
 * Class AdminController
 *
 * This controller manages admin-related actions within the application.It extends the base controller functionality
 * provided by BaseController.
 *
 * @package App\Controllers
 */
class AdminController extends BaseController
{
    /**
     * Authorizes actions in this controller.
     *
     * This method checks if the user is logged in, allowing or denying access to specific actions based
     * on the authentication state.
     *
     * @param string $action The name of the action to authorize.
     * @return bool Returns true if the user is logged in; false otherwise.
     */

    public function authorize(Request $request, string $action): bool
    {
        $user = $this->app->getAppUser();

        error_log('IS LOGGED IN: ' . ($user->isLoggedIn() ? 'YES' : 'NO'));
        error_log('IDENTITY: ' . get_class($user->getIdentity() ?? new \stdClass()));

        if (!$user->isLoggedIn()) {
            return false;
        }

        error_log('USER ID: ' . $user->getId());
        error_log('USER ROLE: ' . $user->getRole());

        return in_array($user->getRole(), ['admin', 'dev'], true);
    }

    /**
     * Displays the index page of the admin panel.
     *
     * This action requires authorization. It returns an HTML response for the admin dashboard or main page.
     *
     * @return Response Returns a response object containing the rendered HTML.
     */
    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function loginProcess(Request $request): Response
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect($this->url('admin.adminLogin'));
        }

        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return $this->redirect(
                $this->url('auth.adminLogin') . '&error=invalid_csrf_token'
            );
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            return $this->redirect(
                $this->url('auth.adminLogin') . '&error=empty_fields'
            );
        }

        $logged = $this->app->getAuthenticator()->login($username, $password);

        if (!$logged) {
            return $this->redirect(
                $this->url('auth.adminLogin') . '&error=invalid_credentials'
            );
        }

        session_regenerate_id(true);
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        return $this->redirect($this->url('home.index'));
    }

    public function adminLogin(Request $request): Response
    {
        return $this->html();
    }

    public function adminFormular(Request $request): Response
    {
        $messages = ContactModel::getMessages();

        return $this->html([
            'messages' => $messages
        ]);
    }

    public function updateMessage(Request $request): Response
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(false, 'Nepovolená metóda požiadavky.', 405);
        }

        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return $this->jsonResponse(false, 'Neplatný CSRF token.', 403);
        }

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $isResolved = filter_var($_POST['is_resolved'] ?? null, FILTER_VALIDATE_INT);

        if (
            $id === false || $id === null || $id <= 0 ||
            !in_array($isResolved, [0, 1], true)
        ) {
            return $this->jsonResponse(false, 'Neplatné údaje.', 400);
        }

        try {
            ContactModel::updateMessageStatus($id, $isResolved);

            return $this->jsonResponse(true, 'Stav správy bol úspešne aktualizovaný.');
        } catch (Throwable $e) {
            error_log($e->getMessage());

            return $this->jsonResponse(false, 'Stav správy sa nepodarilo aktualizovať.', 500);
        }
    }

    public function deleteMessage(Request $request): Response
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(false, 'Nepovolená metóda požiadavky.', 405);
        }

        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return $this->jsonResponse(false, 'Neplatný CSRF token.', 403);
        }

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id < 1) {
            return $this->jsonResponse(false, 'Neplatné ID správy.', 400);
        }

        try {
            ContactModel::deleteMessage($id);

            return $this->jsonResponse(true, 'Správa bola úspešne vymazaná.');
        } catch (Throwable $e) {
            error_log($e->getMessage());

            return $this->jsonResponse(false, 'Správu sa nepodarilo vymazať.', 500);
        }
    }

    public function logout(Request $request): Response
    {
        $_SESSION = [];

        session_destroy();

        return $this->redirect($this->url('home.index'));

    }

    public function adminTranslations(Request $request): Response
    {
        $db = Connection::getInstance();
        /*Vygenerovany sql*/
        $sql = "SELECT
        t_sk.translation_key AS tk,
        t_sk.translation_value AS sk,
        t_en.translation_value AS en,
        t_sk.id AS id_sk,
        t_en.id AS id_en
        FROM translations t_sk
        JOIN languages l_sk ON l_sk.id = t_sk.language_id
        JOIN translations t_en ON t_en.translation_key = t_sk.translation_key
        JOIN languages l_en ON l_en.id = t_en.language_id
        WHERE l_sk.code = 'sk'
        AND l_en.code = 'en'
        ORDER BY t_sk.translation_key";

        $stmt = $db->query($sql);
        $translations = $stmt->fetchAll();

        $currentLanguage = $_SESSION['language'] ?? 'sk';

        $user = $this->app->getAppUser();
        $isDev = $user->isLoggedIn() && $user->getRole() === 'dev';

        return $this->html([
            'translations' => $translations,
            'currentLanguage' => $currentLanguage,
            'isDev' => $isDev
        ]);

    }
    public function updateLanguage(Request $request): Response
    {


        header('Content-Type: application/json; charset=utf-8');

        $user = $this->app->getAppUser();

        if (!$user->isLoggedIn()) {
            return $this->jsonResponse(false, 'Nie ste prihlásený.', 401);
        }

        if (!in_array($user->getRole(), ['admin', 'dev'], true)) {
            return $this->jsonResponse(false, 'Nemáte oprávnenie vykonať túto akciu.', 403);
        }

        $pdo = Connection::getInstance();


        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';


        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return $this->jsonResponse(false, 'Neplatná požiadavka.', 403);
        }

        $id_sk = filter_input(INPUT_POST, 'id_sk', FILTER_VALIDATE_INT);
        $id_en = filter_input(INPUT_POST, 'id_en', FILTER_VALIDATE_INT);

        $sk = trim($_POST['sk'] ?? '');
        $en = trim($_POST['en'] ?? '');

        if (!$id_sk || !$id_en || $sk === '' || $en === '') {
            return $this->jsonResponse(false, 'Neplatné údaje.', 400);
        }

        try {
            $pdo->beginTransaction();

            $sql = 'update translations set translation_value = :value
            where id = :id';

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':value' => $sk,
                ':id' => $id_sk
            ]);

            $stmt->execute([
                ':value' => $en,
                ':id' => $id_en
            ]);

            $pdo->commit();
        } catch (Throwable $e) {
            $pdo->rollBack();
            return $this->jsonResponse(false, 'Preklad sa nepodarilo uložiť.', 500);
        }
        return $this->jsonResponse(true, 'Preklad sa úspešne uložil.');
        exit;
    }
    public function uploadDocument(Request $request): Response
    {
    }
    public function editDocument(Request $request): Response
    {
    }
    public function createLanguage(Request $request): Response
    {

        header('Content-Type: application/json; charset=utf-8');

        $user = $this->app->getAppUser();

        if (!$user->isLoggedIn()) {
            return $this->jsonResponse(false, 'Nie ste prihlásený.', 401);
        }

        if ($user->getRole() !== 'dev') {
            return $this->jsonResponse(false, 'Nemáte oprávnenie vykonať túto akciu.', 403);
        }

        $db = Connection::getInstance();


        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';


        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return $this->jsonResponse(false, 'Neplatná požiadavka.', 403);
        }

        $translation_key = trim($_POST['translation_key_form'] ?? '');
        $sk = trim($_POST['translation_sk'] ?? '');
        $en = trim($_POST['translation_en'] ?? '');
        /*var_dump($_POST);
        exit;*/
        error_log('KEY: ' . $translation_key);
        error_log('SK: ' . $sk);
        error_log('EN: ' . $en);

        if ($translation_key === '' || $sk === '' || $en === '') {
            return $this->jsonResponse(false, 'Vyplňte všetky polia.', 400);
        }

        try {
            $db->beginTransaction();

            $languageSql = 'select code, id from languages where code in ("sk","en")';
            $languageStmt = $db->query($languageSql);
            $languages = $languageStmt->fetchAll(PDO::FETCH_KEY_PAIR);

            if (!isset($languages['sk']) || !isset($languages['en'])) {
                throw new Exception('Jazyky SK alebo EN neboli nájdené');
            }

            $checkSql = 'select count(*) from translations where translation_key = :key';
            $checkStmt = $db->prepare($checkSql);
            $checkStmt->execute([':key' => $translation_key]);

            if ((int) $checkStmt->fetchColumn() > 0) {
                $db->rollBack();
                return $this->jsonResponse(false, 'Tento tag už existuje.', 409);
            }
            $insertSql = 'insert into translations(language_id, translation_key, translation_value) 
                    values (:language_id, :key, :value)';

            $insertStmt = $db->prepare($insertSql);
            $insertStmt->execute([
                ':language_id' => $languages['sk'],
                ':key' => $translation_key,
                ':value' => $sk
            ]);

            $insertStmt->execute([
                ':language_id' => $languages['en'],
                ':key' => $translation_key,
                ':value' => $en
            ]);

            $db->commit();
        } catch (Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }

            error_log($e->getMessage());
            return $this->jsonResponse(false, 'Preklad sa nepodarilo vytvoriť.', 500);
        }
        return $this->jsonResponse(true, 'Preklad sa úspešne vytvoril.');
        exit;
    }

    public function deleteLanguage(Request $request): Response
    {
        $user = $this->app->getAppUser();

        if (!$user->isLoggedIn()) {
            return $this->jsonResponse(false, 'Nie ste prihlásený.', 401);
        }

        if (!in_array($user->getRole(), ['admin', 'dev'], true)) {
            return $this->jsonResponse(false, 'Nemáte oprávnenie vykonať túto akciu.', 403);
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(false, 'Nepovolená metóda požiadavky.', 405);
        }

        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return $this->jsonResponse(false, 'Neplatný CSRF token.', 403);
        }

        $idSk = filter_var($_POST['id_sk'] ?? null, FILTER_VALIDATE_INT);
        $idEn = filter_var($_POST['id_en'] ?? null, FILTER_VALIDATE_INT);

        if (
            $idSk === false || $idSk === null || $idSk < 1 ||
            $idEn === false || $idEn === null || $idEn < 1 ||
            $idSk === $idEn
        ) {
            return $this->jsonResponse(false, 'Neplatné ID prekladu.', 400);
        }

        $pdo = Connection::getInstance();

        try {
            $pdo->beginTransaction();

            // Overíme, či oba záznamy patria k rovnakému prekladu.
            $sql = '
            SELECT COUNT(*)
            FROM translations sk
            JOIN languages lang_sk ON lang_sk.id = sk.language_id
            JOIN translations en ON en.translation_key = sk.translation_key
            JOIN languages lang_en ON lang_en.id = en.language_id
            WHERE sk.id = :id_sk
            AND lang_sk.code = "sk"
            AND en.id = :id_en
            AND lang_en.code = "en"
        ';

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_sk' => $idSk,
                ':id_en' => $idEn
            ]);

            if ((int) $stmt->fetchColumn() !== 1) {
                $pdo->rollBack();

                return $this->jsonResponse(
                    false,
                    'Preklad sa nenašiel alebo jeho záznamy nepatria k sebe.',
                    404
                );
            }

            // Vymažeme oba jazykové záznamy.
            $sql = 'DELETE FROM translations WHERE id IN (:id_sk, :id_en)';

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_sk' => $idSk,
                ':id_en' => $idEn
            ]);

            if ($stmt->rowCount() !== 2) {
                throw new Exception('Nepodarilo sa vymazať oba jazykové záznamy.');
            }

            $pdo->commit();

            return $this->jsonResponse(
                true,
                'Preklad bol úspešne vymazaný.'
            );

        } catch (Throwable $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            error_log($e->getMessage());

            return $this->jsonResponse(
                false,
                'Preklad sa nepodarilo vymazať.',
                500
            );
        }
    }

    public function jsonResponse(
        bool $success,
        string $message,
        int $status = 200
    ): Response {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        return $this->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}

