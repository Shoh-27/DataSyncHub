# File: README.md
# DataSyncHub

A gamified freelancing platform with RPG-style progression system, featuring multi-database architecture (MySQL, PostgreSQL, MongoDB), Stripe payments, and Docker orchestration.

## 🚀 Features

### Core Platform
- **Multi-Database Architecture**: MySQL (auth, payments), PostgreSQL (jobs, projects), MongoDB (gamification)
- **Authentication**: JWT-based with email verification, 2FA support, OAuth (GitHub, Google)
- **Connect Economy**: Virtual currency system for job applications with Stripe integration
- **Payment System**: Escrow-based payments with 15% platform fee, withdrawal system
- **Job Marketplace**: Post jobs, apply with Connects, milestone-based contracts

### Gamification System
- **7-Level Progression**: Newbie → Junior → Mid1 → Mid2 → Mid3 → Senior1 → Senior2
- **XP System**: Earn XP from job completion (250 XP), challenges (20-100 XP), profile completion (50 XP)
- **Badge System**: 15+ badges across skill, achievement, milestone, and special categories
- **Challenge Platform**: 20+ pre-defined challenges across Backend, Frontend, DevOps, Algorithm
- **Leaderboard**: Global ranking system based on XP
- **Activity Feed**: Public achievement showcase

### Technical Stack
- **Backend**: Laravel 11 (PHP 8.3), Sanctum authentication
- **Frontend**: React 18, vanilla CSS (cyberpunk/RPG theme)
- **Databases**: MySQL 8.0, PostgreSQL 16, MongoDB 7.0
- **Cache/Queue**: Redis 7
- **Payments**: Stripe API
- **DevOps**: Docker Compose, Nginx, Supervisor

---

## 📋 Prerequisites

- Docker 20.10+
- Docker Compose 2.0+
- Git
- 4GB RAM minimum (8GB recommended)

---

## 🛠️ Installation

### Quick Start
```bash
# Clone repository
git clone https://github.com/yourusername/datasynchub.git
cd datasynchub

# Copy environment file
cp .env.example .env

# Edit .env with your configuration
nano .env

# Run setup script
chmod +x scripts/setup.sh
./scripts/setup.sh
```

### Manual Setup
```bash
# Build containers
docker-compose build

# Start all services
docker-compose up -d

# Install dependencies
docker-compose exec php composer install

# Generate application key
docker-compose exec php php artisan key:generate

# Run migrations
docker-compose exec php php artisan migrate

# Seed database
docker-compose exec php php artisan db:seed

# Create storage symlink
docker-compose exec php php artisan storage:link
```

---

## 🎮 Usage

### Access Points

- **API**: http://localhost:8000
- **MailHog UI**: http://localhost:8025 (email testing)
- **MySQL**: localhost:3306
- **PostgreSQL**: localhost:5432
- **MongoDB**: localhost:27017
- **Redis**: localhost:6379

### Using Makefile Commands
```bash
# View all available commands
make help

# Start services
make up

# View logs
make logs

# Access PHP container
make shell

# Run migrations
make migrate

# Seed database
make seed

# Run tests
make test

# Fresh install with seed
make fresh

# Stop services
make down
```

---

## 📁 Project Structure
```
datasynchub/
├── app/
│   ├── Console/
│   │   └── Commands/          # Artisan commands
│   ├── Events/                # Domain events
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/          # API controllers
│   │   ├── Middleware/       # Custom middleware
│   │   ├── Requests/         # Form request validation
│   │   └── Resources/        # API resources
│   ├── Jobs/                 # Queue jobs
│   ├── Listeners/            # Event listeners
│   ├── Models/
│   │   └── MongoDB/          # MongoDB models
│   ├── Notifications/        # Email notifications
│   ├── Providers/            # Service providers
│   └── Services/             # Business logic services
├── config/                   # Configuration files
├── database/
│   ├── factories/            # Model factories
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── docker/
│   ├── nginx/                # Nginx configuration
│   ├── php/                  # PHP-FPM configuration
│   ├── mysql/                # MySQL configuration
│   ├── postgres/             # PostgreSQL configuration
│   ├── mongodb/              # MongoDB configuration
│   └── redis/                # Redis configuration
├── routes/
│   └── api.php               # API routes
├── scripts/                  # Helper scripts
├── storage/                  # File storage
├── tests/                    # PHPUnit tests
├── docker-compose.yml        # Docker orchestration
├── Makefile                  # Helper commands
└── README.md
```

---

## 🗄️ Database Architecture

### MySQL (Auth, Users, Wallet, Payments)
- `users` - User accounts and profiles
- `wallets` - Connect and cash balances
- `connect_transactions` - Connect purchase/usage history
- `payments` - Payment records
- `withdrawals` - Freelancer withdrawal requests
- `escrow_transactions` - Job payment escrow

### PostgreSQL (Jobs, Projects, Offers)
- `skills` - Skill taxonomy
- `challenges` - Platform challenges
- `badges` - Badge definitions
- Will be extended in future modules with jobs/projects

### MongoDB (XP Logs, Badges, Events)
- `xp_logs` - XP transaction history
- `user_badges` - User badge awards
- `user_levels` - User level progression
- `challenge_submissions` - Challenge submissions
- `activity_feed` - User activity timeline

---

## 🔑 Environment Variables
```env
# Application
APP_NAME="DataSyncHub"
APP_ENV=local
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000

# MySQL
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=datasync_mysql
DB_USERNAME=datasync_user
DB_PASSWORD=datasync_secret
DB_ROOT_PASSWORD=root_secret

# PostgreSQL
PGSQL_HOST=postgres
PGSQL_PORT=5432
PGSQL_DATABASE=datasync_pgsql
PGSQL_USERNAME=datasync_user
PGSQL_PASSWORD=datasync_secret

# MongoDB
MONGO_HOST=mongodb
MONGO_PORT=27017
MONGO_DATABASE=datasync_mongo
MONGO_USERNAME=datasync_user
MONGO_PASSWORD=datasync_secret

# Redis
REDIS_HOST=redis
REDIS_PORT=6379

# Stripe
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
STRIPE_WEBHOOK_SECRET=your_webhook_secret

# Mail
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
```

