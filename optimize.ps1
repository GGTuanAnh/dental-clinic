# Dental Clinic Performance Optimization Script for Windows PowerShell

Write-Host "🚀 Optimizing Dental Clinic Application Performance..." -ForegroundColor Green

# Cache all Laravel configurations
Write-Host "📦 Caching Laravel configurations..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize Composer autoloader
Write-Host "🔧 Optimizing Composer autoloader..." -ForegroundColor Yellow
composer install --optimize-autoloader --no-dev

# Clear and optimize application cache
Write-Host "🧹 Clearing and optimizing application cache..." -ForegroundColor Yellow
php artisan cache:clear
php artisan view:clear

# Generate application key if needed
$envContent = Get-Content .env -Raw
if ($envContent -notmatch "APP_KEY=base64:") {
    Write-Host "🔑 Generating application key..." -ForegroundColor Yellow
    php artisan key:generate
}

# Install Node.js dependencies and build assets
if (Test-Path "package.json") {
    Write-Host "📦 Installing and building frontend assets..." -ForegroundColor Yellow
    npm install
    npm run build
}

# Database optimizations
Write-Host "🗄️ Optimizing database..." -ForegroundColor Yellow
php artisan migrate --force

# Queue optimizations
Write-Host "⚡ Setting up queue optimizations..." -ForegroundColor Yellow
php artisan queue:restart

Write-Host "✅ Performance optimization completed!" -ForegroundColor Green
Write-Host ""
Write-Host "📊 Performance Tips:" -ForegroundColor Cyan
Write-Host "1. Enable OPcache in production"
Write-Host "2. Use Redis for cache and sessions"
Write-Host "3. Enable gzip compression in web server"
Write-Host "4. Use CDN for static assets"
Write-Host "5. Monitor with Laravel Telescope or similar tools"
Write-Host ""
Write-Host "🔧 Additional optimizations you can do:" -ForegroundColor Cyan
Write-Host "- Set APP_ENV=production in .env"
Write-Host "- Set APP_DEBUG=false in .env"
Write-Host "- Configure proper log levels"
Write-Host "- Use database connection pooling"
Write-Host "- Enable HTTP/2 on your web server"

# Performance check
Write-Host ""
Write-Host "🔍 Running performance check..." -ForegroundColor Yellow
$startTime = Get-Date
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8000" -TimeoutSec 30 -UseBasicParsing
    $endTime = Get-Date
    $responseTime = ($endTime - $startTime).TotalMilliseconds
    
    if ($response.StatusCode -eq 200) {
        Write-Host "✅ Application is responding" -ForegroundColor Green
        Write-Host "⏱️ Response time: $([math]::Round($responseTime, 2))ms" -ForegroundColor Green
        
        if ($responseTime -lt 500) {
            Write-Host "🚀 Excellent performance!" -ForegroundColor Green
        } elseif ($responseTime -lt 1000) {
            Write-Host "👍 Good performance" -ForegroundColor Yellow
        } else {
            Write-Host "⚠️ Performance could be improved" -ForegroundColor Red
        }
    }
} catch {
    Write-Host "❌ Could not check application performance - make sure server is running" -ForegroundColor Red
}
}