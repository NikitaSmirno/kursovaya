<?php

$host = 'db';
$db_name = 'students';
$db_user = 'root';
$db_pas = '123';

try {
    $db = new PDO('mysql:host='.$host.';dbname='.$db_name, $db_user, $db_pas);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
}

$result = '{"students":[';
$stmt = $db->query("SELECT s.ID,s.SURNAME, `s`.`NAME`,g.NAME AS GR FROM `students` AS s JOIN `groups` AS g on s.ID_GROUP=g.ID;");
while ($row = $stmt->fetch()) {
    $result .= sprintf('{"id":%d,"surname":"%s","name":"%s","group":"%s"},',$row['ID'],$row['SURNAME'],
    $row['NAME'],$row['GR']);
}
$result = rtrim($result, ",");
$result .= ']}';

echo $result;
?>
