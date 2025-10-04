# docker-machine-test

# 🔍 Laravel Unified Search API

This project demonstrates a **unified search system** built with **Laravel 11**, **Sanctum authentication**, and **Meilisearch** for full-text search.  
It provides:
- Public search and suggestions endpoints
- Protected admin-only search analytics
- Docker-based development setup

---

## 🚀 Features

✅ Unified search across multiple models:
- Blog Posts  
- Products  
- Pages  
- FAQs  

✅ Typeahead suggestions  
✅ Sanctum authentication for admin-only endpoints  
✅ Meilisearch integration for fast searching  
✅ Dockerized setup with MySQL and Meilisearch containers  
✅ Seeded data for instant testing  

---

## 🧩 Tech Stack

| Component | Description |
|------------|-------------|
| **Framework** | Laravel 11 (PHP 8.2) |
| **Database** | MySQL 8.0 |
| **Search Engine** | Meilisearch v1.2 |
| **Auth** | Laravel Sanctum |
| **Containerization** | Docker & Docker Compose |

---

## ⚙️ Prerequisites

Make sure you have the following installed:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/downloads)
- [Composer](https://getcomposer.org/)

---

## 🧱 Setup Instructions

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/Manojk-1989/docker-machine-test.git
cd docker-machine-test

2️⃣ Build and Start Docker Containers
docker compose up -d --build

3️⃣ Run Migrations and Seeders
docker exec -it my_app bash
php artisan migrate:fresh --seed

4️⃣ Access the Application

Laravel API → http://localhost:8000

Meilisearch Dashboard → http://localhost:7700

🔐 Authentication Details
Role	Email	Password
Admin	admin@example.com	password

To generate an API token (for admin routes):

php artisan tinker
$user = App\Models\User::first();
$token = $user->createToken('admin-token')->plainTextToken;
echo $token;

Then use this token in Authorization Header:
Authorization: Bearer <token>


🧭 API Endpoints
🔹 Public Routes
| Method | Endpoint                  | Description                                                          |
| ------ | ------------------------- | -------------------------------------------------------------------- |
| `GET`  | `/api/search`             | Perform a unified search across BlogPosts, Products, Pages, and FAQs |
| `GET`  | `/api/search/suggestions` | Get live search suggestions                                          |

🔒 Admin Routes (Require Sanctum Token)

| Method | Endpoint                    | Description               |
| ------ | --------------------------- | ------------------------- |
| `GET`  | `/api/search/logs`          | View all search logs      |
| `GET`  | `/api/search/analytics`     | View search statistics    |
| `POST` | `/api/search/rebuild-index` | Rebuild Meilisearch index |


🧪 Testing the API

You can test using Postman or curl.

Example — Public Search

curl http://localhost:8000/api/search?query=laravel


Example — Admin Search Logs (with token)

curl -H "Authorization: Bearer <your_token_here>" \
http://localhost:8000/api/search/logs

🧰 Common Commands

| Command                            | Description                              |
| ---------------------------------- | ---------------------------------------- |
| `docker compose up -d`             | Start containers                         |
| `docker compose down -v`           | Stop and remove all containers & volumes |
| `docker exec -it my_app bash`      | Enter Laravel container shell            |
| `php artisan migrate:fresh --seed` | Reset and seed database                  |
| `php artisan tinker`               | Open interactive shell                   |


🧹 Troubleshooting
MySQL Connection Error:
Ensure MySQL container is up (docker ps) and matches credentials in .env.

Meilisearch Not Found:
Visit http://localhost:7700
 to confirm Meilisearch is running.

Token Issues:
Re-run php artisan tinker and generate a new token.


