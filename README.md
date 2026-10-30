
# StockManager

**Noliktavas pārvaldības informācijas sistēma**

StockManager ir tīmekļa lietotne, kas paredzēta noliktavas preču uzskaitei, preču saņemšanas un izsniegšanas reģistrēšanai, klientu pasūtījumu pārvaldībai un noliktavas atlikumu kontrolei.

Projekts tiek izstrādāts programmēšanas tehniķa kvalifikācijas darba ietvaros.

**Autors:** Pēteris Šmits

## Projekta mērķis

Izstrādāt noliktavas pārvaldības informācijas sistēmu, kas atvieglo ikdienas noliktavas darbu, samazina manuālās uzskaites kļūdas un nodrošina pārskatāmu informāciju par precēm, pasūtījumiem un noliktavas atlikumiem.

## Galvenās funkcionalitātes

### Preču pārvaldība
- Preču pievienošana un rediģēšana.
- Preču kategoriju pārvaldība.
- Preču attēlu pievienošana.
- Minimālā noliktavas atlikuma norādīšana.
- Preču atrašanās vietu uzskaite.

### Noliktavas struktūra
- Noliktavas atrašanās vietu pārvaldība.
- Hierarhiska atrašanās vietu struktūra.
- Preču piesaiste konkrētām atrašanās vietām.

### Preču saņemšana
- Pavadzīmju reģistrēšana.
- Vairāku preču pievienošana pavadzīmei.
- Automātiska noliktavas atlikumu palielināšana.
- Saņemšanas vēstures apskate.
- Nederīgu un dublētu preču pozīciju pārbaude.

### Pasūtījumi un preču izsniegšana
- Klientu pasūtījumu izveide.
- Preču rezervēšana pasūtījumiem.
- Pasūtījumu statusu pārvaldība.
- Manuāla preču izsniegšana.
- Automātiska atlikumu samazināšana.
- Rezervēto preču aizsardzība.
- Izsniegšanas vēstures apskate.

### Inventarizācija un atskaites
- Noliktavas atlikumu pārbaude.
- Inventarizācijas un atlikumu korekciju uzskaite.
- Noliktavas atskaišu sagatavošana.
- Atskaišu eksportēšana PDF un Excel formātā.

### Papildu iespējas
- Lietotāju autentifikācija.
- Administratora un darbinieka lomas.
- Pārskata panelis.
- Iepirkumu plānošana.
- Gaišais un tumšais režīms.
- Sarakstu lapošana.
- Datu validācija.

## Izmantotās tehnoloģijas

| Tehnoloģija | Pielietojums |
|---|---|
| PHP | Servera puses programmēšana |
| Laravel | Tīmekļa lietotnes ietvars |
| MySQL | Datubāze |
| Blade | Lietotāja saskarnes veidnes |
| HTML | Lapu struktūra |
| Tailwind CSS | Dizains |
| JavaScript | Interaktīvās funkcijas |
| Composer | PHP atkarību pārvaldība |
| Node.js un npm | Frontend atkarības |
| Vite | Frontend resursu apstrāde |
| Git | Versiju kontrole |

## Sistēmas prasības

Nepieciešams:

- PHP versija, kas atbilst `composer.json` prasībām.
- Composer.
- MySQL serveris.
- Node.js un npm.
- Tīmekļa pārlūkprogramma.
- Lokālā izstrādes vide, piemēram, Laragon.

## Projekta uzstādīšana

### 1. Projekta iegūšana

Lejupielādē projektu vai klonē Git repozitoriju.

Atver projekta mapi terminālī.

### 2. PHP atkarību instalēšana

```bash
composer install
```

### 3. Vides konfigurēšana

Izveido `.env` failu, nokopējot `.env.example`.

Windows vidē:

```powershell
Copy-Item .env.example .env
```

Ģenerē lietotnes atslēgu:

```bash
php artisan key:generate
```

### 4. Datubāzes konfigurēšana

Izveido MySQL datubāzi ar nosaukumu `stockmanager`.

