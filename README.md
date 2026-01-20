# Mini-CRM System

Система для сбора и обработки заявок с сайта через универсальный виджет.

## Технології

- **Laravel 12**
- **PHP 8.4**
- **PostgreSQL 18**
- **Redis**
- **Docker & Docker Compose**
- **Spatie Laravel Permission**
- **Spatie Laravel Media Library**

## Требования

- Docker & Docker Compose
- Git

## Быстрый старт

### 1. Клонирование репозитория

git clone git@github.com:IvanVorobyshek/mini-crm.git
cd mini-crm

### 2. Настройка среды

# Скопировать .env.example в .env
cp .env.example .env

# Настроить переменные среды
# DB_DATABASE, DB_USERNAME, DB_PASSWORD

### 3. Запуск

# Запустить контейнеры
docker compose up -d
docker compose exec laravel.test composer install
docker compose stop

./vendor/bin/sail up -d

# Создать симлинк для storage
./vendor/bin/sail artisan storage:link

# Сгенерировать ключ
./vendor/bin/sail artisan key:generate

# Запустить миграции и seeders (создает 1 админ, 5 менеджеров)
./vendor/bin/sail artisan migrate:fresh --seed

# Установить npm зависимости и собрать assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run build

### 4. Вход в приложение
Веб: http://localhost
MailPit: http://localhost:8025
PostgreSQL: localhost:5432
Redis: localhost:6379

### 5. Тестовые данные
Пользователи

Администратор
Email: admin@example.com
Password: password
Роль: admin

Менеджер
Email: manager@example.com
Password: password
Роль: manager

### 6. Виджет
Доступен по адресу http://localhost/widget

Вставка через iframe:
<iframe 
    src="http://your-domain.com/widget" 
    width="100%" 
    height="700" 
    frameborder="0"
    style="border: none;">
</iframe>

### 7. Админ-панель
http://localhost/admin

Предварительно следует войти (http://localhost/login) с тестовыми данными, указанными выше.
Cтраницы:
Dashboard - статистика заявок
Tickets - список заявок с фильтрацией

### 8. API

Создать заявку
POST /api/tickets
{
    "phone": "+380501234567",
    "subject": "Питання про продукт",
    "description": "Детальний опис питання...",
    "files": []
}
*** Важно!
Номер телефона можно взять из БД в таблице customers, поле phone (при выполнении ./vendor/bin/sail artisan migrate:fresh --seed создаются 20 customers). Заявки от несуществующих customers приниматься не будут

Response
{
    "data": {
        "id": 26,
        "subject": "subj",
        "description": "Ticket description",
        "status": "new",
        "files": []
    }
}

Получить статистику заявок
GET /api/tickets/statistics?period={day|week|month}

# Статистика за день
curl http://localhost/api/tickets/statistics?period=day

# Статистика за неделю
curl http://localhost/api/tickets/statistics?period=week

# Статистика за месяц
curl http://localhost/api/tickets/statistics?period=month

Пример
http://localhost/api/tickets/statistics?period=month

Response
{
    "data": {
        "total": 26,
        "by_status": {
            "new": 23,
            "processing": 2,
            "completed": 1
        },
        "period": {
            "start": "2026-01-01 00:00:00",
            "end": "2026-01-31 23:59:59"
        }
    }
}

Ограничение: одна заявка от одного номера телефона за 24 часа