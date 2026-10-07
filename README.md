# Firemný E-shop

Tomáš Gonda

5ZYI32

## Stručný opis projektu

Webová aplikácia bude zameraná na vylepšenie existujúceho e-shopu firmy LGR-Electronics. Jej hlavný účel bude nahradiť súčastnú nestabilnú stránku, stránkou, ktorá bude prehľadnejšia, viac používateľsky prívetivá a vo viacerých jazykoch.
Stránka sa bude deliť na dve časti a to :
1. **Výsledkové tabule** pre rôzne športy (Basketball, Futbal, Hokej...)
2. **Zimné vybavenie** pre servis lyží a snowboardov

## Role v projekte

### 1. Návštevník
    - môže prehliadať produkty a ketegórie
    - môže vyhľadávať a filtrovať produkty
    - môže si prezerať detail produktu
    - môže vytvoriť objednávku

### 2. Administrátor
    - spravuje produkty, kategórie a ich dostupnosť
    - spravuje objednávky
    - môže upravovať obsah e-shopu
    - má prístup k administrátorskej časti systému

## Prípady použitia podľa rolí

### Návštevník
    - prezerá kategórie a produkty
    - vyľadá produkt
    - pridá produkt do košíka
    - zobrazí detail produktu
    - upraví obsah košíka
    - odošle objednávku
    - vyplní kontaktné údaje
    - dostane potvrdenie o odoslaní objednávky

    Objednávka v systéme neslúži ako okamžitý nákup s online platbou. Po jej odoslaní je objednávka doručená firme, ktorá zákazníka následne kontaktuje za účelom uprestnenia potrebných špecifikácií, výslednej cene, dopravy, montáže a ďalších podmienok objednávky.

### Administrátor
    - pridá, upraví alebo odstráni produkt
    - spravuje kategórie produktov
    - upraví informácie a parametre produktov
    - zobrazí prijaté objednávky
    - zobrazí detail objednávky a kontaktné údaje zákazníka
    - spracuje prijatú objednávku
    - zmení stav objednávky
    - kontaktuje zákazníka za účelom upresnenia objednávky

## Plánované entity a vzťahy medzi nimi

### 1. Jazyk
    __Účel:__ Evidencia jazykov, v ktorých bude aplikácia dostupná
    __Atribúty:__
        - id_jazyka
        - kod (napr sk, en)
        - nazov
    __Vzťahy:__
        - 1:N s entitou Preklad produktu
        - ďalšie entity podľa potreby
### 2. Produkt
    __Účel:__ Evidencia ponúkaných produktov
    __Atribúty:__
        - id_produktu
        - cena
        - dostupnost
        - obrazok
    __Vzťahy:__
        - 1:N s Kategória
        - 1:N s Preklad produktu
        - M:N s Objednávka prostredníctvom položiek objednávky
### 3. Preklad produktu
    __Účel:__ Uchovávanie jazykových verzií názvu, popisu a iných textových údajov
    __Atribúty:__
        - id_jazyka
        - id_prekladu
        - id_produktu
        - popis
        - nazov
    __Vzťahy:__
        - 1:N s Produkt
        - 1:N s Jazyk
### 4. Kategória
    __Účel:__ Zaradenie produktov do kategórií
    __Atribúty:__
        - id_kategorie
        - nazov
        - popis
    __Vzťahy:__
        - 1:N s Produkt
### 5. Objednávka
    __Účel:__ Evidencia objednávok zadaných zákazníkmi
    __Atribúty:__
        - id_objednavky
        - datum_vytvorenia
        - stav
        - kontaktne_udaje_zakaznika
    __Vzťahy:__
        - 1:N s Polozka Objednavky
### 6. Polozka Objednavky
    __Účel:__ Evidencia produktov nachadzajucich sa v konkretnej objednavke
    __Atribúty:__
        - id_polozky
        - id_objednavky
        - id_produktu
        - mnozstvo
        - odhadovana_cena
    __Vzťahy:__
        - 1:N s Objednavka
        - 1:N s Produkt
### 7. Pouzivatelia
    __Účel:__ Evidencia používateľov s prístupom do administrátorskej časti
    __Atribúty:__
        - id_pouzivatela
        - meno
        - email
        - heslo
        - rola
    __Vzťahy:__
        ---

//TODO
## Hlavné stránky aplikácie
Uveďte zoznam najdôležitejších stránok (min. 5) alebo obrazoviek aplikácie a stručne popíšte ich účel. Nie je potrebné pripravovať kompletný grafický návrh, postačuje základná predstava o štruktúre používateľského rozhrania.

//TODO
## Rozdelenie funkcionality
Rozdeľte plánované funkcie na základné a rozširujúce. Základné funkcie predstavujú minimum potrebné na úspešné dokončenie projektu, zatiaľ čo rozširujúce funkcie môžu byť implementované navyše podľa Vašich časových možností.
