<!DOCTYPE html>
<html>
<head>
	<title>Лабораторная 2</title>
	<script type="text/javascript">

		function select1(value){
			var item = localStorage.getItem('IP='+value);
			var result = document.getElementById('result1');
			if(item == null){
				result.innerHTML = '';
			}else{
				result.innerHTML = item;
			}
		}

		function select2(value){
			var item = localStorage.getItem('IP2='+value);
			var result = document.getElementById('result2');
			if(item == null){
				result.innerHTML = '';
			}else{
				result.innerHTML = item;
			}
		}

		function ajaxEvent(ajax){
				if (ajax.readyState== 4)  { 
					if(ajax.status== 200) {
						var result = ajax.responseText;
						return result;
					}
					else {
						alert(ajax.status+ " -" + ajax.statusText);
						ajax.abort();
					}
				}
				return null;
		}

		function request1(){
			var ajax = new XMLHttpRequest ();
			var select = document.getElementById('IP');
			var input = select.options[select.selectedIndex].value;
			ajax.onreadystatechange = function()
			{
				var html = ajaxEvent(ajax);
				if(html != null){
					document.getElementById("result1").innerHTML = html;
					localStorage.setItem('IP='+input, html);
				}
			}
			ajax.open("POST", "request1.php", true);
			var params = "IP=" + input;
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send(params);
		}


		function request2(){
			var ajax = new XMLHttpRequest ();
			var select = document.getElementById('IP');
			var input = select.options[select.selectedIndex].value;
			ajax.onreadystatechange = function()
			{
				var html = ajaxEvent(ajax);
				document.getElementById("result2").innerHTML = html;
				localStorage.setItem('IP2='+input, html);
			}
			ajax.open("POST", "request2.php", true);
			var params = "IP=" + input;
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send(params);
		}

		function request3(){
			var ajax = new XMLHttpRequest ();
			ajax.onreadystatechange = function()
			{
				var html = ajaxEvent(ajax);
				document.getElementById("result3").innerHTML = html;
			}
			ajax.open("POST", "request3.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send(null);
		}

	</script>
</head>
<body>
<?php
require_once __DIR__."/vendor/autoload.php";
$mongo_client = new MongoDB\Client();
$db = $mongo_client->dbforlab;
$user = $db->user;
?>
<form>
	<label>Выбрать пользователя</label><br>
	<select id="IP" onchange="select1(this.options[this.selectedIndex].value);	select2(this.options[this.selectedIndex].value);">
		<?php
		$cursor = $user->find([],[]);
		foreach ($cursor as $document) {
			echo "<option value=\"{$document['IP']}\">";
			echo "{$document['login']}";
			echo "</option>";
		}
		?>
	</select>
	<input type="button" value="Сообщения" onclick="request1();">
	<input type="button" value="Общий траффик" onclick="request2();">
	<input type="button" value="Отрицательный баланс" onclick="request3();">
</form>



<div id="result1"></div>
<div id="result2"></div>
<div id="result3"></div>

</body>
</html>