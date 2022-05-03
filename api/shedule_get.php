<?php
require_once 'config.php';

try {
    $db = new PDO ('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage();
	die();
}

if (isset($_GET['token'])) {
	if (isset($_GET['id_group'])) {
		$id_group = $_GET['id_group'];
		$token = $_GET['token'];
		//проверка токена
		$sql = sprintf('SELECT `ID` FROM `users` WHERE `TOKEN` LIKE \'%s\' AND `EXPIRATION` > CURRENT_TIMESTAMP', $token);
		$stmt = $db->query($sql)->fetch();
		
		if (isset($stmt['ID'])) {
			$result = '{"shedule":[';
			$sql = sprintf('SELECT s.ID_DAY,s.ID_TIME,l.NAME AS LESSON,t.NAME AS TEACHER,r.NAME AS ROOM FROM `shedule` AS s
							JOIN `lessons` AS l ON s.ID_LESSON = l.ID
							JOIN `teachers` AS t ON s.ID_TEACHER = t.ID 
							JOIN `rooms` AS r ON s.ID_ROOM = r.ID WHERE s.ID_GROUP=%d', $id_group);
			$stmt = $db->query($sql);
			while ($row = $stmt->fetch()) {
				$result .= sprintf('{"id_day":%d,"id_time":%d,"lesson":"%s","teacher":"%s","room":%d},',$row['ID_DAY'],$row['ID_TIME'],$row['LESSON'],$row['TEACHER'],$row['ROOM']);
			}
			$result = rtrim($result, ",");
			$result .= ']}';
		}
		else {
			$result = '{"error": {"text": "Неверный или просроченный токен"}}';
		}
	}
	else {
		$result = '{"error": {"text": "Не передан id группы"}}';
	}
}
else {
	$result = '{"error": {"text": "Не передан токен"}}';
}
echo $result;

	/*SELECT s.ID_DAY,s.ID_TIME,l.NAME AS LESSON,t.NAME AS TEACHER FROM `shedule` AS s
JOIN `lessons` AS l ON s.ID_LESSON = l.ID
JOIN `teachers` AS t ON s.ID_TEACHER = t.ID*/
?>