Failā `.env` norādi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stockmanager
DB_USERNAME=root
DB_PASSWORD=
```

Norādītās datubāzes vērtības ir piemērs lokālai Laragon videi.

### 5. Demonstrācijas kontu konfigurēšana

Failā `.env` pievieno:

```env
STOCKMANAGER_ADMIN_PASSWORD="aDMin1!parolE"
STOCKMANAGER_EMPLOYEE_PASSWORD="Emp1oyee!parolE"
```

Šīs paroles paredzētas tikai lokālai demonstrācijas un testēšanas videi.

### 6. Datubāzes sagatavošana

Izpildi migrācijas:

```bash
php artisan migrate
```

Izveido demonstrācijas lietotājus:

```bash
php artisan db:seed
```

`DatabaseSeeder` izsauc:

- `AdminUserSeeder`
- `EmployeeUserSeeder`

Šie seederi izveido administratora un darbinieka kontus, ja tie vēl neeksistē.

**Piezīme:** Seederi izmanto `firstOrCreate()`. Ja lietotāji ar šiem e-pastiem jau eksistē, atkārtota seederu izpilde viņu paroles nemainīs.

### 7. Failu glabātuves konfigurēšana

```bash
php artisan storage:link
```

### 8. Frontend atkarību instalēšana

```bash
npm install
```

### 9. Frontend servera palaišana

```bash
npm run dev
```

### 10. Laravel servera palaišana

Atver otru termināli:

```bash
php artisan serve
```

Atver pārlūkprogrammā:

http://127.0.0.1:8000

## Demonstrācijas konti

Sistēmas pārbaudei ir paredzēti divi lietotāju konti.

### Administrators

**E-pasts:** `admin@stockmanager.lv`

**Parole:** `aDMin1!parolE`

**Loma:** `admin`

Administrators ir paredzēts sistēmas pārvaldībai.

### Darbinieks

**E-pasts:** `employee@stockmanager.lv`

**Parole:** `Emp1oyee!parolE`

**Loma:** `employee`

Darbinieks ir paredzēts ikdienas noliktavas darbību veikšanai.

### Svarīgi

Šie konti ir paredzēti tikai kvalifikācijas darba demonstrācijai un lokālai testēšanai.

Publiskā produkcijas vidē jāizmanto citas, drošas paroles.

## Sistēmas lietošana

1. Atver StockManager pārlūkprogrammā.
2. Pieslēdzies ar administratora vai darbinieka kontu.
3. Izveido preču kategorijas un noliktavas atrašanās vietas.
4. Pievieno preces.
5. Reģistrē preču saņemšanu.
6. Izveido klientu pasūtījumus.
7. Izsniedz pasūtījumos rezervētās preces.
8. Apskati izsniegšanas vēsturi.
9. Pārbaudi noliktavas atlikumus un atskaites.

## Datu integritāte un drošība

Sistēmā izmantoti vairāki datu aizsardzības mehānismi:

- Lietotāju autentifikācija.
- Lietotāju lomas.
- Servera puses datu validācija.
- Rezervēto preču atlikumu pārbaude.
- Datubāzes transakcijas.
- `lockForUpdate()` vienlaicīgu darbību apstrādei.
- Aizsardzība pret negatīvu noliktavas atlikumu.
- Dublētu preču pozīciju pārbaude.
- Paroļu glabāšana datubāzē jauktā veidā, izmantojot Laravel `Hash`.

## Testēšana

Laravel automātiskos testus var palaist ar:

```bash
php artisan test
```

Manuāli pārbaudītie scenāriji:

- Rezervēto preču manuālas izsniegšanas bloķēšana.
- Servera atteikums, ja nav pietiekama brīvā atlikuma.
- Klienta pasūtījuma izsniegšana.
- Noliktavas atlikuma samazināšana pēc izsniegšanas.
- Izsniegšanas bloķēšana, ja atlikums ir 0.
- Eksistējoša klienta pasūtījuma numura izmantošanas aizliegums manuālai izsniegšanai.
- Preču saņemšana ar nederīgu daudzumu.
- Vienas preces atkārtotas pievienošanas bloķēšana pavadzīmē.

## Projekta struktūra

```text
app/
  Http/
    Controllers/
  Models/

database/
  migrations/
  seeders/
    DatabaseSeeder.php
    AdminUserSeeder.php
    EmployeeUserSeeder.php

resources/
  views/

routes/
  web.php

public/
storage/
tests/
```

## Projekta statuss

StockManager tiek izstrādāts programmēšanas tehniķa kvalifikācijas darba ietvaros.

## Autors

**Pēteris Šmits**

Programmēšanas tehniķa kvalifikācijas darbs.
