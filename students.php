<?php

$host = 'db';
$db_name = 'students';
$db_user = 'root';
$db_pas = '123';

try {
    $db = new PDO ('mysql:host='.$host.';dbname='.$db_name, $db_user, $db_pas);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
}    

// генерируем таблицу
$result = '<table>';
$result .= '<tr>';
$result .= '<th>ID</th>';
$result .= '<th>Имя</th>';
$result .= '<th>Фамилия</th>';
$result .= '<th>Группа</th>';
$result .= '</tr>';
// заполним таблицу данными из бд
$stmt = $db->query("SELECT s.ID,s.SURNAME,`s`.`NAME`,g.NAME AS GR FROM `students` AS s JOIN `groups` AS g on s.ID_GROUP=g.ID;");
while ($row = $stmt->fetch()) {
	$result .= '<tr>';
	$result .= '<td>'.$row['ID'].'</td>';
	$result .= '<td>'.$row['SURNAME'].'</td>';
	$result .= '<td>'.$row['NAME'].'</td>';
	$result .= '<td>'.$row['GR'].'</td>';
	$result .= '</td>';
}
$result .= '</table>';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Студенты</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php echo $result; ?>
</body>
</html>
