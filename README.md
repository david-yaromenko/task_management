# REST API для керування задачами (Laravel + JWT)

Це REST API для управління задачами з повним CRUD, пагінацією, фільтром за статусом та ролями (Admin/User). Аутентифікація здійснюється через JWT. 

---

## ⚠️ Примітки

* Відповіді повертаються у форматі JSON з коректними HTTP статусами.
* Admin бачить всі задачі; User — лише свої.
* Доступ до певних дій заданий через Policy.  
* JWT токен обов’язковий для всіх захищених маршрутів.
* Token JWT отримується після логіну.
* Обробка HTTP-статус-коду(помилка, валідація, доступ) здійснюється у файлі /bootstrap/app.php
* Наявність двох seeders - UsersSeeder та RolesSeeder.

---  

## 🛠 Технології

* PHP 8+
* Laravel 12
* MySQL (Docker)
* JWT Authentication (`tymon/jwt-auth`)
* Docker (для бази даних)

---

## 📦 Встановлення

### 1. Клонування репозиторію

```bash
git clone https://github.com/david-yaromenko/task_management.git
cd task-api
```

### 2. Налаштування середовища

```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Оновіть параметри бази даних у `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_db
DB_USERNAME=task_user
DB_PASSWORD=task_password
```

---

### 3. Docker (MySQL)

```bash
docker compose up -d
```

---

### 4. Міграції та наповнення бази

```bash
php artisan migrate
php artisan db:seed
```

---

### 5. Запуск Laravel

```bash
php artisan serve
```

API буде доступне за адресою `http://127.0.0.1:8000`.

---

## 🔑 Аутентифікація (JWT).  

### Логін

**POST** `/api/auth/login`

**Тіло запиту:**

```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

**Відповідь:**

```json
{
  "message": "Login successfull",
  "token": "<jwt-token>",
  "user": {
    "name": "Admin",
    "email": "admin@example.com",
    "role": "admin"
  }
}
```

---

## 🚀 Приклади API (cURL)

### 1. Логін

```bash
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'
```

### 2. Отримати задачі (Admin)

```bash
curl -X GET http://127.0.0.1:8000/api/admin/tasks \
  -H "Authorization: Bearer <jwt-token>"
```
### 2.1. Отримати задачі (User)

```bash
curl -X GET http://127.0.0.1:8000/api/tasks \
  -H "Authorization: Bearer <jwt-token>"
```

### 3. Створити задачу (Admin/User)

```bash
curl -X POST http://127.0.0.1:8000/api/tasks \
  -H "Authorization: Bearer <jwt-token>" \
  -H "Content-Type: application/json" \
  -d '{"title":"Нова задача"}'
```

---

## 🧪 Пагінація та фільтри

Підтримується пагінація та фільтрування за статусом:

```
GET /api/tasks?status=done&page=2
```
