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
        ?string $note
    ): bool {
        $db = Connection::getInstance();

        $stmt = $db->prepare("
            INSERT INTO Contact
                (first_name, last_name, email, phone, note)
            VALUES
                (:first_name, :last_name, :email, :phone, :note)
        ");

        return $stmt->execute([
            'first_name' => $firstName, 
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'note' => $note
        ]);
    }
}