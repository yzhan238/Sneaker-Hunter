<?php
session_start();
if(! isset($_SESSION["user"])){
  print ("Please Log In!");
}
else{
  $db = new mysqli("localhost", "gslproject_gsl", "gslnb...", "gslproject_basic");
  $usr = $_SESSION["user"];
  $u = mysqli_real_escape_string($db, $usr);
  $productName = $_POST["to_add"];
  $n = mysqli_real_escape_string($db, $productName);
  $sql = "INSERT INTO Own (uid, sid) VALUES ('$u', '$n')";
  $db->query($sql);
  $db->close();
  header('Location: ./my_list.php');
}
?>
