<?php

require_once __DIR__ . '/../Controllers/AdminController.php';
require_once __DIR__ . '/../../databaseConections/database.php';

class DeleteDocument extends AdminController
{
    public function run(): never
    {
        session_start();

        if (!$this->checkPermission(['admin', 'dev'])) {
            $this->respond(false, 'Nemáte oprávnenie mazať súbory', 403);
        }

        if (!$this->checkPostMethod()) {
            $this->respond(false, 'Neplatná požiadavka', 400);
        }

        if (!$this->csrfCheck()) {
            $this->respond(false, 'Neplatný token', 403);
        }
        $id = filter_input(INPUT_POST, 'id_document', FILTER_VALIDATE_INT);

        if (!$this->idCheck($id)) {
            $this->respond(false, 'ID súboru sa nenašlo', 404);
        }

        if (!$this->deleteFile($id)) {
            $this->respond(false, 'Chyba servera', 500);
        }

        $this->respond(true, 'Súbor úspešne vymazaný', 200);
    }

    /*private function checkPermission(): bool
    {
        if (
            !isset($_SESSION['admin_id']) ||
            !in_array($_SESSION['admin_role'] ?? '', ['admin', 'dev'], true)
        ) {
            return false;
        } else {
            return true;
        }
    }

    private function checkPostMethod(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        } else {
            return true;
        }
    }

    private function csrfCheck(): bool
    {
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';
        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return false;
        } else {
            return true;
        }
    }

    private function idCheck(int $id): bool
    {
        if (!$id || $id < 1) {
            return false;
        } else {
            return true;
        }
    }*/

    private function deleteFile(int $id): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = "Delete from document where id_document = :id_document";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_document' => $id
            ]);

            if ($stmt->rowCount() !== 1) {
                $this->pdo->rollBack();
                return false;
            }

            $this->pdo->commit();

            return true;

        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            error_log($e->getMessage());

            return false;
        }
    }
}

class DeleteMessage extends AdminController
{
    public function run(): never
    {
        session_start();

        if (!$this->checkPermission(['admin', 'dev'])) {
            $this->respond(false, 'Nemáte oprávnenie mazať súbory', 403);
        }

        if (!$this->checkPostMethod()) {
            $this->respond(false, 'Neplatná požiadavka', 400);
        }

        if (!$this->csrfCheck()) {
            $this->respond(false, 'Neplatný token', 403);
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$this->idCheck($id)) {
            $this->respond(false, 'ID správy sa nenašlo', 404);
        }

        if (!$this->deleteMessage($id)) {
            $this->respond(false, 'Chyba servera', 500);
        }

        $this->respond(true, 'Správa úspešne vymazaná', 200);
    }

    private function deleteMessage(int $id): bool
    {
        try {
            $this->pdo->beginTransaction();
            $sql = "Delete from contact where id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);
            if ($stmt->rowCount() !== 1) {
                $this->pdo->rollBack();
                return false;
            }

            $this->pdo->commit();

            return true;
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            error_log($e->getMessage());

            return false;
        }
    }
}

class UpdateMessage extends AdminController
{
    public function run(): never
    {
        session_start();

        if (!$this->checkPermission(['admin', 'dev'])) {
            $this->respond(false, 'Nemáte oprávnenie mazať súbory', 403);
        }

        if (!$this->checkPostMethod()) {
            $this->respond(false, 'Neplatná požiadavka', 400);
        }

        if (!$this->csrfCheck()) {
            $this->respond(false, 'Neplatný token', 403);
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $isResolved = filter_input(INPUT_POST, 'is_resolved', FILTER_VALIDATE_INT);

        if (!$this->idCheck($id)) {
            $this->respond(false, 'ID správy sa nenašlo', 404);
        }

        if (!$this->updateMessage($id, $isResolved)) {
            $this->respond(false, 'Chyba servera', 500);
        }

        $this->respond(true, 'Správa úspešne upravená', 200);
    }

    private function updateMessage(int $id, int $isResolved)
    {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE contact
                SET is_resolved = :is_resolved
                WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                ':is_resolved' => $isResolved,
                ':id' => $id
            ]);

            $checkSql = "SELECT COUNT(*) FROM contact WHERE id = :id";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->execute([':id' => $id]);

            if ((int) $checkStmt->fetchColumn() !== 1) {
                $this->pdo->rollBack();
                return false;
            }

            $this->pdo->commit();

            return true;

        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            error_log('UpdateMessage error: ' . $e->getMessage());

            return false;
        }
    }
}


class UpdateLanguage extends AdminController
{

}

class UploadDocument extends AdminController
{

}

class UpdateDocument extends AdminController
{

}


$action = $_POST['action'] ?? '';

switch ($action) {
    case 'delete-document':
        (new DeleteDocument($pdo))->run();
        break;

    case 'delete-message':
        (new DeleteMessage($pdo))->run();
        break;

    case 'update-language':
        (new UpdateLanguage($pdo))->run();
        break;

    case 'update-message':
        (new UpdateMessage($pdo))->run();
        break;

    case 'upload-document':
        (new UploadDocument($pdo))->run();
        break;

    case 'update-document':
        (new UpdateDocument($pdo))->run();
        break;

    default:
        http_response_code(400);
        exit('Neznáma akcia.');
}