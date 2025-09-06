**Indie Diva Hub**

Web aplikacija posvećena izvođačicama iz alternativne i indie glazbene scene, omogućuje pregled profila umjetnica i albuma, pisanje recenzija te predlaganje novih izvođačica.

**Funkcionalnosti**

- Registracija i prijava korisnika
- Admin panel za pregled prijedloga
- Pregled profila umjetnica i albuma
- Dodavanje recenzija
- Predlaganje novih izvođačica
- Newsletter forma (frontend-only)
- Responzivan dizajn

**Tehnologije**

Frontend: HTML5, CSS3, JavaScript
Backend: PHP 8+, MySQL/MariaDB (PDO)
Dev okruženje: XAMPP
Deploy: Render, Vercel, PlanetScale

**Pokretanje lokalno**
git clone https://github.com/romanuspopulsque/IndieDivaHub.git
Pokreni Apache i MySQL u XAMPP-u
U phpMyAdmin kreiraj bazu indie_diva_hub
Uvezi datoteku indie_diva_hub.sql
U db.php provjeri podatke za konekciju:
$pdo = new PDO("mysql:host=localhost;dbname=indie_diva_hub;charset=utf8mb4", "root", "");

Otvori aplikaciju na http://localhost/IndieDivaHub/

Admin login (testni korisnik)
Username	Lozinka
admin	admin

Lozinka je hashirana pomoću MD5 (demo verzija).

Struktura projekta
IndieDivaHub/
├── index.php              # Početna
├── umjetnica.php          # Profil izvođačice
├── dodaj_recenziju.php    # Recenzije
├── prijedlozi.php         # Novi prijedlozi
├── admin.php              # Admin panel
├── register.php / login.php / logout.php
├── db.php                 # Baza
├── style.css              # Stilovi
├── indie_diva_hub.sql     # SQL baza
└── README.md

_Projekt je izrađen kao studentski rad za kolegij Programiranje 1 (mentor: prof. dr. sc. Boris Badurina), uz korištenje ChatGPT-a za podršku u pisanju koda i dokumentacije._
