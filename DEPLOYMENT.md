# 🚀 Deployment Guide: Sandbox to Production

## Overview

Sistem payment gateway sudah dikonfigurasi untuk **auto-switch** antara sandbox dan production hanya dengan mengubah `.env`. Tidak perlu mengubah code!

---

## 📋 Configuration Files

### 1. **config/services.php**
```php
'ipaymu' => [
    'sandbox' => env('IPAYMU_SANDBOX', true),
    'va' => env('IPAYMU_VA'),
    'api_key' => env('IPAYMU_API_KEY'),
    
    // Auto-switch base URL
    'base_url' => env('IPAYMU_SANDBOX', true) 
        ? 'https://sandbox.ipaymu.com/api/v2'  // Sandbox
        : 'https://my.ipaymu.com/api/v2',      // Production
],
```

### 2. **app/Services/IPaymuService.php**
- Handles all iPaymu API interactions
- Auto-selects credentials based on mode
- Comprehensive logging with mode indicator
- Automatic SSL handling

---

## 🧪 LOCALHOST / DEVELOPMENT

### Environment Setup (.env)

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# iPaymu Sandbox Mode
IPAYMU_SANDBOX=true
IPAYMU_SANDBOX_VA=your_sandbox_va
IPAYMU_SANDBOX_API_KEY=your_sandbox_api_key

# Active credentials (auto-selected)
IPAYMU_VA=${IPAYMU_SANDBOX_VA}
IPAYMU_API_KEY=${IPAYMU_SANDBOX_API_KEY}
```

### Features Available:
- ✅ Create orders
- ✅ Generate payment URLs
- ✅ Redirect to iPaymu sandbox
- ✅ Testing dashboard: `/test/payment-dashboard`
- ✅ Simulate callbacks (manual)
- ❌ Real callbacks (iPaymu can't reach localhost)

### Testing Workflow:

1. **Create Order**
   ```
   http://localhost:8000
   → Select package → Fill form → Submit
   ```

2. **Test Payment (Sandbox)**
   ```
   → Redirected to iPaymu sandbox
   → Complete payment (test mode)
   → Click "Back to Merchant"
   ```

3. **Simulate Callback**
   ```
   http://localhost:8000/test/payment-dashboard
   → Find order → Click "Simulate Payment Success"
   → Verify status updated
   ```

4. **Check Logs**
   ```
   storage/logs/laravel.log
   → Look for: "iPaymu Service Initialized [SANDBOX]"
   → Verify all requests show mode: SANDBOX
   ```

---

## 🌐 PRODUCTION / HOSTING

### Pre-Deployment Checklist

- [ ] Get production iPaymu credentials from https://my.ipaymu.com
- [ ] Update `.env` with production values
- [ ] Test in staging environment first
- [ ] Ensure callback URL is accessible from internet
- [ ] Clear all caches
- [ ] Disable testing routes (auto-disabled when APP_ENV=production)

### Environment Setup (.env)

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# iPaymu Production Mode
IPAYMU_SANDBOX=false
IPAYMU_PRODUCTION_VA=your_production_va
IPAYMU_PRODUCTION_API_KEY=your_production_api_key

# Active credentials (auto-selected)
IPAYMU_VA=${IPAYMU_PRODUCTION_VA}
IPAYMU_API_KEY=${IPAYMU_PRODUCTION_API_KEY}

# Mail (Production SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-production-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Deployment Steps

#### 1. **Upload Files to cPanel**

Via Git (Recommended):
```bash
# In cPanel Terminal
cd /home/username/public_html
git pull origin main
```

Via FTP:
- Upload all files except `.env`
- Keep production `.env` on server

#### 2. **Configure Environment**

```bash
# Copy and edit .env
cp .env.example .env
nano .env

# Update these values:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
IPAYMU_SANDBOX=false
IPAYMU_VA=your_production_va
IPAYMU_API_KEY=your_production_api_key
```

#### 3. **Run Deployment Commands**

```bash
# Install dependencies
composer install --optimize-autoloader --no-dev

# Generate app key (if needed)
php artisan key:generate

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Set permissions
chmod -R 755 storage bootstrap/cache
```

#### 4. **Configure iPaymu Dashboard**

Login to https://my.ipaymu.com and set:

**Callback URL:**
```
https://yourdomain.com/order/callback/{orderId}
```

**Return URL:**
```
https://yourdomain.com/order/return/{orderId}
```

**Cancel URL:**
```
https://yourdomain.com/order/cancel/{order_id}
```

#### 5. **Test Production Payment**

1. Create a test order with small amount
2. Complete payment using real payment method
3. Verify callback is received
4. Check order status updated
5. Verify email sent

#### 6. **Monitor Logs**

```bash
tail -f storage/logs/laravel.log

