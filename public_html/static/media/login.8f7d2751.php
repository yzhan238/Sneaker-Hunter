<?php
session_start();
$db = new mysqli("localhost", "gslproject_gsl","gslnb...","gslproject_basic");
if ($mysqli->connect_error) {
    echo "Connect Error: " . $mysqli->connect_error;
}
$u = mysqli_real_escape_string($db,$_POST['username']);
$p = mysqli_real_escape_string($db,$_POST['password']);
$sql = "SELECT uid FROM Users  WHERE uid = '$u' AND ps = '$p'";
$_SESSION['login_user'] = $myusername;
//echo $sql;
//echo mysqli_num_rows($db->query($sql));
if(mysqli_num_rows($db->query($sql))== 1){
	//echo '<script language="javascript">';
	//echo 'alert("successfully login")';
	//echo '</script>';
	//session_start();
	$_SESSION["user"] = $u;
	header('Location: index.php');
}else{
        session_destroy();
	echo '<script language="javascript">';
        echo 'alert("haha")';
        echo '</script>';
}
?>
<script language="javascript">
document.location.href="/";
</script>
