
<?php
session_start();
// Set up database connection
require 'db/db.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query database for user with given username and password
  $query = "SELECT * FROM _user WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  // Check if user exists and has valid credentials
  if (mysqli_num_rows($result) > 0) {
    // User exists and has valid credentials, so redirect to appropriate page based on their role
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];
    $role = $row['role'];
    if ($role == 'admin') {
      header('Location: index.php');
    } else if ($role == 'formateur') {
      header('Location: formateur-dashboard.php');
    } else if ($role == 'etudiant') {
      header('Location: etudiant-dashboard.php');
    } else if ($role == 'pdg') {
      header('Location: pdg-dashboard.php');
    }
    
  } else {
// User does not exist or has invalid credentials, so show error message
$error[]= "nom d'utilisateur ou mot de passe invalide.";
}
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>MASSAR</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
   
    <div class="contents">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          
          <div class="col-md-7">
            <img src="images/logo.png" class="logo" alt="">
            <h3 class="text-center">Shemsy <strong>massar</strong></h3>
           <br>
            <form action="login.php" method="post">
              <?php 
              if (isset($error)){
                foreach($error as $error){
                  echo ' <div class="alert alert-danger" role="alert">'.$error.'</div>';
                }
              }
              ?>
           
              <div class="form-group first">
                <label for="username">Nom de utilisateur</label>
                <input type="text" class="form-control" placeholder="your-email@gmail.com" id="username" name="username" required>
              </div>
              <div class="form-group mb-3">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" placeholder="Your Password" id="password" name="password" required>
              </div>

              <input type="submit" value="CONNEXION" class="btn btn-block btn-warning text-white">

            </form>
          </div>
        </div>
      </div>
    </div>

     <div class="bg" style="background-image: url('images/flayer.png');"></div>
  </div>
    
    

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>