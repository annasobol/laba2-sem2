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

$filter = $_POST['IP'];
$cursor = $user->find(['IP'=>$filter],[]);

?>
<?php
echo 'Сообщения';
echo '<table border="2">';
	foreach ($cursor as $document) {
		echo '<tr>';
		echo '<td>'.$document['IP'].'</td>';
		echo '<td>'.$document['login'].'</td>';
		echo '<td> Messages:';
		foreach ($document['messages'] as $item) {
			echo '\"'.$item.'\"" ';
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
?>

</body>
</html>