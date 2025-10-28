# Тестовое задание для Гостиничные Идеи, hotel-ideas.ru


>Представь, что ты дорабатываешь ядро BookingCore. Нужно добавить простой функционал бронирования охотничьих туров с выбором гида.
	
>**Задача**

>Создать минимальный Laravel-модуль, который реализует:

>Миграции и модели:

>Guide (поля: name, experience_years, is_active)

>HuntingBooking (поля: tour_name, hunter_name, guide_id, date, participants_count)

>API-эндпоинты:

>GET /api/guides — список активных гидов

>POST /api/bookings — создание нового бронирования

>Логика бронирования:

>Проверить, что у выбранного гида нет других бронирований на ту же дату

>Проверить, что participants_count <= 10

>Вернуть осмысленные ответы (200, 400, 422 и т.д.)

>**Что оценивается**

>Корректность и чистота кода

>Использование Laravel best practices (модели, валидация, контроллеры, ресурсы)

>Структура проекта и понятность решений

>Минимум «магии» — максимум логики

>**Бонус (по желанию)**

>Добавить простейший Unit/Feature-тест

>Сделать фильтр GET /api/guides?min_experience=3

>Коротко описать в README, как бы ты встроил это в BookingCore

>	**Время выполнения**

>	1–2 часа (в комфортном темпе).

### GosIdea, пакет для Laravel 12

Автор Минхаеров А.

---
Установка пакета. Добавить в composer.json вашего приложения Ларавел (версии 12), запись "repositories" для определения репозитория. Например:

	"repositories" : [{
			"type" : "vcs",
			"url" : "https://github.com/older777/gos-idea.git",
			"name" : "GosIdea"
		}
	]

В Composer выполнить команду установки пакета:

	composer require older777/gos-idea:"dev-main"

Выполнить публикацию

	php artisan vendor:publish --provider=Older777\\GosIdea\\Providers\\GosIdeaServiceProvider

Выполнить команду миграции

	php artisan migrate

Выполнить команду 

	php artisan db:seed --class=Older777\\Gosidea\\database\\seeders\\GuideSeeder

После запуска проверить наличие роутов */api/guides* и */api/bookings*

	php artisan route:list

Выполнить запросы к роутам. Получение списка гидов, фильтрация по опыту (ответ JSON объект)

	curl --location 'http://localhost/api/guides'
	curl --location 'http://localhost/api/guides?min_experience=23'

Выполнить запрос более 4 раз подряд, получить ошибку Rate Limit - ограничение на кол-во запросов в минуту.

Выполнить запрос API для бронирования

	curl --location 'http://localhost/api/bookings' \
		--header 'Content-Type: application/json; charset=utf-8' \
		--data '{
    		"tour_name" : "Охота на суслика",
    		"hunter_name" : "Пушкин",
    		"guide_id" : "1",
    		"date" : "2026-08-01",
    		"participants_count": "10"
		}'

Ответ приложения 

	{
    	"success": true,
    	"message": "Гид забронирован"
	}

### Тестирование пакета

Для проведения тестов необходимо, установить необходимые пакеты. Выполнить команды

	cd vendor/older777/gos-idea
	composer install

Запустить тестирование

	./vendor/bin/phpunit

Будет выполнен тест из файла *HuntingBookingRequestTest*, сообщение PHPUnit *OK (4 tests, 1 assertion)* в случае успешного тестирования.
