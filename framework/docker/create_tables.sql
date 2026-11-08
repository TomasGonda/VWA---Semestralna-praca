/*Tabuľka jazokov a ich kódov, primárne sa bude primárny kľuč z tejto tabuľky používať v kompozitnom kľúči v tabuľke Preklady*/

CREATE TABLE Languages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(5) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE Translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    language_id INT UNSIGNED NOT NULL,
    translation_key VARCHAR(100) NOT NULL,
    translation_value TEXT NOT NULL,

    CONSTRAINT fk_translation_language
        FOREIGN KEY (language_id)
        REFERENCES Languages(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    UNIQUE (language_id, translation_key)
);

