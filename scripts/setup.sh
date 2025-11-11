#!/bin/bash
# File: scripts/setup.sh

set -e

echo "╔════════════════════════════════════════╗"
echo "║   DataSyncHub - Development Setup     ║"
echo "╚════════════════════════════════════════╝"
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

echo "✓ Docker and Docker Compose are installed"
echo ""

# Copy environment file if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env
    echo "✓ .env file created"
    echo ""
    echo "⚠️  Please update .env file with your configuration before continuing."
    echo "   Press Enter when ready to continue..."
    read
fi

# Build Docker containers
echo "🔨 Building Docker containers..."
docker-compose build
echo "✓ Containers built successfully"
echo ""

# Start containers
echo "🚀 Starting containers..."
docker-compose up -d
echo "✓ Containers started"
echo ""

# Wait for databases to be ready
echo "⏳ Waiting for databases to be ready..."
sleep 10

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
docker-compose exec -T php composer install --no-interaction
echo "✓ Dependencies installed"
echo ""

# Generate application key
echo "🔑 Generating application key..."
docker-compose exec -T php php artisan key:generate
echo "✓ Application key generated"
echo ""

# Run migrations
echo "🗄️  Running database migrations..."
docker-compose exec -T php php artisan migrate --force
echo "✓ Migrations completed"
echo ""

# Seed database
echo "🌱 Seeding database..."
docker-compose exec -T php php artisan db:seed --force
echo "✓ Database seeded"
echo ""

# Create storage symlink
echo "🔗 Creating storage symlink..."
docker-compose exec -T php php artisan storage:link
echo "✓ Storage linked"
echo ""

# Clear and cache config
echo "⚡ Optimizing application..."
docker-compose exec -T php php artisan config:cache
docker-compose exec -T php php artisan route:cache
echo "✓ Application optimized"
echo ""

echo "╔════════════════════════════════════════╗"
echo "║          Setup Complete! 🎉            ║"
echo "╚════════════════════════════════════════╝"
echo ""
echo "📍 Application URL: http://localhost:8000"
echo "📧 MailHog UI: http://localhost:8025"
echo ""
echo "Database Connections:"
echo "  MySQL:      localhost:3306"
echo "  PostgreSQL: localhost:5432"
echo "  MongoDB:    localhost:27017"
echo "  Redis:      localhost:6379"
echo ""
echo "Useful commands:"
echo "  make logs       - View application logs"
echo "  make shell      - Access PHP container"
echo "  make test       - Run tests"
echo "  make help       - View all available commands"
echo ""
