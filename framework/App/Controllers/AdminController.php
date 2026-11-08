<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Models\AdminModel;

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
        if (in_array($action, ['adminLogin', 'loginProcess'], true)) {
            return true;
        }

        return isset($_SESSION['admin_id']);
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
                $this->url('admin.adminLogin') . '&error=invalid_csrf_token'
            );
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            return $this->redirect(
                $this->url('admin.adminLogin') . '&error=empty_fields'
            );
        }

        $adminModel = new AdminModel();
        $admin = $adminModel->getAdminByUsername($username);

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            return $this->redirect(
                $this->url('admin.adminLogin') . '&error=invalid_credentials'
            );
        }

        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        return $this->redirect($this->url('home.index'));
    }

    public function adminLogin(Request $request): Response
    {
        return $this->html();
    }

    public function adminFormular(Request $request): Response
    {
        $adminModel = new AdminModel();
        $messages = $adminModel->getContactMessages();

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

        $adminModel = new AdminModel();
        $adminModel->updateMessageStatus($id, $isResolved);

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

        $adminModel = new AdminModel();
        $adminModel->deleteMessage($id);

        return $this->redirect($this->url('admin.adminFormular'));
    }

    public function logout(Request $request): Response
{
    $_SESSION = [];

    session_destroy();

    return $this->redirect($this->url('home.index'));
}
}
