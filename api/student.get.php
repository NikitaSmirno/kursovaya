<?php
require_once 'config.php';

try {
    $db = new PDO ('pgsql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage();
	die();
}

if (isset($_GET['token'])) {
	$token = $_GET['token'];
	//проверка токена
	$sql = sprintf('SELECT "ID" FROM "users" WHERE "TOKEN" LIKE \'%s\' AND "EXPIRATION" > CURRENT_TIMESTAMP', $token);
	$stmt = $db->query($sql)->fetch();
	
	if (isset($stmt['ID'])) {
		$result = '{"students":[';
		$stmt = $db->query('SELECT "ID","SURNAME","NAME" FROM "students" ');
		while ($row = $stmt->fetch()) {
			$result .= sprintf('{"id":%d,"surname":"%s","name":"%s"},',$row['ID'],$row['SURNAME'],$row['NAME']);
		}
		$result = rtrim($result, ",");
		$result .= ']}';
	}
	else {
		$result = '{"erroro": {"text": "Неверный или просроченный токен"}}';
	}
}
else {
	$result = '{"error": {"text": "Не передан токен"}}';
}
echo $result;
?>
	
