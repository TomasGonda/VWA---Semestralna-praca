<?php

namespace App\Models;

use Framework\Core\Model;

class TranslationModel extends Model
{
    protected static ?string $tableName = 'translations';
    protected static ?string $primaryKey = 'id';

    public ?int $id = null;
    public ?int $languageId = null;
    public ?string $translationKey = null;
    public ?string $translationValue = null;

    protected static array $columnsMap = [
        'language_id' => 'languageId',
        'translation_key' => 'translationKey',
        'translation_value' => 'translationValue',
    ];

    public function getLanguage(): ?LanguageModel
    {
        return $this->getOneRelated(
            LanguageModel::class,
            'language_id'
        );
    }
}
