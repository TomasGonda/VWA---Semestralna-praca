<?php

namespace App\Auth;

use Framework\Auth\SessionAuthenticator;
use Framework\Core\App;
use Framework\Core\IIdentity;
use App\Models\AdminModel;

class AdminAuthenticator extends SessionAuthenticator
{
    private AdminModel $adminModel;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->adminModel = new AdminModel();
    }

    protected function authenticate(string $username, string $password): ?IIdentity
    {
        $admin = $this->adminModel->getAdminByUsername($username);

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            return null;
        }

        return new AdminIdentity(
            (int) $admin['id'],
            $admin['username'],
            $admin['role']
        );
    }
}