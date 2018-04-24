<?php
session_start();
// print($_SESSION['login_user']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Search Result</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../index.css" rel="stylesheet">
  </head>

  <body>

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

    <main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="text-white font-weight-bold bg-dark">Welcome&nbsp to&nbsp Sneaker&nbsp Hunter
            <p> </p>
            <p class="lead text-white font-italic bg-dark">Discover all latest released and hottest shoes</p>
          </h1>
          <form action="search.php" method="post">
            <p>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Jordan, Yeezy, Adidas, Nike, Air, ..." aria-label="search" aria-describedby="basic-addon2" name="name">
                <button class="btn btn-info btn-lg" type="submit">Search</button>
              </div>
            </p>
          </form>
        </div>
      </section>


<?php

$db = new mysqli("localhost", "gslproject_gsl","gslnb...","gslproject_basic");
if ($db->connect_error) {
    echo "Connect Error: " . $db->connect_error;
}
#echo $_POST["maxprice"];
$n = mysqli_real_escape_string($db, $_POST["name"]);
$sql = "SELECT s.sid, releaseDate, sales, retailPrice, MAX(price), MIN(price), image
	FROM Sneakers s, Transactions t
	WHERE s.sid LIKE '%$n%'
	AND s.sid = t.sid
	GROUP BY s.sid";
#echo $sql;
$result = $db->query($sql);
$num_rows = $result->num_rows;
if ($num_rows > 0){
	print("<div class=\"text-center\"
          <h1>
            <br>"
             . $num_rows ." sneaker(s) found.
            <br>
            <br>
          </h1>
        </div>");
  print("
        <div class=\"album py-5 bg-light\">
          <div class=\"container\">

          <div class=\"row\">
  ");
	while ( $row = $result->fetch_assoc() ){

		// print("{$row['sid']}<br/>");
		// print("&nbsp Release Date: {$row['releaseDate']}<br/>");
		// print("&nbsp Sales: {$row['sales']}<br/>");
		// print("&nbsp Retail Price: {$row['retailPrice']}<br/>");
		// print("&nbsp Recent max price: {$row['MAX(price)']}<br/>");
		// print("&nbsp Recent min price: {$row['MIN(price)']}<br/>");
		print("
    			  <div class=\"col-md-4\">
              <div class=\"card mb-4 box-shado\">
                <table class=\"text-center\" style=\"height: 180px;\">
                  <tbody>
                    <tr>
                      <td class=\"align-middle\">
                        <img src=\"{$row['image']}\" width=\"280\" />
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class=\"card-body\">
                  <table style=\"height: 60px;\">
                    <tbody>
                      <tr>
                        <td>
                          <p class=\"card-text\">{$row['sid']}</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class=\"d-flex justify-content-between align-items-center\">
                    <div class=\"btn-group\">
                      <form action=\"product.php\" method=\"post\">
                      <button name=\"sid\" type=\"submit\" class=\"btn btn-sm btn-secondary mr-sm-2\" value=\"{$row['sid']}\">View</button>
                      </form>
                      <form action=\"add_to_my_list.php\" method=\"post\">
                      <button name=\"to_add\" type=\"submit\" class=\"btn btn-sm btn-secondary\" value=\"{$row['sid']}\">Add to my list
                      </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>"
		);
		// print("<br/>");
	}
  print("</div>
      </div>
      </div>");
	$result->free();
}

else{
	print("<div class=\"text-center\"
          <h1>
            <br>
            No sneaker found.
            <br>
            <br>
          </h1>
        </div>");
}
?>
    <div class="text-center">
      <form action="index.php" method="post">
        <button class="btn btn-outline-secondary text-center" type="submit">Return</button>
      </form>
    </div>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="change.php">Change Password</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="#">Back to top</a>
        </p>
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
