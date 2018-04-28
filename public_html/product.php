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
      <title>Product Page</title>

      <!-- Bootstrap core CSS -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
      <link href="../index.css" rel="stylesheet">
    </head>
    
  <?php
    // foreach ($_POST as $x) echo($x);
    $db = new mysqli("localhost", "gslproject_gsl","gslnb...","gslproject_basic");
    if ($db->connect_error) {
        echo "Connect Error: " . $db->connect_error;
    }
    #echo $_POST["maxprice"];
    $n = mysqli_real_escape_string($db, $_POST["sid"]);
    // $n = mysqli_real_escape_string($db, "Jordan 1 Retro High Bred Toe");
    $sql = "SELECT s.sid, releaseDate, sales, retailPrice, MAX(price), MIN(price), image
      FROM Sneakers s, Transactions t
      WHERE s.sid LIKE '%$n%'
      AND s.sid = t.sid
      GROUP BY s.sid";
    $sql2 = "SELECT *
      FROM Twitter 
      WHERE sid LIKE '%$n%'";
    $result = $db->query($sql);
    //$num_rows = $result->num_rows;
    // print($num_rows);
    $row = $result->fetch_assoc();
    //price, link
    $tweets = $db->query($sql2);
    // print($row);
  ?>
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

    <!-- Page Content -->
    <div class="container">

      <!-- Portfolio Item Heading -->
      <h1 class="my-4">
        <br>
        <br>
        <?php print($row['sid']); ?>
      </h1>

      <!-- Portfolio Item Row -->
      <div class="row">

        <div class="col-md-8">
          <?php print("<img class=\"img-fluid\"  src=\"{$row['image']}\" >"); ?>
        </div>

        <div class="col-md-4">
          <!-- <h3 class="my-3">Project Description</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p> -->
          <h3 class="my-3 text-center">Product Details</h3>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <div class="d-flex w-100 justify-content-between">
                <h6>Total Pairs Sold:</h6>
                <h6>
                  <?php print($row['sales']); ?>
                </h6>
              </div>
            </li>
            <li class="list-group-item">
              <div class="d-flex w-100 justify-content-between">
                <h6>Retail Price: </h6>
                <h6>
                  $<?php print($row['retailPrice']); ?>
                </h6>
              </div>
            </li>
            <li class="list-group-item">
              <div class="d-flex w-100 justify-content-between">
                <h6>Highiest Sale Price: </h6>
                <h6>
                  $<?php print($row['MAX(price)']); ?>
                </h6>
              </div>
            </li>
            <li class="list-group-item">
              <div class="d-flex w-100 justify-content-between">
                <h6>Lowest Sale Price: </h6>
                <h6>
                  $<?php print($row['MIN(price)']); ?>
                </h6>
              </div>
            </li>
          </ul>
          <br>
          <div class="text-center">
          <form action="add_to_my_list.php" method="post">
            
              <button name="to_add" type="submit" class="btn btn-success" value=<?php print("\"{$row['sid']}\""); ?>>Add to my list
              </button>
            
          </form>
          <br>
          <form action="viewIns.php" method="post">
            <button name="sid" class="btn btn-info" type="submit" value=<?php print("\"{$row['sid']}\"");?>>View Instagram Pictures</button>
          </form>
          </div>
        </div>

      </div>
      <!-- /.row -->

      <!-- Related Projects Row -->
      <h3 class="my-4">Picked For You</h3>

      <div class="row">

        <?php
        $db = new mysqli("localhost", "gslproject_gsl","gslnb...","gslproject_basic");
        if ($db->connect_error) {
            echo "Connect Error: " . $db->connect_error;
        }
        $n = mysqli_real_escape_string($db, $_POST["sid"]);
        $sql2 = "SELECT r.sid2, r.rank, s.image FROM Recom r, Sneakers s WHERE r.sid='$n' AND s.sid=r.sid2 AND r.sid2 NOT LIKE'%\'%' ORDER BY r.rank LIMIT 4";
        // $sql2 = "SELECT sid2 FROM Recom WHERE sid='$n' LIMIT 4";
        $res = $db->query($sql2);
        // $num_rows = $res->num_rows;
        while($r = $res->fetch_assoc()){
          // echo $r['rank'];
          // $sql3 = "SELECT image FROM Sneakers WHERE sid = '{$r['sid2']}'";
          $img = $r['image'];
          // $img = $res->fetch_assoc()['image'];
          print("

            <div class=\"col-md-3 col-sm-6 mb-4\">
              <table class=\"text-center\" style=\"height: 170px;\">
                <tbody>
                  <tr>
                    <td class=\"align-middle\">
                      <img class=\"img-fluid\" src=\"{$img}\" alt=\"\">
                    </td>
                  </tr>
                </tbody>
              </table>
                <form action=\"product.php\" method=\"post\">
                  <div class=\"text-center\">
                    <button name=\"sid\" type=\"submit\" class=\"btn btn-sm btn-outline-secondary\" value=\"{$r['sid2']}\">View</button>
                  </div>
                </form>
            </div>
            ");
          $i = $i + 1;
        }
        $db->close();
      ?>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->
    <div class="container">
    <h3 class="my-4">Individual Sellers</h3>
      <div class="span5 text-center">
        <!-- <div class="col-sm-8"> -->
          <table class="table table-striped">
              <tr>
                <th scope="col">Twitter ID</th>
                <th scope="col"># of Follower</th>
                <th scope="col">Resell Link</th>
                <th scope="col">Price</th>
              </tr>
              <?php
                while ( $row = $tweets->fetch_assoc() ){
              ?>
              <tr class="text-muted">
                <td><p><?php print($row['user']); ?></p></td>
                <td><p><?php print($row['followers']); ?></p></td>
                <td><a href= <?php print("\"{$row['link']}\""); ?>><?php print($row['link']); ?></a>
                <td><?php print($row['price']); ?></td>
              </tr>
          <?php
            }
          ?>   
          </table>
        <!-- </div> -->
      </div>
    </div>


    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="change.html">Change Password</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="#">Back to top</a>
        </p>
        <p>Sneaker Hunter is &copy; Zhenyu Gu, Yunyi Zhang, Luyu Gao, Ruilin Zhao</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../jquery-slim.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>

  </body>

</html>
