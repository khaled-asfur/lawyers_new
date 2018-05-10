<?php
$mysqli = new mysqli("localhost", "root", "lool", "lowyers_website");
$query="(select distinct c.name from customers c order by 1)union(select distinct concat(c.identity_number , '') from customers c order by 1);";
$result = $mysqli->query('SET CHARACTER SET utf8');
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;	
	}
}


# JSON-encode the response
echo $json_response = json_encode($arr);
?>