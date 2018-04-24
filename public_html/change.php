<?php
session_start();
$db = new mysqli("localhost", "gslproject_gsl","gslnb...","gslproject_basic");
if ($mysqli->connect_error) {
    echo "Connect Error: " . $mysqli->connect_error;
}
$u = mysqli_real_escape_string($db,$_POST['username']);
$p = mysqli_real_escape_string($db,$_POST['password']);
$np = mysqli_real_escape_string($db,$_POST['newpass']);
$sql1 = "SELECT * FROM `Users` WHERE `uid` = '$u' AND `ps`='$p'";
$sql2 = "Update `Users` SET `ps`='$np' WHERE `uid` = '$u'";
#print($sql1);
#print(mysqli_num_rows($db->query($sql1)));
if(mysqli_num_rows($db->query($sql1))== 1){
        $db->query($sql2);
	header('Location: index.php');
}
else{
	$_SESSION['fail_change'] = 1;
	header('Location: ./change.html');
}
?>
