### ![TravelHack](https://travelhack.moscow/static/img/logo-menu.svg) MOSCOW TRAVEL HACK 2021

# Команда Бродяги - Кейс Русатома
![Rusatom](https://storage.energybase.ru/thumbnails/2500x/27/572885.png)

### Алгоритм сортировки контента по релевантности на туристическом сайте

# Готовое решение

* Получение данных из Google Search API и ранжирование туристического контента по релевантности
* Умная система фильтров - релевантность, радиус поиска
* Функционал получение геоданных пользователя и поиска ближайших к нему объектов

## Локальный запуск (Linux / macOS):

### Зависимости

* git (`apt install git`)
* make (`apt install make`)
* docker / docker-compose (`apt install docker-compose`)

### Сборка

* `cp .env.example .env`
* `make docker-build`
* `make composer-install`
* `make npm-install`
* `make npm-dev`

### Планы развития:

* Возможность оценки релевантности контента с разбивкой по языковым предпочтениям пользователей
