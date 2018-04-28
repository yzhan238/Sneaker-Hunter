<head>
<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
crossorigin="anonymous">
</head>
<?php
session_start();
if(! isset($_SESSION["user"])){
	print ("Please Log In!");
}
else{
	$db = new mysqli("localhost", "gslproject_gsl", "gslnb...", "gslproject_basic");
	$usr = $_SESSION["user"];
	$u = mysqli_real_escape_string($db, $usr);
	$productName = $_POST["userShoeName"];
	if (strcmp($productName, "") != 0){
		$n = mysqli_real_escape_string($db, $productName);
		$sql = "INSERT INTO Own (uid, sid) VALUES ('$u', '$n')";
		$db->query($sql);
	}
	$sql2 = "SELECT sid, rating FROM Own WHERE uid='$u'";
	$result = $db->query($sql2);
	$num_rows = $result->num_rows;
	if ($num_rows > 0){
		print("<p> Sneaker(s) you have: </p>");
		while ( $row = $result->fetch_assoc() ){
			print("Name: {$row['sid']}&nbsp Rating: {$row['rating']}<br/>");
		}
		$result->free();
	}
	else{
		print("You don't have any sneaker.");
	}
	$db->close();
}
?>
<form action="index.php" method="post">
<input class='btn btn-primary' type="submit" value="return">
</form>


