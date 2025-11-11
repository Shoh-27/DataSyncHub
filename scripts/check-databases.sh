#!/bin/bash
# File: scripts/check-databases.sh

set -e

echo "Checking database connections..."
echo ""

# Check MySQL
echo -n "MySQL: "
if docker-compose exec -T mysql mysqladmin ping -h localhost -u root -p${DB_ROOT_PASSWORD} --silent; then
    echo "✓ Connected"
else
    echo "✗ Connection failed"
fi

# Check PostgreSQL
echo -n "PostgreSQL: "
if docker-compose exec -T postgres pg_isready -U ${PGSQL_USERNAME} -d ${PGSQL_DATABASE} > /dev/null 2>&1; then
    echo "✓ Connected"
else
    echo "✗ Connection failed"
fi

# Check MongoDB
echo -n "MongoDB: "
if docker-compose exec -T mongodb mongosh --quiet --eval "db.adminCommand('ping')" -u ${MONGO_USERNAME} -p ${MONGO_PASSWORD} --authenticationDatabase admin > /dev/null 2>&1; then
    echo "✓ Connected"
else
    echo "✗ Connection failed"
fi

# Check Redis
echo -n "Redis: "
if docker-compose exec -T redis redis-cli ping > /dev/null 2>&1; then
    echo "✓ Connected"
else
    echo "✗ Connection failed"
fi

echo ""
echo "Database check complete!"
