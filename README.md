## Установка

1. Указать настройки для соединения с БД в `/config.php`

2. Запустить `php install.php` для заполнения БД нужными таблицами и данными

3. Запустить php dev server `php -S localhost:8000` из папки `/public`

## API Endpoints

###

`GET /api/table`

Параметры:
- table
- id

`POST /api/sessions/participants`

Параметры:
- sessionId
- userEmail