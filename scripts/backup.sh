#!/bin/bash
# File: scripts/backup.sh

set -e

BACKUP_DIR="./backups"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

echo "Creating backups..."
echo ""

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup MySQL
echo "Backing up MySQL..."
docker-compose exec -T mysql mysqldump -u ${DB_USERNAME} -p${DB_PASSWORD} ${DB_DATABASE} > "${BACKUP_DIR}/mysql_${TIMESTAMP}.sql"
echo "✓ MySQL backup created: mysql_${TIMESTAMP}.sql"

# Backup PostgreSQL
echo "Backing up PostgreSQL..."
docker-compose exec -T postgres pg_dump -U ${PGSQL_USERNAME} -d ${PGSQL_DATABASE} > "${BACKUP_DIR}/postgres_${TIMESTAMP}.sql"
echo "✓ PostgreSQL backup created: postgres_${TIMESTAMP}.sql"

# Backup MongoDB
echo "Backing up MongoDB..."
docker-compose exec -T mongodb mongodump --username ${MONGO_USERNAME} --password ${MONGO_PASSWORD} --authenticationDatabase admin --db ${MONGO_DATABASE} --archive > "${BACKUP_DIR}/mongodb_${TIMESTAMP}.archive"
echo "✓ MongoDB backup created: mongodb_${TIMESTAMP}.archive"

echo ""
echo "All backups completed successfully!"
echo "Backup location: $BACKUP_DIR"
