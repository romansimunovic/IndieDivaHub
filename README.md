````markdown
# 🎤 Indie Diva Hub

**Indie Diva Hub** je web aplikacija posvećena moćnim ženskim glasovima alternativne i indie glazbe. Omogućuje korisnicima pregled profila umjetnica, njihovih albuma, kao i ostavljanje recenzija. Također, svatko može predložiti novu izvođačicu za uvrštavanje u bazu. 🌸✨

![Screenshot](https://upload.wikimedia.org/wikipedia/en/f/f1/Caroline_Polachek_-_Pang.png)

## 💡 Funkcionalnosti

- ✅ Registracija i prijava korisnika
- 👑 Admin panel za upravljanje prijedlozima
- 🎶 Pregled umjetnica i albuma
- 📝 Recenzije albuma i izvođačica
- 📩 Predlaganje novih izvođačica
- 📬 Newsletter forma (frontend-only)
- 🎨 Girly pink dizajn s responsive layoutom

---

## 🛠 Tehnologije

- **Frontend**: HTML5, CSS3 (custom + Google Fonts), JavaScript
- **Backend**: PHP 8+, MySQL/MariaDB (PDO)
- **Okruženje za razvoj**: [XAMPP](https://www.apachefriends.org/) (Apache + phpMyAdmin)
- **Deploy-friendly**: Render, Vercel (frontend), PlanetScale (MySQL)

---

## 🧪 Instalacija (lokalno)

1. Kloniraj repozitorij:

```bash
git clone https://github.com/romanuspopulsque/IndieDivaHub.git
````

2. Pokreni lokalni server putem [XAMPP](https://www.apachefriends.org/).

3. Kreiraj bazu u **phpMyAdmin** pod nazivom: `indie_diva_hub`

4. Uvezi SQL strukturu iz:

   * [`indie_diva_hub.sql`](indie_diva_hub.sql)

5. Uredi `db.php` ako koristiš druge podatke:

```php
$pdo = new PDO("mysql:host=localhost;dbname=indie_diva_hub;charset=utf8mb4", "root", "");
```

6. Pokreni aplikaciju putem:

   ```
   http://localhost/IndieDivaHub/
   ```

---

## 👤 Admin Pristup (testni korisnik)

| Korisničko ime | Lozinka |
| -------------- | ------- |
| `admin`        | `admin` |

(lozinka je hashirana u bazi; koristi se MD5 u ovoj demo verziji)

---

## 📁 Struktura projekta

```
IndieDivaHub/
│
├── index.php                  # Početna stranica s popisom umjetnica
├── umjetnica.php              # Profil izvođačice
├── dodaj_recenziju.php        # Unos recenzije
├── prijedlozi.php             # Predlaganje izvođačica
├── admin.php                  # Admin panel za odobravanje prijedloga
│
├── register.php / login.php / logout.php
├── db.php                     # Konekcija na bazu podataka
├── style.css                  # Glavni stilovi (girly indie vibes 💅)
├── indie_diva_hub.sql         # SQL struktura i sample podaci
└── README.md
```

---

## 🎨 UI Stil

Korištene boje:

* Pozadina: `#ffeef8`
* Akcent: `#d64191` (indie pink)
* Gradijent header: `#f8a1d1 → #f9c5d1`
* Font: [Poppins](https://fonts.google.com/specimen/Poppins)

Responsive dizajn: prikladno za mobilne uređaje (iOS, Android), tablete i desktop.

---

## 🙌 Credits
Projekt je izrađen pomoću umjetne inteligencije (ChatGPT), korišten je radi koordinacije koda i prijedloga izmjena.
---

> Ako ti se sviđa projekt – ostavi ⭐, forkaj ga ili proširi s još diva!
> Indie glazba + kod = 🫶

```

---
