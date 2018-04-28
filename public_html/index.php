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
    
    <title>Sneaker Hunter</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../index.css" rel="stylesheet">
	 <!-- Animation CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.js "></script>
	
  </head>

  <body>
	<script>
		AOS.init();
	</script>
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
                <input class="form-control-sm mr-sm-2" type="text" placeholder="Username" aria-label="user" name="username">
                <input class="form-control-sm mr-sm-2" type="password" placeholder="Password" aria-label="password" name="password">
                <button class="btn btn-outline-light btn-sm mr-sm-2" type="submit">Login</button>
                <button class="btn btn-outline-success btn-sm" formaction="./signup.html" type="submit">Sign up</button>
              </nav>
            </form>
           <?php 
            }else{
          ?>
                  <form class="form-inline" action="search.php" method="post">
                    <nav class="my-2 my-md-0 mr-md-3">
                      <button type="submit" style="visibility: hidden;">button</button>
                      <input class="form-control-sm input-sm mr-sm-4" id='ssmall' placeholder="Jordan, Yeezy, Nike, ..." name="name" type="text"/>
                      <a class="p-2 text-white align-middle" href="my_list.php"><u>Hi, <?php print($_SESSION['user']);?></u></a>
                      <a class="p-3 text-white align-middle" href="my_list.php">My Profile</a>
                      <button class="btn btn-outline-secondary btn-sm" formaction="logout.php" type="submit">Log out</button>
                    </nav>
                  </form>
          <?php } ?>
        </div>
      </div>
    </header>

    <main role="main">

      <section class="jumbotron text-center">
        <div class="container text-center">
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

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">

          	<?php
          		$db = new mysqli("localhost", "gslproject_gsl", "gslnb...", "gslproject_basic");
				$sql = "SELECT sid, image FROM Sneakers ORDER BY sales DESC LIMIT 20";
				$res = $db->query($sql);
       			// $num_rows = $res->num_rows;
       			// echo $num_rows;
				$numbers = range(0, 19);
				shuffle($numbers);
				// print_r($numbers);
				$shoes = [];
				for ($i = 0; $i < 20; $i++){
					// echo $i;
					$r = $res->fetch_assoc();
					// echo $i;
					array_push($shoes, $r);
					// echo $i;
				}
				// print_r($shoes);
				for ($i = 0; $i < 9; $i++){
					$r = $shoes[$numbers[$i]];
					$shoename = $r["sid"];
					$shoeimage = $r["image"];
					?>
			<div class="col-md-4" data-aos="zoom-in">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src=<?php print("\"$shoeimage\""); ?> alt="img1">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text"><?php print($shoename); ?></p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value=<?php print("\"$shoename\""); ?>>View</button>
                  	</form>
                      <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value=<?php print("\"$shoename\""); ?>>Add to my list</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
			<?php
				}
				$db->close();
          	?>

            
          </div>
        </div>
      </div>

    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="change.html">Change Password</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="#">Back to top</a>
        </p>
        <p>Sneaker Hunter is &copy; Zhenyu Gu, Yunyi Zhang, Luyu Gao, Ruilin Zhao</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../jquery-slim.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
  </body>
</html>
