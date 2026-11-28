<?php
class AdminController
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function checkPermission(array $roles): bool
    {
        if (
            !isset($_SESSION['admin_id']) ||
            !in_array($_SESSION['admin_role'] ?? '', $roles, true)
        ) {
            return false;
        } else {
            return true;
        }
    }

    protected function checkPostMethod(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        } else {
            return true;
        }
    }

    protected function csrfCheck(): bool
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

    protected function idCheck(int $id): bool
    {
        if (!$id || $id < 1) {
            return false;
        } else {
            return true;
        }
    }

    protected function respond(
        bool $success,
        string $message,
        int $status = 200
    ): never {
        http_response_code($status);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);

        exit;
    }
}