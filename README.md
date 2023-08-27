# Div test

## Install project
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `cp pre-commit .git/hooks/pre-commit` and `chmod +x .git/hooks/pre-commit`
- `php artisan migrate:refresh --seed`
- `npm install && npm run build`
- `php artisan serv`


## Почта
Письма лежат в файле `storage/logs/mailer.log`
