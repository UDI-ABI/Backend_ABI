#!/bin/bash
set -e  # hace que el script se detenga si algo falla

# Cargar variables del archivo .env
source .env

# Paso 1: ejecutar migraciones y seeders
echo "==> Ejecutando migraciones y seeders..."
php artisan migrate

# Paso 2: ejecutar SQL adicionales (roles, funciones, procedimientos, triggers)
MYSQL="mysql -u${DB_USERNAME} --password=${DB_PASSWORD} -h${DB_HOST} -P${DB_PORT} ${DB_DATABASE}"

# Reemplazar los placeholders con sed y ejecutar en MySQL
echo "==> Creando roles..."
sed -e "s/{{DB_DATABASE}}/${DB_DATABASE}/g" \
    -e "s/{{DB_STUDENT_PASS}}/${DB_STUDENT_PASS}/g" \
    -e "s/{{DB_PROFESSOR_PASS}}/${DB_PROFESSOR_PASS}/g" \
    -e "s/{{DB_RESEARCH_PASS}}/${DB_RESEARCH_PASS}/g" \
    database/sql/roles.sql | $MYSQL

#echo "==> Creando funciones..."
#$MYSQL < database/sql/functions.sql
#
#echo "==> Creando procedimientos..."
#$MYSQL < database/sql/procedures.sql
#
#echo "==> Creando triggers..."
#$MYSQL < database/sql/triggers.sql

echo "==> Base de datos inicializada correctamente 🎉"
