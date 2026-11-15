<?php

namespace App\Models;

use Framework\DB\Connection;

class ContactModel
{
    public function create(
        string $firstName,
        string $lastName,
        string $email,
        ?string $phone,
        ?string $note,
        int $gdprConsent
    ): bool {
        $db = Connection::getInstance();

        $stmt = $db->prepare("
        INSERT INTO contact
            (first_name, last_name, email, phone, note, gdpr_consent)
        VALUES
            (:first_name, :last_name, :email, :phone, :note, :gdpr_consent)
    ");

        return $stmt->execute([
            'first_name' => $firstName, 
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'note' => $note,
            'gdpr_consent' => $gdprConsent
        ]);
    }
}