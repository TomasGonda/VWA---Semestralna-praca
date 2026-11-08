/*insert (using phpmyadmin) */

insert into languages (code, name) VALUES ('sk', 'Slovenčina');
insert into languages (code, name) VALUES ('en', 'English');

INSERT INTO Translations (language_id, translation_key, translation_value)
VALUES
    (1, 'contact', 'Kontakt'),
    (1, 'about', 'O nás'),
    (2, 'contact', 'Contact'),
    (2, 'about', 'About us');

INSERT INTO Translations (language_id, translation_key, translation_value)
VALUES
    (1, 'title', 'Športové výsledkové tabule'),
    (1, 'cart', 'Košík'),
    (2, 'title', 'Scoreboards for all sports'),
    (2, 'cart', 'Cart');

INSERT INTO Translations (language_id, translation_key, translation_value) 
VALUES 
    (1, 'search', 'Hľadať'), 
    (1, 'menu_sport_tables', 'Športové tabule'), 
    (1, 'search_placeholder', 'Vyhľadávanie'), 
    (2, 'search', 'Search'), 
    (2, 'menu_sport_tables', 'Scoreboards'), 
    (2, 'search_placeholder', 'Search');

INSERT INTO Translations (language_id, translation_key, translation_value)
VALUES
    (1, 'menu_stop_watch', 'Stopky'),
    (1, 'menu_basketball', 'Basketball'),
    (1, 'menu_utilities', 'Príslušenstvo'),
    (2, 'menu_stop_watch', 'Stop Watch'),
    (2, 'menu_basketball', 'Basketball'),
    (2, 'menu_utilities', 'Utilities');

INSERT INTO Translations (language_id, translation_key, translation_value)
VALUES
    (1, 'first_name_label', 'Meno'),
    (1, 'first_name_placeholder', 'Zadajte meno'),
    (1, 'last_name_label', 'Priezvisko'),
    (1, 'last_name_placeholder', 'Zadajte priezvisko'),
    (1, 'email_label', 'E-mail'),
    (1, 'email_placeholder', 'Email'),
    (1, 'phone_label', 'Telefón'),
    (1, 'phone_placeholder', '+421 900 123 456'),
    (1, 'note_label', 'Poznámka'),
    (1, 'note_placeholder', 'Poznámka pre firmu'),
    (1, 'submit_button', 'Odoslať'),

    (2, 'first_name_label', 'First name'),
    (2, 'first_name_placeholder', 'Enter your first name'),
    (2, 'last_name_label', 'Last name'),
    (2, 'last_name_placeholder', 'Enter your last name'),
    (2, 'email_label', 'E-mail'),
    (2, 'email_placeholder', 'Email'),
    (2, 'phone_label', 'Phone'),
    (2, 'phone_placeholder', '+421 900 123 456'),
    (2, 'note_label', 'Note'),
    (2, 'note_placeholder', 'Message for the company'),
    (2, 'submit_button', 'Send');

INSERT INTO Translations (language_id, translation_key, translation_value)
VALUES
    (1, 'contact_info_title', 'Kontaktujte nás'),
    (1, 'contact_info_address', 'Adresa:
        Na Stráňach 6
        971 01 PRIEVIDZA
        Slovenská republika'),
    (1, 'contact_info_phone', 'Telefón:
        +421 905 627 189'),
    (1, 'contact_info_email', 'E-Mail:
        info@lgr.sk'),
    (2, 'contact_info_title', 'Contact us'),
    (2, 'contact_info_address', 'Address:
        Na Stráňach 6
        971 01 PRIEVIDZA
        Slovakia'),
    (2, 'contact_info_phone', 'Phone:
    +421 905 627 189'),
    (2, 'contact_info_email', 'E-mail:
    info@lgr.sk');

INSERT INTO Translations (language_id, translation_key, translation_value)
VALUES
    (1, 'gdpr_consent', 'Súhlasím so spracovaním osobných údajov.'),
    (2, 'gdpr_consent', 'I agree to the processing of my personal data.');

INSERT INTO Translations (language_id, translation_key, translation_value) 
VALUES 
    (1, 'documents', 'Dokumenty'), 
    (2, 'documents', 'Documents');

/*Debug*/

SELECT * FROM languages l join translations t using (t.language_id = l.id) where l.id = 1;

/*Alter*/

ALTER TABLE contact
ADD COLUMN gdpr_consent TINYINT(1) NOT NULL DEFAULT 0;

