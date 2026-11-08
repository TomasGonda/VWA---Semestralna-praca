<?php
require_once __DIR__ . '/../databaseConections/database.php';

class LanguageModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getTranslations(string $language): array
    {
        $stmt = $this->db->prepare("
            SELECT t.translation_key, t.translation_value
            FROM Languages l
            JOIN Translations t ON t.language_id = l.id
            WHERE l.code = :language
        ");

        $stmt->execute([
            'language' => $language
        ]);

        $translations = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $translations[$row['translation_key']] = $row['translation_value'];
        }

        return $translations;
    }
}