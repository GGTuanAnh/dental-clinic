# Enable PDO SQLite extension for PHP
$phpIniPath = "C:\Users\tuans\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.ini"

Write-Host "Checking PHP configuration..." -ForegroundColor Cyan

if (Test-Path $phpIniPath) {
    $content = Get-Content $phpIniPath -Raw
    
    if ($content -match 'extension=pdo_sqlite') {
        Write-Host "PDO SQLite already enabled" -ForegroundColor Green
    } else {
        $content = $content -replace ';extension=pdo_sqlite', 'extension=pdo_sqlite'
        
        if ($content -notmatch 'extension=pdo_sqlite') {
            $content += "`r`nextension=pdo_sqlite`r`n"
        }
        
        Set-Content -Path $phpIniPath -Value $content -NoNewline
        Write-Host "PDO SQLite enabled - Please restart terminal" -ForegroundColor Yellow
    }
} else {
    Write-Host "php.ini not found" -ForegroundColor Red
}