# Look for:
# - "iPaymu Service Initialized [PRODUCTION]"
# - All requests should show mode: PRODUCTION
# - Callback received and processed
```

---

## 🔄 Switching Between Modes

### From Sandbox to Production:

```bash
# Update .env
IPAYMU_SANDBOX=false
IPAYMU_VA=${IPAYMU_PRODUCTION_VA}
IPAYMU_API_KEY=${IPAYMU_PRODUCTION_API_KEY}

# Clear config cache
php artisan config:clear
```

### From Production to Sandbox:

```bash
# Update .env
IPAYMU_SANDBOX=true
IPAYMU_VA=${IPAYMU_SANDBOX_VA}
IPAYMU_API_KEY=${IPAYMU_SANDBOX_API_KEY}

# Clear config cache
php artisan config:clear
```

---

## 🔍 Verification Checklist

### After Deployment:

- [ ] Check logs show correct mode (SANDBOX or PRODUCTION)
- [ ] Create test order successfully
- [ ] Payment URL generated correctly
- [ ] Redirect to correct iPaymu URL
- [ ] Callback received and processed
- [ ] Order status updated correctly
- [ ] Voucher status updated correctly
- [ ] Email sent successfully
- [ ] Testing routes disabled (production only)

### Log Indicators:

**Sandbox Mode:**
```
[INFO] iPaymu Service Initialized {"mode":"SANDBOX","base_url":"https://sandbox.ipaymu.com/api/v2"}
[INFO] iPaymu Payment Request {"mode":"SANDBOX",...}
```

**Production Mode:**
```
[INFO] iPaymu Service Initialized {"mode":"PRODUCTION","base_url":"https://my.ipaymu.com/api/v2"}
[INFO] iPaymu Payment Request {"mode":"PRODUCTION",...}
```

---

## 🐛 Troubleshooting

### Problem: Still using sandbox in production

**Solution:**
```bash
# Check .env
cat .env | grep IPAYMU_SANDBOX
# Should show: IPAYMU_SANDBOX=false

# Clear config cache
php artisan config:clear

# Verify in logs
tail -f storage/logs/laravel.log
# Should show: mode: PRODUCTION
```

### Problem: Callback not received

**Solution:**
1. Check callback URL is accessible from internet
2. Verify URL in iPaymu dashboard
3. Check firewall/security settings
4. Test callback URL manually: `curl https://yourdomain.com/order/callback/1`

### Problem: Wrong credentials used

**Solution:**
```bash
# Check config
php artisan tinker
>>> config('services.ipaymu.va')
>>> config('services.ipaymu.api_key')
>>> config('services.ipaymu.sandbox')

# Should match your production credentials
```

---

## 📊 Monitoring

### Important Logs to Monitor:

1. **Payment Creation**
   - Request payload
   - Signature generation
   - Response from iPaymu

2. **Callback Processing**
   - Callback data received
   - Transaction verification
   - Order status update
   - Email sending

3. **Errors**
   - Payment failures
   - Callback failures
   - Email failures

### Log Locations:

```
storage/logs/laravel.log          # Main application log
storage/logs/laravel-YYYY-MM-DD.log  # Daily logs
```

---

## 🎯 Quick Reference

| Environment | IPAYMU_SANDBOX | Base URL | Callback Works? |
|-------------|----------------|----------|-----------------|
| Localhost   | `true`         | sandbox.ipaymu.com | ❌ (use simulator) |
| Staging     | `true`         | sandbox.ipaymu.com | ✅ (if public URL) |
| Production  | `false`        | my.ipaymu.com | ✅ |

---

## 📝 Notes

1. **Testing Routes**: Automatically disabled when `APP_ENV=production`
2. **SSL Verification**: Disabled in sandbox/local, enabled in production
3. **Logging**: All requests logged with mode indicator (SANDBOX/PRODUCTION)
4. **Credentials**: Auto-selected based on `IPAYMU_SANDBOX` flag
5. **Base URL**: Auto-switched based on mode

---

**Last Updated:** 2026-01-05
**Version:** 1.0
**Author:** Antigravity AI
