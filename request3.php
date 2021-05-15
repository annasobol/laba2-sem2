<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
require_once __DIR__."/vendor/autoload.php";
$mongo_client = new MongoDB\Client();
$db = $mongo_client->dbforlab;
$user = $db->user;

$cursor = $user->find([
	'balance'=>['$lt'=>0]
],[]);

?>
<?php
echo 'Отрицательный баланс';
echo '<table border="2">';
	foreach ($cursor as $document) {
		echo '<tr>';
		echo '<td>'.$document['IP'].'</td>';
		echo '<td>'.$document['login'].'</td>';
		echo '<td>('.$document['password'].')</td>';
		echo '<td>$'.$document['balance'].'</td>';
		echo '</tr>';
	}
	echo '</table>';
?>

</body>
</html>