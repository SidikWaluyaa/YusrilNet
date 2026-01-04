---
description: Deploy Laravel to cPanel manually via FTP
---

# Deploy Laravel to cPanel via FTP (Manual Method)

Gunakan metode ini jika Git deployment tidak bisa digunakan.

## Step 1: Persiapan Project Lokal

### 1.1 Build Production Assets
```bash
npm install
npm run build
```

### 1.2 Buat Archive (Exclude Files Besar)

**Opsi A: Manual via File Explorer**
1. Copy seluruh folder project ke folder baru
2. Hapus folder berikut:
   - `node_modules/`
   - `vendor/`
   - `.git/`
   - `storage/logs/*.log`
3. Compress menjadi ZIP

**Opsi B: Via Command Line**
```bash
# Buat archive tanpa file yang tidak perlu
tar -czf sidiknet-deploy.tar.gz \
  --exclude='node_modules' \
  --exclude='vendor' \
  --exclude='.git' \
  --exclude='storage/logs/*.log' \
  --exclude='.env' \
  .
```

## Step 2: Upload ke cPanel

### 2.1 Via File Manager
1. Login ke cPanel
2. Buka **File Manager**
3. Navigate ke `public_html` atau folder yang diinginkan
4. Klik **Upload**
5. Upload file `sidiknet-deploy.tar.gz` atau `sidiknet-deploy.zip`
6. Setelah upload selesai, klik kanan file → **Extract**
7. Hapus file archive setelah extract

### 2.2 Via FTP Client (FileZilla, WinSCP, dll)
1. Buka FTP client
2. Connect ke server:
   - **Host**: ftp.yourdomain.com atau IP server
   - **Username**: cPanel username
   - **Password**: cPanel password
   - **Port**: 21 (FTP) atau 22 (SFTP)
3. Navigate ke `public_html` atau `/home/username/`
4. Upload semua files (ini akan memakan waktu lama)

## Step 3: Setup Laravel via SSH/Terminal

### 3.1 Akses Terminal
- Di cPanel, buka **Terminal**

### 3.2 Navigate ke Project Directory
```bash
cd ~/public_html
# atau
cd ~/public_html/sidiknet  # jika upload ke subfolder
```

### 3.3 Install Composer Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

Jika composer tidak tersedia, install dulu:
```bash
# Download composer
curl -sS https://getcomposer.org/installer | php

# Gunakan composer.phar
php composer.phar install --optimize-autoloader --no-dev
```

### 3.4 Setup Environment File
```bash
cp .env.example .env
nano .env
```

Edit konfigurasi:
```env
APP_NAME="YusrilNet"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cpanel_database_name
DB_USERNAME=cpanel_database_user
DB_PASSWORD=cpanel_database_password

SESSION_DRIVER=file
QUEUE_CONNECTION=database
```

Save: `Ctrl+X` → `Y` → `Enter`

### 3.5 Generate Application Key
```bash
php artisan key:generate
```

### 3.6 Setup Database

**Buat Database di cPanel:**
1. Buka **MySQL® Databases**
2. Buat database baru (contoh: `cpanel_sidiknet`)
3. Buat user baru (contoh: `cpanel_sidikuser`)
4. Set password
5. Add user to database dengan **ALL PRIVILEGES**

**Run Migrations:**
```bash
php artisan migrate --force
```

**Seed Database (optional):**
```bash
php artisan db:seed --force
```

### 3.7 Setup Storage
```bash
php artisan storage:link
```

### 3.8 Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R username:username storage bootstrap/cache
```

Ganti `username` dengan cPanel username Anda.

### 3.9 Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Step 4: Setup Web Root

### Jika Upload ke Subfolder (contoh: ~/public_html/sidiknet)

**Opsi A: Update .htaccess di public_html**
```bash
nano ~/public_html/.htaccess
```

Tambahkan:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ sidiknet/public/$1 [L]
</IfModule>
```

**Opsi B: Pindahkan Files**
```bash
# Backup public_html
mv ~/public_html ~/public_html_backup

# Copy public folder ke public_html
cp -r ~/sidiknet/public ~/public_html

# Update index.php
nano ~/public_html/index.php
```

Update paths di `index.php`:
```php
require __DIR__.'/../sidiknet/vendor/autoload.php';
$app = require_once __DIR__.'/../sidiknet/bootstrap/app.php';
```

### Jika Upload Langsung ke public_html

**Pindahkan isi public ke root:**
```bash
cd ~/public_html
mv public/* .
mv public/.htaccess .
rmdir public

# Update index.php
nano index.php
```

Update paths:
```php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
```

## Step 5: Testing

### 5.1 Test Website
- Buka browser: `https://yourdomain.com`
- Pastikan website loading dengan benar

### 5.2 Check Errors
```bash
tail -f ~/public_html/storage/logs/laravel.log
# atau
tail -f ~/sidiknet/storage/logs/laravel.log
```

## Step 6: Update di Masa Depan

### Via FTP:
1. Build assets di lokal: `npm run build`
2. Upload files yang berubah via FTP
3. SSH ke server dan run:
```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Via File Manager:
1. Upload files baru
2. Extract jika ZIP
3. Run artisan commands via Terminal

## Troubleshooting

### Error 500
```bash
# Check permissions
chmod -R 755 storage bootstrap/cache

# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Check logs
tail -f storage/logs/laravel.log
```

### Composer Not Found
```bash
# Install composer locally
curl -sS https://getcomposer.org/installer | php
php composer.phar install --optimize-autoloader --no-dev
```

### Permission Denied
```bash
# Fix ownership
chown -R $(whoami):$(whoami) storage bootstrap/cache

# Fix permissions
chmod -R 755 storage bootstrap/cache
```

### Database Connection Error
- Verify `.env` credentials
- Check if database user has correct privileges
- Ensure `DB_HOST=localhost` (not 127.0.0.1)

### Assets Not Loading
- Check `APP_URL` in `.env`
- Ensure `public/build` folder exists
- Run `npm run build` locally before upload
- Check `.htaccess` file exists in public folder

## Tips

1. **Backup Sebelum Update**: Selalu backup database dan files sebelum update
2. **Test di Staging**: Jika ada, test dulu di staging environment
3. **Maintenance Mode**: Gunakan `php artisan down` saat update, `php artisan up` setelah selesai
4. **Git Ignore**: Jangan upload `.env`, `node_modules`, `vendor` yang lama
5. **Compress**: Compress files besar sebelum upload untuk menghemat waktu

## Alternative: Use Deployer or Laravel Forge

Untuk deployment yang lebih profesional, pertimbangkan:
- **Laravel Forge**: https://forge.laravel.com (paid)
- **Deployer**: https://deployer.org (free, requires SSH)
- **GitHub Actions**: Automated deployment (free)
