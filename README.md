<h2>Описание проекта</h2>
<p>Код написан по канонам DDD + Clean Architecture</p>
<p>Данный проект реализует процесс выдачи кредита, включая следующие сценарии:</p>
<ul>
    <li><strong>Создание нового клиента</strong>.</li>
    <li><strong>Изменение информации о существующем клиенте</strong>.</li>
    <li><strong>Проверка возможности выдачи кредита</strong>.</li>
    <li><strong>Создание кредита</strong> на основе проверки и заданных условий и отправка ему уведомления (мок уведомление в лог) в случае успеха.</li>
</ul>

<h3>Условия выдачи кредита</h3>
<ul>
    <li><strong>Кредитный рейтинг клиента (FICO):</strong> больше 500.</li>
    <li><strong>Ежемесячный доход клиента:</strong> не менее $1000.</li>
    <li><strong>Возраст клиента:</strong> от 18 до 60 лет.</li>
    <li><strong>Штаты, в которых возможна выдача кредита:</strong> только CA, NY, NV.</li>
</ul>

<h3>Особые условия для штатов</h3>
<ul>
    <li><strong>Клиенты из штата NY:</strong> отказ производится случайным образом.</li>
    <li><strong>Клиенты из штата CA:</strong> процентная ставка увеличивается на 11.49%.</li>
</ul>

<h2>Запуск приложения</h2>
<p>Для запуска приложения выполните следующие шаги:</p>
<ol>
    <li><strong>Запуск Docker Compose:</strong>
        <pre>docker-compose up -d</pre>
        Эта команда запустит все необходимые сервисы, включая PostgreSQL и ваше приложение.
    </li>
    <li><strong>Убедитесь, что контейнеры запущены:</strong>
        <pre>docker-compose ps</pre>
    </li>
    <li><strong>Установите пакеты:</strong>
        <pre>docker exec -it app composer install</pre>
    </li>
</ol>

<h2>Использование приложения</h2>
<p>Ваше приложение поддерживает следующие команды Symfony:</p>

<h3>Создание клиента</h3>
<pre>docker exec -it app php bin/console app:create-client [фамилия] [имя] [возраст] [SSN] [адрес] [город] [штат] [почтовый индекс] [FICO-оценка] [доход] [email] [телефон]</pre>
<p>Пример:</p>
<pre>docker exec -it app php bin/console app:create-client "Иванов" "Иван" 30 "123-45-6789" "123 Main St" "New York" "NY" "10001" 700 50000 "ivanov@example.com" "+11234567890"</pre>

<h3>Обновление клиента</h3>
<pre>docker exec -it app php bin/console app:update-client [ID клиента] [фамилия] [имя] [возраст] [SSN] [адрес] [город] [штат] [почтовый индекс] [FICO-оценка] [доход] [email] [телефон]</pre>
<p>Пример:</p>
<pre>docker exec -it app php bin/console app:update-client 1 "Петров" "Пётр" 35 "987-65-4321" "456 New Street" "Los Angeles" "CA" "90001" 720 75000 "petrov@example.com" "+11239876543"</pre>

<h3>Создание кредита</h3>
<pre>docker exec -it app php bin/console app:create-credit [ID клиента] [название продукта] [дата завершения (timestamp)] [процентная ставка] [сумма кредита]</pre>
<p>Пример:</p>
<pre>docker exec -it app php bin/console app:create-credit 1 "Personal Loan" 1735689600 11.495 10000</pre>

<h3>Проверка клиента на кредитные условия</h3>
<pre>docker exec -it app php bin/console app:check-client [ID клиента]</pre>
<p>Пример:</p>
<pre>docker exec -it app php bin/console app:check-client 1</pre>

<h2>Инструменты для разработки</h2>
<p>Ваш проект настроен для использования следующих инструментов:</p>

<h3>PHP CS Fixer</h3>
<p>Используйте PHP CS Fixer для автоматического исправления стиля кода:</p>
<pre>composer php-cs-fixer</pre>

<h3>PHPStan</h3>
<p>Запустите PHPStan для статического анализа кода:</p>
<pre>composer phpstan</pre>

<h3>Rector</h3>
<p>Используйте Rector для рефакторинга кода:</p>
<pre>composer rector</pre>

<h2>Остановка и очистка ресурсов</h2>
<p>Чтобы остановить запущенные сервисы и очистить ресурсы Docker, используйте следующую команду:</p>
<pre>docker-compose down</pre>
<p>Если необходимо также удалить тома данных:</p>
<pre>docker-compose down -v</pre>
