# Тестовое задание от forento.ru

### Условие задания

Имеется таблица пользователей – `users`, в которой хранится базовая информация о пользователях
всей системы
```
CREATE TABLE "users" (
    "id" serial PRIMARY KEY,
    "email" varchar(50) COLLATE "default" NOT NULL,
    "password" varchar(64) COLLATE "default" NOT NULL,
    "status_id" int4 DEFAULT 1 NOT NULL,
    "name" varchar(500) COLLATE "default" NOT NULL,
    "sex" bool,
    "created_at" timestamp(0) DEFAULT now() NOT NULL,
    "deleted" bool DEFAULT true NOT NULL,
    "auth_key" varchar(32) COLLATE "default"
);
```
Имеется таблица клиентов – `clients`, в которой представлены клиенты системы:
```
CREATE TABLE "clients" (
    "id serial PRIMARY KEY,
    "name" varchar(255) COLLATE "default" NOT NULL,
    "description" text COLLATE "default",
    "account_type" int4 DEFAULT 1 NOT NULL,
    "balance" float8 DEFAULT 0,
    "created_by int4,
    "updated_by" int4,
    "created_at" int4,
    "updated_at" int4,
    "status" int4 DEFAULT 1,
    "deleted" bool DEFAULT false
);
```
У каждого клиента может быть свой список пользователей, но все они осуществляют процесс
авторизации на базе полей `email` и `password`.
Необходимо выполнить указанные модификации помощью стандартных YII-инструментов (там,
где это требуется).

1. Обеспечить уникальность идентификационных данных внутри системы
2. Сформировать классы моделей, которые можно было безопасно переформировать на
любом этапе работы, без потери ранее разработанного функционала модели.
3. Обеспечить возможность привязки пользователя к клиенту (сформировать миграцию)
4. Дополнить модель клиентов возможностью редактирования привязки к клиенту
5. Предусмотреть возможность связи пользователя с несколькими клиентами.
6. Обеспечить возможность (со стороны модели и базы) заведения групповых
пользователей, таких как например «Группа разработчиков», «Магазин» и т.д. Без
изменения алгоритма авторизации (email + password). С возможностью авторизоваться как
член группы разработчиков или сотрудник магазина под индивидуальными данными для
авторизации.
7. Обеспечить возможность идентификации групповых и индивидуальных пользователей в
общем списке

Пункты, требующие простых действий можно описать в общем файле. Пункты с миграциями,
обновленными классами и пр., оптимальнее всего распределять по папкам с соответствующими
названиями, чтоб можно было проследить изменение модели и структуры БД.

### Развертывание сайта

1. Установить все зависимости
```composer install```
2. Выполнить инициализацию окружения
```php init```
3. Выполнить предварительную миграцию
```php yii migrate/up 2```
4. Выполнить миграцию RBAC
```php yii migrate/up --migrationPath=@yii/rbac/migrations```
5. Выполнить оставшиеся миграции
```php yii migrate/up```
6. Настроить хостинг для административной (backend) и публичной (frontend) частей
7. Имя и пароль администратора: `admin@it-crowd.com/administrator`
