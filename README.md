# 🚀 Laravel Docker Environment

This project runs a Laravel application inside Docker with **MySQL** and **Meilisearch** services.  
Follow these simple steps to build and run the application locally.

---

## 🧱 Prerequisites

Before starting, make sure you have installed:
- [Docker Desktop](https://www.docker.com/products/docker-desktop)
- [Git](https://git-scm.com/downloads)

---

## 🧩 Project Setup

### 1️⃣ Clone the repository

```bash
git clone https://github.com/your-username/docker-machine-test.git
cd docker-machine-test

2️⃣ Build and start Docker containers
docker compose up -d --build


⚠️ You may see a warning:

the attribute `version` is obsolete, it will be ignored


This can be safely ignored.

3️⃣ Check running services

docker ps


Expected containers:

app → Laravel application (port 8000)

db → MySQL database (port 3307)

meilisearch → Search engine (port 7700)

4️⃣ Install PHP dependencies via Composer

Run this command to install Laravel dependencies inside the container:

docker compose run --rm app composer install --no-interaction --prefer-dist --timeout=1200

⏱ The --timeout=1200 increases Composer's timeout to 20 minutes to prevent installation errors.

🔧 Step 1 — Create a .env file

Inside your project root (where artisan lives), run:
cp .env.example .env

🔧 Step 2 — Update database settings in .env

Open .env and ensure the database settings match your Docker setup:

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=


5️⃣ Generate the application key

After dependencies are installed, generate the Laravel app key:

docker exec -it my_app php artisan key:generate

6️⃣ Run database migrations

docker exec -it app php artisan migrate


7️⃣ Access the application

Visit your Laravel app in the browser:

👉 http://localhost:8000

Access the api documentation page

Visit your Laravel app in the browser:


http://localhost:8000/docs/api#/