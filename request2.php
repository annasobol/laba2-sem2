<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
require_once __DIR__."/vendor/autoload.php";
$mongo_client = new MongoDB\Client();
$db = $mongo_client->dbforlab;
$seanse = $db->seanse;

$filter = $_POST['IP'];
$cursor = $seanse->find(['IP'=>$filter],[]);

?>
<?php
	$sum = 0;
	foreach ($cursor as $document) {
		$sum += $document['in'] + $document['out'];
	}
	echo 'Общий траффик: '.$sum;
?>

</body>
</html>