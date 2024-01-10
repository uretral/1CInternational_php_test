# Тест задание по PHP

## Список зависимостей

На компьютере должен быть установлен php 8.1 и docker. 

### Фреймворк

- Slim - https://www.slimframework.com/docs/v4/
- Slim DI - https://php-di.org/doc/frameworks/slim.html
- Slim PSR7 - https://github.com/slimphp/Slim-Psr7

### Дополнительные зависимости

- Bitrix MVC - https://github.com/Uru-ruru/bitrix-mvc/tree/master/docs
- Models for Digital River - https://api.shareit.com/HelpShareit/index.html

## Установка

1. Склонировать репозиторий
2. Установить зависимости композера
```shell
docker run --rm --interactive --tty \
   --volume $PWD:/app \
   composer install  
   ```
3. Запустить тест сервер и зайти на http://localhost:8000/ и http://localhost:8000/user/1

## Задание

1. Создать новую ветку для работы с названием feature/test-{date}
2. Создать новый сервис для вывода списка пользователей в папке `src/Services`. Реализовать в нем метод для показа списка пользователей `User::GetList()`
3. Создать контроллер в папке `src/Controllers` который использует зависимый сервис через DI и имеет метод возвращающий список пользователей в виде json.
4. Добавить новый роут в приложение вызывающий контроллер списка пользователей.
5. Добавить обработку ошибок при запросе списка пользователей.
6. 


