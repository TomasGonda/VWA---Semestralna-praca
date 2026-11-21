<?php

namespace App\Models;

use Framework\DB\Connection;
use App\Models\ContactModel;

class AdminModel
{
    public function getAdminByUsername(string $username): ?array
    {
        $db = Connection::getInstance();

        $stmt = $db->prepare("
            SELECT id, username, password_hash, role
            FROM admins
            WHERE username = :username
            LIMIT 1
        ");

        $stmt->execute(['username' => $username]);

        $admin = $stmt->fetch();

        return $admin ?: null;
    }
}
