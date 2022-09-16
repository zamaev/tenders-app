# Сервис создания, хранения и получения тендеров

# Запуск
- В файле `.env.example` указать логин и пароль для базы данных.
- На локальной машине запустить команду:

    ```
    make build 
    ```

- В докер контейнере запустить команду (обязательно дождавшись полной загрузки сервера базы данных):

    ```
    make migrate
    ```
    Возможно после первого раза выдаст ошибку и придется еще раз запустить. В последней версии докера почему-то после пересборки vendor(-a) контейнер база данных "просыпается" только после пинка.


# Получение токена
- Зарегистрироваться `/register`.
- Авторизоваться `/login`.
- Получить токен.


# Загрузка тестовых данных
По задумке сервис должен предоставлять пользователям возможность загужать свою базу из файла csv. Но на данном этапе готов только функционал подгрузки данных из заранее подготовленного файла.

На странице `/update` можно подгрузить тестовые данные.

В папке `storage/app` лежит урезанная версия файла, для быстрого импорта, но так же рядом лежит и максимальаня версия. Достаточно переименовать при необходимости.

! Для загрузки новых данных по api надо будет загрузить тесовые данные, потому что по задумке новые статусы можно добавлять только из админки, и по api на новые статусы стоит запрет.

# Структура основных таблиц

| id | code        | number | status_id | name     | created_at | updated_at |
|----|-------------|--------|-----------|----------|------------|------------|
| #  | Внешний код | Номер  | Статус FK | Название | Дата созд. | Дата изм.  |

| id | name     |
|----|----------|
| #  | Название |

- Дата создания тендера указывается автоматически при создании записи (кроме случаев импорта из файла).
- Дата изменения обновляется при изменении записи (кроме случаев импорта из файла).
    Пример обновления тендера: обновление статуса тендера.

Все статусы должны быть заранее известны и не могут быть созданы через api.
Создаются они через админку, в частности пока что через импорт.


# Типы данных
- code - числое значение
- number - строка с номером
- status - строка (в контроллере уже идет сопоставление с id)
- name - название в текстовом формате
- created_at, updated_at - все стандартные форматы [даты](https://www.php.net/manual/en/datetime.formats.date.php) и [времени](https://www.php.net/manual/en/datetime.formats.time.php).


# Методы API

## Получение всех тендеров
```bash
curl http://localhost/api/tenders \
	--request GET \
	--header "Authorization: Bearer TOKEN" \
	--header "Accept: application/json" \
    --header "Content-Type: application/json"
```

## Получение тендеров с фильтрацией
```bash
curl 'http://localhost/api/tenders?
        [code=<code>]
        [&number=<number>]
        [&status=<status>]
        [&name=<name>]
        [&created_at=<created_at:date_format>]
        [&updated_at=<updated_at:date_format>]' \
	--request GET \
	--header "Authorization: Bearer TOKEN" \
	--header "Accept: application/json" \
    --header "Content-Type: application/json"
```

## Получение тендера по идентификатору
```bash
curl http://localhost/api/tenders/<id> \
	--request GET \
	--header "Authorization: Bearer TOKEN" \
	--header "Accept: application/json" \
    --header "Content-Type: application/json"
```

## Обновление статуса тендера по идентификатору
```bash
curl http://localhost/api/tenders/<id> \
	--request PUT \
	--header "Authorization: Bearer TOKEN" \
	--header "Accept: application/json" \
    --header "Content-Type: application/json" \
	--data '{
        "status" : "Статус"
    }'
```

## Добавление тендера
```bash
curl http://localhost/api/tender/ \
	--request POST \
	--header "Authorization: Bearer TOKEN" \
	--header "Accept: application/json" \
    --header "Content-Type: application/json" \
	--data '{
        "code" : "Внешний код",
        "number" : "Номер",
        "status" : "Статус"
        "name" : "Название",
    }'
```

- Если статусы ранее не были добавлены из админки, то добавить новые по api не получится.


# P.S.
Если с некоторыми версиями докера будут пробелемы с правами на папку storage, нужно будет в терминале докера запустить команду: 
```
make chmod
```