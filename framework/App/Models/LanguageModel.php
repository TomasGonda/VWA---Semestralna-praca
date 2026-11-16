<?php

namespace App\Models;

use Framework\Core\Model;

class LanguageModel extends Model
{
    protected static ?string $tableName = 'languages';
    protected static ?string $primaryKey = 'id';

    public ?int $id = null;
    public ?string $code = null;
    public ?string $name = null;

    public function getTranslations(string $language): array
    {
        $languages = self::getAll(
            'code = :code',
            ['code' => $language],
            null,
            1
        );

        $languageModel = $languages[0] ?? null;

        if ($languageModel === null) {
            return [];
        }
        //var_dump($languageModel);
        //exit;

        $translations = $languageModel->getAllRelated(
            TranslationModel::class,
            'language_id'
        );

        $result = [];

        foreach ($translations as $translation) {
            $result[$translation->translationKey] =
                $translation->translationValue;
        }

        return $result;
    }
}
