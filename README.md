Naravno! Evo skraćene, čišće i još atraktivnije verzije tvog README-ja — zadržao sam sve bitne informacije, ali skratio tekst, izbacio višak i dotjerao markdown da izgleda 🔥:

````markdown
# 🎤 Indie Diva Hub

Indie Diva Hub je web aplikacija posvećena moćnim ženskim glasovima iz alternativne i indie scene. Omogućuje pregled profila umjetnica, albuma, recenzije i prijedloge novih izvođačica. 🌸✨

![Screenshot](https://upload.wikimedia.org/wikipedia/en/f/f1/Caroline_Polachek_-_Pang.png)

---

## 💡 Glavne funkcionalnosti

- 👤 Registracija i prijava
- 👑 Admin panel za prijedloge
- 🎶 Pregled umjetnica i albuma
- 📝 Recenzije
- 📩 Predlaganje novih izvođačica
- 📬 Newsletter forma (frontend-only)
- 🎨 Responsive girly dizajn

---

## 🛠 Tehnologije

- **Frontend**: HTML5, CSS3 (custom + Google Fonts), JS
- **Backend**: PHP 8+, MySQL/MariaDB (PDO)
- **Dev okruženje**: [XAMPP](https://www.apachefriends.org/)
- **Deploy**: Render, Vercel, PlanetScale

---

## 🚀 Lokalna instalacija

```bash
git clone https://github.com/romanuspopulsque/IndieDivaHub.git
````

1. Pokreni Apache/MySQL u XAMPP-u
2. Kreiraj bazu `indie_diva_hub` u phpMyAdmin
3. Uvezi `indie_diva_hub.sql`
4. U `db.php` provjeri podatke za konekciju:

```php
$pdo = new PDO("mysql:host=localhost;dbname=indie_diva_hub;charset=utf8mb4", "root", "");
```

5. Otvori u pregledniku:
   `http://localhost/IndieDivaHub/`

---

## 🔐 Admin login (testni user)

| Username | Lozinka |
| -------- | ------- |
| `admin`  | `admin` |

> (Lozinka hashirana s MD5 – demo verzija)

---

## 📁 Struktura

```
IndieDivaHub/
├── index.php              # Početna
├── umjetnica.php          # Profil izvođačice
├── dodaj_recenziju.php    # Recenzije
├── prijedlozi.php         # Novi prijedlozi
├── admin.php              # Admin panel
├── register.php / login.php / logout.php
├── db.php                 # Baza
├── style.css              # Stilovi 💅
├── indie_diva_hub.sql     # SQL baza
└── README.md
```

---

## 🎨 Stil

* **Boje**: `#ffeef8`, `#d64191`, `#f8a1d1 → #f9c5d1`
* **Font**: [Poppins](https://fonts.google.com/specimen/Poppins)
* **Dizajn**: Mobilno-friendly, soft girl indie vibes

---

## 🙌 Credits

Projekt izrađen pomoću ChatGPT-a – kao podrška kodiranju, idejama i bržoj izradi.

> Sviđa ti se? Ostavi ⭐, forkaj ili dodaj još diva! Indie + kod = 🫶

```

```
