#!/bin/bash

# Yum! Brands Dashboard - Setup Script
# This script will set up the project with all dependencies and initial data

echo "🍕 Yum! Brands Dashboard - Setup Script"
echo "========================================"
echo ""

# Check for required commands
echo "Checking for required tools..."

if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 7.3 or higher."
    exit 1
fi

if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer."
    exit 1
fi

if ! command -v npm &> /dev/null; then
    echo "⚠️  npm is not installed. Skipping frontend assets setup."
else
    echo "✅ npm found"
fi

echo "✅ PHP version: $(php -v | head -1)"
echo "✅ Composer version: $(composer --version)"
echo ""

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
fi

# Install composer dependencies
echo ""
echo "📦 Installing composer dependencies..."
composer install

# Generate app key
echo ""
echo "🔑 Generating application key..."
php artisan key:generate

# Create SQLite database
echo ""
echo "🗄️  Setting up database..."
if [ ! -f storage/database.sqlite ]; then
    touch storage/database.sqlite
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --seed

# Install npm dependencies
if command -v npm &> /dev/null; then
    echo ""
    echo "📚 Installing npm dependencies..."
    npm install
    
    echo "🎨 Building frontend assets..."
    npm run dev
fi

# Create storage link for files
echo ""
echo "🔗 Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

echo ""
echo "✨ Setup complete!"
echo ""
echo "🚀 To start the development server, run:"
echo "   php artisan serve"
echo ""
echo "📝 Test credentials:"
echo "   Email: owner@test.com"
echo "   Password: password"
echo ""
echo "🌐 Access the dashboard at:"
echo "   http://localhost:8000/dashboard"
echo ""
