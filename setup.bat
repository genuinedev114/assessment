@echo off
REM Yum! Brands Dashboard - Windows Setup Script

echo.
echo 🍕 Yum! Brands Dashboard - Setup Script (Windows)
echo ================================================
echo.

REM Check for .env file
if not exist .env (
    echo 📝 Creating .env file...
    copy .env.example .env
)

REM Install composer dependencies
echo.
echo 📦 Installing composer dependencies...
composer install

REM Generate app key
echo.
echo 🔑 Generating application key...
php artisan key:generate

REM Create SQLite database
echo.
echo 🗄️  Setting up database...
if not exist storage\database.sqlite (
    type nul > storage\database.sqlite
)

REM Run migrations
echo Running migrations and seeding...
php artisan migrate --seed

REM Install npm dependencies
echo.
echo 📚 Installing npm dependencies...
call npm install

echo 🎨 Building frontend assets...
call npm run dev

REM Create storage link
echo.
echo 🔗 Creating storage symlink...
php artisan storage:link 2>nul

echo.
echo ✨ Setup complete!
echo.
echo 🚀 To start the development server, run:
echo    php artisan serve
echo.
echo 📝 Test credentials:
echo    Email: owner@test.com
echo    Password: password
echo.
echo 🌐 Access the dashboard at:
echo    http://localhost:8000/dashboard
echo.
pause
