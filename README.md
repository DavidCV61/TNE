# TNE - Aplicacion con autenticacion y roles

Aplicacion con Laravel, Quasar + Vue 3  y PostgreSQL.

## Git Clone

```bash
git clone https://github.com/DavidCV61/TNE.git
cd TNE
```

## Desarrollo local 

Requisitos: PHP 8.4, Composer, Node.js 22, PostgreSQL.

### Backend

```bash
cd backend
cp .env.example .env
```

```env
APP_NAME=TNE
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tne_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Frontend

```bash
cd frontend
npm install
quasar dev
```

El backend corre en `http://localhost:8000` y el frontend en `http://localhost:9000`.

---

## Produccion con Docker

Requisitos: Docker y Docker Compose.

### Estructura de archivos

```
tne/
├── docker-compose.yml
├── .env                     # variables para Docker (Base de Datos)
├── backend/                 # codigo Laravel 
└── frontend/                # codigo Quasar 
```

### Pasos

1. Crea un archivo `.env`:

```env
DB_DATABASE=tne_db
DB_USERNAME=tne_user
DB_PASSWORD=tu_clave
```

2. Construye y levanta los contenedores:

```bash
docker-compose build
docker-compose up -d
```

3. La aplicación estará en `http://localhost:30080`.

### Comandos utiles

- Logs: `docker-compose logs -f`
- Detener: `docker-compose down`
- Reiniciar base de datos: `docker-compose down -v`

### Usuario administrador por defecto

- Email: `batman@email.com`
- Contraseña: `batman1234`