---

## 🧪 Testing
```bash
# Run all tests
make test

# Run tests with coverage
make test-coverage

# Run specific test suite
docker-compose exec php php artisan test --filter=AuthTest

# Run tests in parallel
docker-compose exec php php artisan test --parallel
```

---

## 📊 API Documentation

### Authentication Endpoints

#### Register
```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!",
  "role": "freelancer"
}
```

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "Password123!",
  "remember": true
}
```

#### Get Current User
```http
GET /api/auth/me
Authorization: Bearer {token}
```

### Wallet Endpoints

#### Get Wallet
```http
GET /api/wallet
Authorization: Bearer {token}
```

#### Get Connect History
```http
GET /api/wallet/connect-history?limit=50&offset=0
Authorization: Bearer {token}
```

### Connect Purchase Endpoints

#### Get Connect Packages
```http
GET /api/connect-packages
```

#### Create Purchase Intent
```http
POST /api/payments/connect-purchase
Authorization: Bearer {token}
Content-Type: application/json

{
  "package_id": 1
}
```

#### Confirm Purchase
```http
POST /api/payments/confirm-purchase
Authorization: Bearer {token}
Content-Type: application/json

{
  "payment_intent_id": "pi_xxxxx"
}
```

### Gamification Endpoints

#### Get User Stats
```http
GET /api/gamification/stats
Authorization: Bearer {token}
```

#### Get User Badges
```http
GET /api/gamification/badges
Authorization: Bearer {token}
```

#### Get Leaderboard
```http
GET /api/gamification/leaderboard?limit=100
Authorization: Bearer {token}
```

### Challenge Endpoints

#### Get All Challenges
```http
GET /api/challenges?category=backend&difficulty=medium
```

#### Submit Challenge
```http
POST /api/challenges/submit
Authorization: Bearer {token}
Content-Type: application/json

{
  "challenge_id": 1,
  "submission_url": "https://github.com/user/repo",
  "notes": "Completed with React and TypeScript"
}
```

#### Get My Submissions
```http
GET /api/challenges/my-submissions?status=pending
Authorization: Bearer {token}
```

---

## 🔧 Maintenance

### Backup Databases
```bash
# Run backup script
chmod +x scripts/backup.sh
./scripts/backup.sh

# Backups saved to ./backups/
```

### Check Database Connections
```bash
chmod +x scripts/check-databases.sh
./scripts/check-databases.sh
```

### Clear Caches
```bash
make clear
```

### Optimize Application
```bash
make optimize
```

### View Container Stats
```bash
make stats
```

---

## 🐛 Troubleshooting

### Containers won't start
```bash
# Check Docker status
docker ps -a

# View logs
make logs

# Restart services
make restart
```

### Database connection issues
```bash
# Check database connectivity
./scripts/check-databases.sh

# Restart database containers
docker-compose restart mysql postgres mongodb
```

### Permission issues
```bash
# Fix storage permissions
docker-compose exec php chmod -R 777 storage bootstrap/cache
```

### Queue not processing
```bash
# Restart queue worker
make queue-restart

# View queue logs
make logs-queue
```

---

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate strong `APP_KEY`
- [ ] Configure production database credentials
- [ ] Set up SSL certificates
- [ ] Configure proper CORS settings
- [ ] Set up monitoring (Sentry, New Relic)
- [ ] Configure backup strategy
- [ ] Set up CI/CD pipeline
- [ ] Configure queue workers with Supervisor
- [ ] Set up Redis password
- [ ] Configure rate limiting
- [ ] Set up firewall rules
- [ ] Enable database backups
- [ ] Configure email service (SendGrid/SES)
- [ ] Set up file storage (S3/Spaces)

---

## 📝 Development Roadmap

### V1.5 (Current) ✅
- [x] User authentication & profiles
- [x] Connect economy with Stripe
- [x] Wallet system
- [x] XP & level progression
- [x] Challenge system
- [x] Badge awards
- [x] Activity feed
- [x] Multi-database architecture

### V2 (Planned)
- [ ] Job posting & marketplace
- [ ] Job applications with Connect deduction
- [ ] Contract & milestone system
- [ ] Escrow payment flow
- [ ] Messaging system
- [ ] Review & rating system
- [ ] Advanced search with filters
- [ ] Notification system

### V3 (Future)
- [ ] Real-time features (WebSockets)
- [ ] Mobile apps (React Native)
- [ ] Video call integration
- [ ] Team accounts
- [ ] API access for integrations
- [ ] Advanced analytics
- [ ] Multi-language support

---

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use meaningful commit messages

---

## 📄 License

This project is licensed under the MIT License.

---

## 👥 Authors

- **Your Name** - *Initial work*

---

## 🙏 Acknowledgments

- Laravel community
- React community
- Docker community
- All contributors

---

## 📞 Support

For support, email support@datasynchub.com or open an issue on GitHub.
```

---

## 4.11 DOCKER IGNORE

### File 125: .dockerignore
```
# File: .dockerignore
.git
.gitignore
.env
.env.example
README.md
docker-compose.yml
Makefile

# Dependencies
node_modules
vendor

# Tests
tests
.phpunit.result.cache

# IDE
.idea
.vscode
.fleet

# OS files
.DS_Store
Thumbs.db

# Logs
*.log
storage/logs

# Backups
backups

# Documentation
docs
