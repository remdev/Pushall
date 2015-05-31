<?php

$dir = __DIR__ .'/src/Remdev/Pushall';
require $dir .'/bootstrap.php';

$pushall = new Remdev\Pushall\Cast();
$id = 145;
$token = '';
try{

	$pushall->setParams($id,$token);
	$result = $pushall->query("broadcast",array("title"=>"Тест","text"=>"Весь канал получит это"));
} catch (Remdev\Pushall\Exceptions\InvalidTokenException $e) {
	echo "Токен неправильный";
} catch (Remdev\Pushall\Exceptions\ConnectionException $e) {
	echo "Ошибка подключения";
}

if(isset($result['success'])) {
	echo 'Успешно оправлено!';
} elseif(isset($result['error'])) {
	echo 'Возникла ошибка '.$result['error'];
}