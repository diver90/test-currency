
## Установка
Запустить команды
1. composer install
2. php artisan migrate
3. php artisan db:seed 
4. php artisan currencies:load

## Запуск
Запустить команду

php artisan serve

##Использование
ОТправить GET запрос на URL 
127.0.0.1:8000/api/convert
с параметрами 
- sum(сумма валюты для конвертации)
- base - трехзначный символ валюты, в которую нужно конвертировать
- quote - трехзначный символ валюты, из которой нужно конвертировать
Например, 127.0.0.1:8000/api/convert?sum=1&base=BOB&quote=UAH

##Для обновления котировок
В cron добавить
```
* * * * * cd /путь к проекту && php artisan schedule:run >> /dev/null 2>&1
```
