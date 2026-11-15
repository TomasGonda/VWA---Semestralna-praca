<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\DB\Connection;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Models\ContactModel;
use App\Models\LanguageModel;

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
        error_log('CONTACT LANGUAGE: ' . $request->post('language'));
        $language = (string) $request->post('language');

        if (!in_array($language, ['sk', 'en'], true)) {
            $language = 'sk';
        }

        $respond = function (string $key, bool $success = false) use ($language): Response {

            $languageModel = new LanguageModel();

            $translations = $languageModel->getTranslations($language);

            /*return $this->json({
                'debug_language' => $language,
                'debug_success' => $translations['contact_success'] ?? 'NENAJDENY',
                'debug_error' => $translations['contact_error'] ?? 'NENAJDENY'
            });*/

            error_log('LANGUAGE: ' . $language);
            error_log('TRANSLATION: ' . ($translations['contact_invalid_phone'] ?? 'NOT FOUND'));
            $messageKey = $key;

            $message = $translations[$messageKey] ?? (
                $language === 'en'
                ? 'An error occurred. Please try again.'
                : 'Nastala chyba. Skúste to znova.'
            );

            return $this->json([
                'success' => $success,
                'message' => $message,
                /*'debug_translation' => $translations['contact_success'] ?? 'PREKLAD NENAJDENY',
                'message' => $translations['contact_success'] ?? 'PREKLAD NENAJDENY',*/
                /*'success' => true,
                'message' => 'TEST ENGLISH',
                'debug_language' => $language*/

                /*'debug_language' => $language,
                'debug_success' => $translations['contact_success'] ?? 'NENAJDENY',
                'debug_error' => $translations['contact_error'] ?? 'NENAJDENY'*/
            ]);
        };

        if (!$request->isPost()) {
            return $respond('contact_error');
        }

        $firstName = trim((string) $request->post('first_name'));
        $lastName = trim((string) $request->post('last_name'));
        $email = trim((string) $request->post('email'));
        $phone = trim((string) $request->post('phone'));
        $note = trim((string) $request->post('note'));

        $gdprConsent = $request->post('gdpr') ? 1 : 0;

        if (
            $firstName === '' ||
            $lastName === '' ||
            $email === '' ||
            $phone === '' ||
            $note === ''
        ) {
            return $respond('contact_required');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $respond('contact_invalid_email');
        }

        if (!preg_match('/^\+[1-9][0-9]{0,2}(?:[ ]?[0-9]){6,12}$/', $phone)) {
            return $respond('contact_invalid_phone');
        }

        if (
            mb_strlen($firstName) > 100 ||
            mb_strlen($lastName) > 100 ||
            mb_strlen($email) > 254 ||
            mb_strlen($phone) > 30 ||
            mb_strlen($note) > 5000
        ) {
            return $respond('contact_too_long');
        }

        if ($gdprConsent !== 1) {
            return $respond('gdpr_consent');
        }

        try {
            $model = new ContactModel();

            $success = $model->create(
                $firstName,
                $lastName,
                $email,
                $phone,
                $note,
                $gdprConsent
            );

            if (!$success) {
                return $respond('contact_error');
            }

            return $respond('contact_success', true);

        } catch (\PDOException $e) {
            return $respond('contact_error');
        }
    }


    /*$language = $_SESSION['lang'] ?? 'sk';

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

    return $this->json([
        'success' => $success,
        'message' => $success
            ? 'Správa bola úspešne odoslaná.'
            : 'Správu sa nepodarilo odoslať.'
    ]);
}*/
}