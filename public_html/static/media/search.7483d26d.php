<html>
<body>
<?php

$db = new mysqli("localhost", "gslproject_gsl","gslnb...","gslproject_basic");
if ($db->connect_error) {
    echo "Connect Error: " . $db->connect_error;
}
#echo $_POST["maxprice"];
$n = mysqli_real_escape_string($db, $_POST["name"]);
$sql = "SELECT s.sid, releaseDate, sales, retailPrice, MAX(price), MIN(price)
	FROM Sneakers s, Transactions t
	WHERE s.sid LIKE '%$n%'
	AND s.sid = t.sid
	GROUP BY s.sid";
#echo $sql;
$result = $db->query($sql);
$num_rows = $result->num_rows;
if ($num_rows > 0){
	print("<p>" . $num_rows . " sneaker(s) found.</p>");
	while ( $row = $result->fetch_assoc() ){
		print("{$row['sid']}<br/>");
		print("&nbsp Release Date: {$row['releaseDate']}<br/>");
		print("&nbsp Sales: {$row['sales']}<br/>");
		print("&nbsp Retail Price: {$row['retailPrice']}<br/>");
		print("&nbsp Recent max price: {$row['MAX(price)']}<br/>");
		print("&nbsp Recent min price: {$row['MIN(price)']}<br/>");
		print("<br/>");
	}
	$result->free();
}
else{
	print("No sneaker found.");
}
?>
<form action="index.php" method="post">
<input type="submit" value="return">
</form>

</body>
</html>
