<?php

namespace App\Models;

use Framework\Core\Model;

class ContactModel extends Model
{
    protected static ?string $tableName = 'contact';
    protected static ?string $primaryKey = 'id';

    public ?int $id = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $note = null;
    public ?int $gdprConsent = 0;
    public ?string $createdAt = null;
    public ?int $isResolved = 0;

    protected static ?array $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'note',
        'gdpr_consent',
    ];

    protected static array $columnsMap = [
        'first_name' => 'firstName',
        'last_name' => 'lastName',
        'gdpr_consent' => 'gdprConsent',
        'created_at' => 'createdAt',
        'is_resolved' => 'isResolved',
    ];

    public static function create(
        string $firstName,
        string $lastName,
        string $email,
        ?string $phone,
        ?string $note,
        int $gdprConsent
    ): self {
        $contact = new self();

        $contact->firstName = $firstName;
        $contact->lastName = $lastName;
        $contact->email = $email;
        $contact->phone = $phone;
        $contact->note = $note;
        $contact->gdprConsent = $gdprConsent;
        $contact->createdAt = date('Y-m-d H:i:s');
        $contact->isResolved = 0;

        $contact->save();

        return $contact;
    }

    public static function getMessages(): array
    {
        return self::getAll(
            null,
            [],
            'created_at DESC'
        );
    }

    public static function updateMessageStatus(int $id, int $isResolved): void
    {
        $message = self::getOne($id);

        if ($message === null) {
            return;
        }

        $message->isResolved = $isResolved;
        $message->save();
    }

    public static function deleteMessage(int $id): void
    {
        $message = self::getOne($id);

        if ($message === null) {
            return;
        }

        $message->delete();
    }
}