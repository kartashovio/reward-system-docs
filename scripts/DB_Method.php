<?php
//Секретный ключ проекта. Его можно посмотреть в редактировании проекта.
define ('SECRET_KEY',	'XXXXXXXXXXXXXXX');
// Конфигурация БД
define ('DB_HOSTNAME', 	'');//IP адрес базы данных
define ('DB_USERNAME', 	'');//Логин базы данных
define ('DB_PASSWORD', 	'');//Пароль базы данных
define ('DB_DATABASE', 	'');//Имя базы данных

//Пример выдачи предмета с айди 1, с помощью плагина REDEEM
define (SQL_QUERY, "INSERT INTO `redeem` (`player`, `item`) VALUES('{username}', 1)");

//Пример выдачи 100 монет с помощью плагина iConomy
//define (SQL_QUERY, "UPDATE `iconomy` SET `balance`=`balance`+100 WHERE `username`='{username}'");

//Возвращаем 500, в случае ошибок.
function return500($string){
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Server Error', TRUE, 500);
	die(htmlspecialchars($string));
}

//Достаём переменные из POST запроса
$project = $_POST['project'];
$username = $_POST['username'];
$timestamp = $_POST['timestamp'];
$signature = $_POST['signature'];

//Убедимся, что прислали все нужные значения
if (! $project || ! $username || ! $timestamp || ! $signature){
	return500('Incomplete request');
}

//Проверим подпись
//Только при наличии секретного ключа проекта можно сформировать подпись
//Таким образом можно убедиться что запрос был сформирован mineserv.top
$template = '$project.$secret.$timestamp.$username';
$vars = array(
  '$project' => $project,
  '$secret' => SECRET_KEY,
  '$timestamp' => $timestamp,
  '$username' => $username
);
$to_hash = strtr($template, $vars);
$self_sign = hash('sha256', $to_hash);
if ($self_sign != $signature){
	return500('Signature check failed');
}

// Подключение к БД
if (! $connection = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)){
	return500('Error connecting to the DB');
}
if (! mysqli_select_db($connection, DB_DATABASE)){
	return500('Error choosing the DB');
}
// Предпроцессинг юзернейма
$username = mysqli_real_escape_string($connection, $username);


//Выполняем запрос в базу данных
if (! mysqli_query($connection, str_replace('{username}', $username, SQL_QUERY))){
	return500('DB error: ' . mysqli_error());
}

// Закрываем соединение с базой
mysqli_close($connection);
// Ответим мониторингу что все без ошибок
echo 'done';
return;
?>