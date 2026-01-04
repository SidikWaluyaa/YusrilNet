---
description: Deploy Laravel project to cPanel using Git
---

# Deploy Laravel Project to cPanel

Workflow ini menjelaskan cara deploy project Laravel ke cPanel menggunakan Git Version Control.

## Prerequisites

-   Akses ke cPanel hosting
-   SSH access (optional, tapi sangat direkomendasikan)
-   Git repository sudah di push ke GitHub/GitLab

## Step 1: Persiapan Project Lokal

### 1.1 Pastikan semua perubahan sudah di commit

```bash
git status
```

### 1.2 Commit perubahan jika ada

```bash
git add .
git commit -m "Prepare for cPanel deployment"
```

### 1.3 Push ke GitHub

```bash
git push origin main
```

## Step 2: Setup Git di cPanel

### 2.1 Login ke cPanel

-   Buka browser dan login ke cPanel hosting Anda
-   URL biasanya: `https://yourdomain.com/cpanel` atau `https://yourdomain.com:2083`

### 2.2 Buka Git Version Control

-   Di cPanel, cari menu **"Git™ Version Control"**
-   Klik untuk membuka

### 2.3 Create Repository

-   Klik tombol **"Create"**
-   Isi form dengan informasi berikut:
    -   **Clone URL**: `https://github.com/SidikWaluyaa/YusrilNet.git`
    -   **Repository Path**: `/home/username/repositories/sidiknet` (sesuaikan dengan username cPanel Anda)
    -   **Repository Name**: `sidiknet` (atau nama yang Anda inginkan)
-   Klik **"Create"**

### 2.4 Deploy ke Public Directory

-   Setelah clone selesai, klik **"Manage"** pada repository yang baru dibuat
-   Scroll ke bawah ke bagian **"Pull or Deploy"**
-   Klik **"Update from Remote"** untuk pull perubahan terbaru
-   Kemudian klik **"Deploy HEAD Commit"**

## Step 3: Setup Laravel di cPanel

### 3.1 Akses Terminal/SSH

**Opsi A: Menggunakan Terminal di cPanel**

-   Di cPanel, cari menu **"Terminal"**
-   Klik untuk membuka terminal

**Opsi B: Menggunakan SSH Client (PuTTY, Windows Terminal, dll)**

```bash
ssh username@yourdomain.com
```

### 3.2 Navigate ke Repository Directory

```bash
cd ~/repositories/sidiknet
```

### 3.3 Install Composer Dependencies

```bash
composer install --optimize-autoloader --no-dev
```

### 3.4 Setup Environment File

```bash
cp .env.example .env
nano .env
```

Edit file `.env` dengan konfigurasi production:

```env
APP_NAME="YusrilNet"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# ... konfigurasi lainnya
```

Simpan dengan `Ctrl+X`, lalu `Y`, lalu `Enter`

### 3.5 Generate Application Key

```bash
php artisan key:generate
```

### 3.6 Setup Database

**Buat database di cPanel:**

-   Buka **"MySQL® Databases"** di cPanel
-   Buat database baru
-   Buat user baru dan assign ke database
-   Catat nama database, username, dan password

**Run migrations:**

```bash
php artisan migrate --force
```

**Seed database (jika perlu):**

```bash
php artisan db:seed --force
```

### 3.7 Setup Storage Link

```bash
php artisan storage:link
```

### 3.8 Optimize Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3.9 Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
```

## Step 4: Setup Public Directory

### 4.1 Copy Files ke Public_html

Ada beberapa cara:

**Opsi A: Symlink (Recommended)**

```bash
# Backup public_html lama jika ada
mv ~/public_html ~/public_html_backup

# Buat symlink dari repository public ke public_html
ln -s ~/repositories/sidiknet/public ~/public_html
```

**Opsi B: Copy Manual**

```bash
# Backup public_html lama
mv ~/public_html ~/public_html_backup

# Copy public folder
cp -r ~/repositories/sidiknet/public ~/public_html

# Update index.php untuk mengarah ke repository
```

### 4.2 Edit index.php di Public_html

Jika menggunakan Opsi B, edit `~/public_html/index.php`:

```bash
nano ~/public_html/index.php
```

Update path:

```php
require __DIR__.'/../repositories/sidiknet/vendor/autoload.php';
$app = require_once __DIR__.'/../repositories/sidiknet/bootstrap/app.php';
```

### 4.3 Setup .htaccess

Pastikan file `.htaccess` ada di `public_html`:

```bash
nano ~/public_html/.htaccess
```

Isi dengan:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Step 5: Setup Build Assets (Vite)

### 5.1 Build di Lokal

Di komputer lokal Anda:

```bash
npm install
npm run build
```

### 5.2 Commit dan Push Build Results

```bash
git add public/build
git commit -m "Add production build assets"
git push origin main
```

### 5.3 Pull di Server

Di terminal cPanel/SSH:

```bash
cd ~/repositories/sidiknet
git pull origin main
```

## Step 6: Testing

### 6.1 Akses Website

-   Buka browser dan akses domain Anda
-   Pastikan website berjalan dengan baik

### 6.2 Check Logs Jika Ada Error

```bash
tail -f ~/repositories/sidiknet/storage/logs/laravel.log
```

## Step 7: Update Deployment (Future Updates)

Untuk update di masa depan:

### 7.1 Di Lokal

```bash
# Commit perubahan
git add .
git commit -m "Your update message"
git push origin main
```

### 7.2 Di Server (via SSH/Terminal)

```bash
cd ~/repositories/sidiknet

# Pull perubahan
git pull origin main

# Update dependencies jika ada perubahan composer
composer install --optimize-autoloader --no-dev

# Run migrations jika ada
php artisan migrate --force

# Clear dan rebuild cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 755 storage bootstrap/cache
```

## Troubleshooting

### Error 500 - Internal Server Error

-   Check file permissions: `chmod -R 755 storage bootstrap/cache`
-   Check `.env` configuration
-   Check error logs: `tail -f storage/logs/laravel.log`
-   Clear cache: `php artisan cache:clear && php artisan config:clear`

### Database Connection Error

-   Verify database credentials di `.env`
-   Pastikan database user memiliki privileges yang cukup
-   Check DB_HOST (biasanya `localhost` di cPanel)

### Assets Not Loading

-   Pastikan `APP_URL` di `.env` sesuai dengan domain Anda
-   Run `npm run build` di lokal dan push hasilnya
-   Check file permissions di folder `public`

### Git Pull Error

-   Check SSH keys atau credentials
-   Pastikan repository accessible
-   Try: `git reset --hard origin/main` (HATI-HATI: akan menghapus perubahan lokal)

## Alternative: Manual Upload via FTP

Jika Git tidak tersedia:

1. Build project di lokal: `npm run build`
2. Compress project: exclude `node_modules`, `.git`, `vendor`
3. Upload via FTP ke temporary folder
4. Extract di server
5. Run `composer install` via SSH
6. Follow Step 3.4 onwards

## Notes

-   **JANGAN** commit file `.env` ke Git (sudah ada di `.gitignore`)
-   **JANGAN** commit folder `vendor` dan `node_modules`
-   **SELALU** backup database sebelum migration di production
-   **GUNAKAN** `--force` flag untuk artisan commands di production
-   **SET** `APP_DEBUG=false` di production untuk keamanan
