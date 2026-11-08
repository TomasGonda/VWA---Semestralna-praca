<?php

namespace App\Models;

use Framework\DB\Connection;

class AdminModel
{
    public function getAdminByUsername(string $username): ?array
    {
        $db = Connection::getInstance();

        $stmt = $db->prepare("
            SELECT id, username, password_hash
            FROM admins
            WHERE username = :username
            LIMIT 1
        ");

        $stmt->execute(['username' => $username]);

        $admin = $stmt->fetch();

        return $admin ?: null;
    }

    public function getContactMessages(): array
    {
        $db = Connection::getInstance();

        $stmt = $db->query("
        SELECT
            id,
            first_name,
            last_name,
            email,
            phone,
            note,
            gdpr_consent,
            created_at,
            is_resolved
        FROM contact
        ORDER BY created_at DESC
    ");

        return $stmt->fetchAll();
    }

    public function updateMessageStatus(int $id, int $isResolved): void
    {
        $db = Connection::getInstance();

        $stmt = $db->prepare("
        UPDATE contact
        SET is_resolved = :is_resolved
        WHERE id = :id
    ");

        $stmt->execute([
            'is_resolved' => $isResolved,
            'id' => $id
        ]);
    }

    public function deleteMessage(int $id): void
    {
        $db = Connection::getInstance();

        $stmt = $db->prepare("
        DELETE FROM contact
        WHERE id = :id
    ");

        $stmt->execute([
            'id' => $id
        ]);
    }
}
