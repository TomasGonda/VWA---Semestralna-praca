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

        if (!$user->isLoggedIn()) {
            return false;
        }

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

        $adminModel = new AdminModel();
        $admin = $adminModel->getAdminByUsername($username);

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            return $this->redirect(
                $this->url('auth.adminLogin') . '&error=invalid_credentials'
            );
        }

        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['role'] = $admin['role'];

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
            return $this->redirect($this->url('admin.adminFormular'));
        }

        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return $this->redirect($this->url('admin.adminFormular'));
        }

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $isResolved = filter_var($_POST['is_resolved'] ?? null, FILTER_VALIDATE_INT);

        if (
            $id === false || $id === null || $id <= 0 ||
            !in_array($isResolved, [0, 1], true)
        ) {
            return $this->redirect($this->url('admin.adminFormular'));
        }

        ContactModel::updateMessageStatus($id, $isResolved);

        return $this->redirect($this->url('admin.adminFormular'));
    }

    public function deleteMessage(Request $request): Response
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect($this->url('admin.adminFormular'));
        }

        $sessionToken = $_SESSION['csrf_token'] ?? '';
        $submittedToken = $_POST['csrf_token'] ?? '';

        if (
            !is_string($sessionToken) ||
            !is_string($submittedToken) ||
            $sessionToken === '' ||
            !hash_equals($sessionToken, $submittedToken)
        ) {
            return $this->redirect($this->url('admin.adminFormular'));
        }

        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id < 1) {
            return $this->redirect($this->url('admin.adminFormular'));
        }

        ContactModel::deleteMessage($id);

        return $this->redirect($this->url('admin.adminFormular'));
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
        return $this->html([
            'translations' => $translations,
            'currentLanguage' => $currentLanguage
        ]);

    }
    public function updateLanguage(Request $request): Response
    {


        header('Content-Type: application/json; charset=utf-8');

        function respond(bool $success, string $message, int $status = 200): never
        {
            http_response_code($status);

            echo json_encode([
                'success' => $success,
                'message' => $message
            ]);

            exit;
        }

        if (!isset($_SESSION['admin_id'])) {
            respond(false, 'Nie ste prihlásený.', 401);
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
            respond(false, 'Neplatná požiadavka.', 403);
        }

        $id_sk = filter_input(INPUT_POST, 'id_sk', FILTER_VALIDATE_INT);
        $id_en = filter_input(INPUT_POST, 'id_en', FILTER_VALIDATE_INT);

        $sk = trim($_POST['sk'] ?? '');
        $en = trim($_POST['en'] ?? '');

        if (!$id_sk || !$id_en || $sk === '' || $en === '') {
            respond(false, 'Neplatné údaje.', 400);
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
        } catch (PDOException $e) {
            $pdo->rollBack();
            respond(false, 'Preklad sa nepodarilo uložiť.', 500);
        }
        respond(true, 'Preklad sa úspešne uložil.');
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

        function respond(bool $success, string $message, int $status = 200): never
        {
            http_response_code($status);

            echo json_encode([
                'success' => $success,
                'message' => $message
            ]);

            exit;
        }

        if (
            !isset($_SESSION['admin_id']) ||
            ($_SESSION['role'] ?? '') !== 'dev'
        ) {
            respond(false, 'Nemáte oprávnenie vykonať túto akciu.', 403);
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
            respond(false, 'Neplatná požiadavka.', 403);
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
            respond(false, 'Vyplňte všetky polia.', 400);
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
                respond(false, 'Tento tag už existuje.', 409);
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
            respond(false, 'Preklad sa nepodarilo vytvoriť.', 500);
        }
        respond(true, 'Preklad sa úspešne vytvoril.');
        exit;
    }

    public function deleteLanguage(Request $request): Response
    {

        if (
            !isset($_SESSION['admin_id']) ||
            !in_array($_SESSION['role'], ['admin', 'dev'], true)
        ) {
            return $this->redirect(
                $this->url('admin.adminTranslations') . '&error=invalid_role'
            );
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect(
                $this->url('admin.adminTranslations') . '&error=invalid_operation'
            );
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
                $this->url('admin.adminTranslations') . '&error=invalid_request'
            );
        }
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            return $this->redirect(
                $this->url('admin.adminTranslations') . '&error=idvalid_message_id'
            );
        }

        $pdo = Connection::getInstance();

        $sql = "Delete from translations where id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $this->redirect(
            $this->url('admin.adminTranslations') . '&success'
        );
    }
}

