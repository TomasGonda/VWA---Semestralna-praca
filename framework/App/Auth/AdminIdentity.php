<?php

namespace App\Auth;

use Framework\Core\IIdentity;

class AdminIdentity implements IIdentity
{
    private int $id;
    private string $username;
    private string $role;

    public function __construct(int $id, string $username, string $role)
    {
        $this->id = $id;
        $this->username = $username;
        $this->role = $role;
    }

    public function getName(): string
    {
        return $this->username;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}