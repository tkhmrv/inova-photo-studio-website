# Fullstack-разработка веб-сайта фотостудии «Inova»

Проект веб-сайта для фотостудии «Inova», разработанный с использованием технологий Fullstack. Сайт включает в себя функционал для заказа услуг, аренды фотостудии, записи на встречи, а также управления личными профилями пользователей.

## Описание

Веб-сайт предоставляет следующие возможности:
- Заказ услуг фотостудии и аренда студии;
- Регистрация и авторизация пользователей;
- Управление личным кабинетом (смена данных, удаление аккаунта, подтверждение почты);
- Оставление комментариев, просмотр новостей и проектов;
- Интеграция с системой Yclients для управления бронированиями;
- Подключение к социальным сетям для удобства пользователей.

## Технологии

Проект использует следующие технологии:
- **Frontend**:
  - HTML, CSS, SCSS, Bootstrap
  - JavaScript, jQuery, Fetch API
  - Glightbox, Tiny Slider, AOS
- **Backend**:
  - PHP, MySQL
  - Nginx, Hestia (для серверной части)
  - Composer, PHPmailer, PHP dotenv
- **Базы данных**:
  - MySQL (9 таблиц)
- **Интеграции**:
  - Yclients (для бронирования)

## Установка

1. Клонируйте репозиторий:
    ```bash
    git clone https://github.com/username/inova-photostudio.git
    cd inova-photostudio
    ```

2. Обновите версии библиотек и фреймворков (если это требуется)

3. Настройте сервер:
    - Установите Nginx и настройте его для работы с PHP.
    - Создайте базу данных MySQL и импортируйте структуру (смотрите в SQL файлах).
    
4. Настройте систему для работы с Yclients и соцсетями.

5. Запустите сервер и откройте сайт в браузере.

## Требования

- Поддерживаемые браузеры: Chrome, Firefox, Safari, Edge.
- Сервер: Nginx, PHP, MySQL.
- SSL/TLS сертификат для обеспечения безопасности.

## Лицензия

Этот проект распространяется под лицензией MIT. Подробности см. в файле `LICENSE`.
