<?php
session_start();
$db = new mysqli("localhost", "gslproject_gsl","gslnb...","gslproject_basic");
if ($mysqli->connect_error) {
    echo "Connect Error: " . $mysqli->connect_error;
}
$u = mysqli_real_escape_string($db,$_POST['username']);
$p = mysqli_real_escape_string($db,$_POST['password']);
$sql = "INSERT INTO `Users` (`uid`, `ps`) VALUES ('$u', '$p')";
if($db->query($sql)){
	$_SESSION['user'] = $u;
	header('Location: ./index.php');
}
else{
        session_destroy();
	$_SESSION['fail_login'] = 1;
	header('Location: ./signup.html');
}
?>
