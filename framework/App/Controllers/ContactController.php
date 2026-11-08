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
        if (!$request->isPost()) {
            return $this->json([
                'status' => 'error',
                'message' => 'Neplatná požiadavka.'
            ]);
        }
        $firstName = trim((string) $request->post('first_name'));
        $lastName = trim((string) $request->post('last_name'));
        $email = trim((string) $request->post('email'));
        $phone = trim((string) $request->post('phone'));
        $note = trim((string) $request->post('note'));

        if ($firstName === '' || $lastName === '' || $email === '') {
            return $this->json([
                'status' => 'error',
                'message' => 'Vyplňte všetky povinné polia.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->json([
                'status' => 'error',
                'message' => 'Zadaná e-mailová adresa nie je platná.'
            ]);
        }
        $phone = $phone !== '' ? $phone : null;
        $note = $note !== '' ? $note : null;

        $model = new ContactModel();

        $success = $model->create(
            $firstName,
            $lastName,
            $email,
            $phone,
            $note
        );

        return $this->json([
            'status' => $success ? 'success' : 'error',
            'message' => $success
                ? 'Správa bola úspešne odoslaná.'
                : 'Správu sa nepodarilo odoslať.'
        ]);
    }
}