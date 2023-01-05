<?php
//Секретный ключ проекта. Его можно посмотреть в редактировании проекта.
define ('SECRET_KEY',	'XXXXXXXXXXXXXXX');
// Конфигурация RCON
define ('RCON_ADDRESS', '');//IP адрес RCON
define ('RCON_PORT', '');//Порт RCON
define ('RCON_PASSWORD', '');//Пароль RCON

require_once('RCON.php');

//Пример команды для плагина EssentialsX. {username} будет заменен на полученный юзернейм после всех проверок.
define ('RCON_COMMAND', 'eco give {username} 15');

//Возвращаем 500, в случае ошибок.
function return500($string){
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Server Error', TRUE, 500);
	die(htmlspecialchars($string));
}

// Достаем переменные из POST запроса
$project = $_POST['project'];
$username = $_POST['username'];
$timestamp = $_POST['timestamp'];
$signature = $_POST['signature'];

//Убедимся, что прислали все нужные значения
if (! $project || ! $username || ! $timestamp || ! $signature)
{
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
//Соеднинение и исполнение RCON комманды
$rcon = new Rcon(RCON_ADDRESS, RCON_PORT, RCON_PASSWORD, 2);
if($rcon->connect()){
    $rcon->sendCommand(str_replace('{username}', $username, RCON_COMMAND));
}
else{
    return500('RCON connection failed');
}
// Ответим мониторингу что все без ошибок
echo 'done';
return;
?>
