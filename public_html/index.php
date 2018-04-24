<?php
session_start();
// print($_SESSION['login_user']);
?>
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

            <!--img1-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/air-jordan-1-retro-high-bred-toe_TruView/Images/air-jordan-1-retro-high-bred-toe_TruView/Lv2/img30.jpg?auto=format,compress&w=1117&q=90" alt="img1">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">Jordan 1 Retro High Bred Toe</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="Jordan 1 Retro High Bred Toe">View</button>
                  	</form>
                      <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="Jordan 1 Retro High Bred Toe">Add to my list</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!--img2-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/air-jordan-12-retro-chinese-new-year_TruView/Images/air-jordan-12-retro-chinese-new-year_TruView/Lv2/img26.jpg?auto=format,compress&w=1117&q=90" alt="Card image cap">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">Jordan 12 Retro Chinese New Year</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="Jordan 12 Retro Chinese New Year">View</button>
                  	</form>
                    <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="Jordan 12 Retro Chinese New Year">Add to my list</button>
                  	</form>
                  </div>
                </div>
              </div>
            </div>

            <!--img3-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/adidas-yeezy-boost-350-v2-white-core-black-red_TruView/Images/adidas-yeezy-boost-350-v2-white-core-black-red_TruView/Lv2/img26.jpg?auto=format,compress&w=1117&q=90" alt="Card image cap">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">adidas Yeezy Boost 350 V2 Zebra</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="adidas Yeezy Boost 350 V2 Zebra">View</button>
                  	</form>
                    <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="adidas Yeezy Boost 350 V2 Zebra">Add to my list</button>
                  	</form>
                  </div>
                </div>
              </div>
            </div>

            <!--img4-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/adidas-human-race-nmd-pharrell-holi-festival-core-black_TruView/Images/adidas-human-race-nmd-pharrell-holi-festival-core-black_TruView/Lv2/img30.jpg?auto=format,compress&w=1117&q=90" alt="Card image cap">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">adidas Human Race NMD Pharrell Holi Festival (Core Black)</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="adidas Human Race NMD Pharrell Holi Festival (Core Black)">View</button>
                  	</form>
                    <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="adidas Human Race NMD Pharrell Holi Festival (Core Black)">Add to my list</button>
                  	</form>
                  </div>
                </div>
              </div>
            </div>

            <!--img5-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/nike-air-vapormax-off-white-2018_TruView/Images/nike-air-vapormax-off-white-2018_TruView/Lv2/img30.jpg?auto=format,compress&w=1117&q=90" alt="Card image cap">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">Air Vapormax Off White 2018</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="Air Vapormax Off White 2018">View</button>
                  	</form>
                    <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="Air Vapormax Off White 2018">Add to my list</button>
                  	</form>
                  </div>
                </div>
              </div>
            </div>

            <!--img6-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/air-jordan-13-retro-og-chicago-2017_TruView/Images/air-jordan-13-retro-og-chicago-2017_TruView/Lv2/img26.jpg?auto=format,compress&w=1117&q=90" alt="Card image cap">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">Jordan 13 Retro OG Chicago (2017)</p>
                          </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="Jordan 13 Retro OG Chicago (2017)">View</button>
                  	</form>
                    <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="Jordan 13 Retro OG Chicago (2017)">Add to my list</button>
                  	</form>
                  </div>
                </div>
              </div>
            </div>

            <!--img7-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/air-jordan-1-retro-mid-new-love-2017_TruView/Images/air-jordan-1-retro-mid-new-love-2017_TruView/Lv2/img26.jpg?auto=format,compress&w=1117&q=90">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">Jordan 1 Retro Mid New Love (2017)</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="Jordan 1 Retro Mid New Love (2017)">View</button>
                  	</form>
                    <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="Jordan 1 Retro Mid New Love (2017)">Add to my list</button>
                  	</form>
                  </div>
                </div>
              </div>
            </div>

            <!--img8-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/Air-Jordan-3-Retro-Black-Cement-2018_TruView/Images/Air-Jordan-3-Retro-Black-Cement-2018_TruView/Lv2/img30.jpg?auto=format,compress&w=1117&q=90" alt="Card image cap">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">Jordan 3 Retro Black Cement (2018)</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="Jordan 3 Retro Black Cement (2018)">View</button>
                  	</form>
                    <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="Jordan 3 Retro Black Cement (2018)">Add to my list</button>
                  	</form>
                  </div>
                </div>
              </div>
            </div>

            <!--img9-->
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <table class="text-center" style="height: 220px;">
                  <tbody>
                    <tr>
                      <td class="align-middle">
                        <img class="card-img-top" src="https://stockx-360.imgix.net/air-jordan-11-retro-space-jam-2016_TruView/Images/air-jordan-11-retro-space-jam-2016_TruView/Lv2/img26.jpg" alt="Card image cap">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="card-body">
                  <table style="height: 60px;">
                    <tbody>
                      <tr>
                        <td>
                          <p class="card-text">Jordan 11 Retro Space Jam (2016)</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex align-items-center">
                    <form action="product.php" method="post">
                      <button name="sid" type="sbumit" class="btn btn-sm btn-secondary mr-sm-2" value="Jordan 11 Retro Space Jam (2016)">View</button>
                  	</form>
                    <form action="add_to_my_list.php" method="post">
                      <button name="to_add" type="submit" class="btn btn-sm btn-secondary" value="Jordan 11 Retro Space Jam (2016)">Add to my list</button>
                  	</form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="change.php">Change Password</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="#">Back to top</a>
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
