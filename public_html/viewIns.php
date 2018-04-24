<?php
session_start();
// print($_SESSION['login_user']);
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Instagram Pictures</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="2-col-portfolio.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    
    <header>
      <div class="navbar navbar-dark bg-dark box-shadow fixed-top">
        <div class="container d-flex">
          <a href="../index.php" class="navbar-brand d-flex align-items-center">
            <img class="card-img-top img-responsive" src="../img0.png" alt="img0">
            <strong>SneakerHunter</strong>
          </a>
          <?php
          if(!isset($_SESSION['user'])){
                    $nouser = 1;
          ?>
            <form action="login.php" class="form-inline" method="post">
              <nav class="my-2 my-md-0 mr-md-3">
                <!-- <div class="form-group align-items-center"> -->
                  <input class="form-control-sm mr-sm-2" type="text" placeholder="Username" aria-label="user" name="username">
                  <input class="form-control-sm mr-sm-2" type="password" placeholder="Password" aria-label="password" name="password">
                  <button class="btn btn-outline-light btn-sm mr-sm-2" type="submit">Login</button>
                  <button class="btn btn-outline-success btn-sm" formaction="./signup.html" type="submit">Sign up</button>
                <!-- </div> -->
              </nav>
            </form>
           <?php 
            }else{
          ?>
              <nav class="my-2 my-md-0 mr-md-3 align-middle">
                <!-- <form class="form-inline"> -->
                    <form class="form-group align-items-center" action="search.php" method="post">
                      <button type="submit" style="visibility: hidden;">button</button>
                      <input class="form-control-sm input-sm mr-sm-4" placeholder="Jordan, Yeezy, Nike, ..." name="name" type="text"/>
                      <a class="p-2 text-white align-middle" href="my_list.php"><u>Hi, <?php print($_SESSION['user']);?></u></a>
                      <a class="p-3 text-white align-middle" href="my_list.php">My Profile</a>
                      <button class="btn btn-outline-secondary btn-sm" formaction="logout.php" type="submit">Log out</button>
                    </form>
                <!-- </form> -->
              </nav>
          <?php } ?>
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4">Pictures from Instagram
      </h1>

      <div class="row">
        <?php
        $db = new mysqli("localhost", "gslproject_gsl","gslnb...","gslproject_basic");
        if ($db->connect_error) {
            echo "Connect Error: " . $db->connect_error;
        }
        $n = mysqli_real_escape_string($db, $_POST["sid"]);
        $sql2 = "SELECT i.image FROM Sneakers s, Images i WHERE s.sid='$n' AND s.hashtag = i.tag";
        $res = $db->query($sql2);
        $num_rows = $res->num_rows;
        $i = 0;
        while($i < 4){
          $r = $res->fetch_assoc();
          $img = $r["image"];
          // echo $img;
          print("
            <div class=\"col-lg-6 portfolio-item\">
            <a><img class=\"card-img-top\" src=\"{$img}\" alt=\"\"></a>
            </div>
            ");
          $i = $i + 1;
        }
        $db->close();
        ?>
      </div>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <div class="text-center">
      <form action="index.php" method="post">
        <button class="btn btn-outline-secondary text-center" type="submit">Return</button>
      </form>
    </div>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Back to top</a>
        </p>
        <br><br><br>
        <p>Sneaker Hunter is &copy; Zhenyu Gu, Yunyi Zhang, Luyu Gao, Ruilin Zhao</p>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../jquery-slim.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
  </body>
</html>
