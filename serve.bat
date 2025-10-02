@echo off
echo ========================================
echo  SISTEM PERPINDAHAN PENDUDUK
echo  Development Server with Clean URLs
echo ========================================
echo Starting PHP Development Server...
echo Access the application at: http://127.0.0.1:8000
echo.
echo Available Clean URLs:
echo - http://127.0.0.1:8000/
echo - http://127.0.0.1:8000/dashboard
echo - http://127.0.0.1:8000/tambah-masuk
echo - http://127.0.0.1:8000/tambah-keluar
echo - http://127.0.0.1:8000/rekapitulasi
echo.
echo Press Ctrl+C to stop the server
echo ========================================
php -S 127.0.0.1:8000 router.php
