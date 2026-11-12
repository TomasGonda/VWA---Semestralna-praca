<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Models\ContactModel;

class ContactController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function submit(Request $request): Response
    {
        $language = $_SESSION['lang'] ?? 'sk';

        if (!$request->isPost()) {
            header('Location: ?c=contact&a=contact&lang=' . $language . '&contact=invalid_request#contact');
            exit;
        }

        $firstName = trim((string) $request->post('first_name'));
        $lastName = trim((string) $request->post('last_name'));
        $email = trim((string) $request->post('email'));
        $phone = trim((string) $request->post('phone'));
        $note = trim((string) $request->post('note'));

        $gdprConsent = $request->post('gdpr') ? 1 : 0;

        if ($firstName === '' || $lastName === '' || $email === '') {
            header('Location: ?c=home&a=contact&lang=' . $language . '&contact=required#contact');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: ?c=home&a=contact&lang=' . $language . '&contact=invalid_email#contact');
            exit;
        }

        if ($gdprConsent !== 1) {
            header('Location: ?c=home&a=contact&lang=' . $language . '&contact=gdpr_required#contact');
            exit;
        }
        $phone = $phone !== '' ? $phone : null;
        $note = $note !== '' ? $note : null;

        $model = new ContactModel();

        $success = $model->create(
            $firstName,
            $lastName,
            $email,
            $phone,
            $note,
            $gdprConsent
        );

        $status = $success ? 'success' : 'error';

        header('Location: ?c=home&a=index&lang=' . $language . '&contact=' . $status . '#contact');
        exit;
    }
}