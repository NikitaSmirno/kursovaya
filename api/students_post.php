<?php

$name = null;
$surname = null;
$id_group = 0;


if (isset($_GET['name']) && isset($_GET['surname']) &&
	isset($_GET['id_group'])) {
	$name = $_GET['name'];
	$surname= $_GET['surname'];
	$id_group = $_GET['id_group'];
	
	
}
else {
	die ('<h1>Не предан параматр name</h1>');
}

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

$sql = "INSERT INTO `students`(`NAME`, `SURNAME`, `ID_GROUP`) VALUES ('".$name."','".$surname."','".$id_group."')";
$affectedRowsNumber = $db->exec($sql);

echo 'Записей вставлено:'.$affectedRowsNumber;

?>
