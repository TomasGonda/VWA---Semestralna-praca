<?php

namespace App\Models;

use Framework\DB\Connection;

class LanguageModel
{
    public function getTranslations(string $language): array
    {
        $db = Connection::getInstance();

        /*$stmt = $db->query("Select database() as db_name;");
        $database = $stmt->fetch();

        error_log("Aktualna databaza: " . print_r($database, true));
        error_log("Poziadany jazyk: ". $language);

        $stmt = $db->query("
            SELECT l.code, t.translation_key, t.translation_value
            FROM Languages l
            JOIN Translations t ON t.language_id = l.id
        ");*/
        $stmt = $db->prepare("
            select t.translation_key, t.translation_value
            from languages l
            join translations t on t.language_id = l.id
            where l.code = :language;
        ");

        $stmt->execute(['language' => $language]);

        //return $stmt->fetchAll();
        
        $translations = [];

        while ($row =$stmt->fetch()) {
            $translations[$row['translation_key']] = $row['translation_value'];
        }

        /*$rows = $stmt->fetchAll();

        error_log('Vsetky preklady: ' . print_r($rows, true));

        $translations = [];

        foreach ($rows as $row) {
            if ($row['code'] === $language) {
                $translations[$row['translation_key']] = $row['translation_value'];
            }
        }*/

        return $translations;
    }
}