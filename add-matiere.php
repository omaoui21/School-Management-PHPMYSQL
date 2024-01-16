<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['nom'];
    $id_filiere=$_POST['id_filiere'];
    $username = $_SESSION['username'];


    $sql = "INSERT INTO module (nom_module,filiere_id) VALUES ('$nom','$id_filiere')";
    if(mysqli_query($conn, $sql)){
        header('Location:matiere.php?success=ajouter');
    } else{
        echo "Error: " . mysqli_error($conn);
    }
}
     

          
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Matière</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'navbar/navbar.php' ?>


<div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row align-items-center">
<div class="col">
<h3 class="page-title">Ajouter Matière</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="matiere.php">Matière</a></li>
<li class="breadcrumb-item active">Ajouter Matière</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-body">
<form method="POST" action="add-module.php">
<div class="row">
<div class="col-12">

<h5 class="form-title"><span>Matière</span></h5>
</div>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Nom Matière <span class="login-danger">*</span></label>
<input type="text" class="form-control" name="nom" required>
</div>
</div>
<?php 
 $sql ="SELECT filiere.nom_filiere,filiere.id
 FROM filiere
 INNER JOIN centre ON centre.id = filiere.centre_id
 INNER JOIN _admin ON _admin.centre_id = centre.id
 INNER JOIN _user ON _user.id = _admin.user_id
 WHERE _user.username ='$username'";
     $result = $conn->query($sql);

     $filieres = [];
     if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
             $filieres[] = $row;
             
         }
        
     }   
?>
<div class="col-12 col-sm-4">
<div class="form-group local-forms">
<label>Choisi Filiere <span class="login-danger">*</span></label>
<select  name="id_filiere" class="form-control select" required>
<?php foreach ($filieres as $filiere) : ?>
    <option value="<?php echo $filiere['id']?>"><?php echo $filiere['nom_filiere']?></option>
<?php endforeach; ?>
</select>
</div>
</div>

<div class="col-12">
<div class="student-submit">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

</div>


<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>