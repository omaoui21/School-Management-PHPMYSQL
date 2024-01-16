<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'formateur') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';
$username=$_SESSION['username'];
    $sql = "SELECT formateur.id
            FROM formateur
            INNER JOIN _user ON _user.id = formateur.user_id
            WHERE _user.username = '$username'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $formateurId = $row['id'];

    // Get the modules taught by the formateur
    $sql = "SELECT module_to_module.id, module_to_module.nom_mudole,module_to_module.heure,module.nom_module
    FROM module_to_module
    INNER JOIN module ON module.id = module_to_module.module_id
    INNER JOIN module_formateur ON module_formateur.module_id = module.id
    WHERE module_formateur.formateur_id = $formateurId";
    $result = $conn->query($sql);
    $filieres = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filieres[] = $row;
            
        }
       
    }   

          
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Modules</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&display=swap">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'navbar/navbar.php' ?>

<div class="page-wrapper">
<div class="content container-fluid">
<?php
if (isset($_GET['warning']) && $_GET['warning'] == "error") {
    echo '<div class="alert alert-warning" role="alert">
              No module found
          </div>';

    echo '<script>
              if (typeof window.history.replaceState === "function") {
                  var url = window.location.href;
                  url = url.replace("?warning=error", "");
                  window.history.replaceState({}, "", url);
              }
          </script>';
}
?>
<div class="page-header">
<div class="row align-items-center">
<?php
if (isset($_GET['success']) && $_GET['success'] == "ajouter") {
    echo '<div class="alert alert-success" role="alert">
              module a été Ajouter success
          </div>';

    echo '<script>
              if (typeof window.history.replaceState === "function") {
                  window.history.replaceState({}, "", "module.php");
              }
          </script>';
}
?>
<div class="col">
<h3 class="page-title">Modules</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Modules</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card card-table">
<div class="card-body">

<div class="page-header">
<div class="row align-items-center">

<div class="col">
<h3 class="page-title">Modules</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i>Download</a>
<a href="add-mudole.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
</div>
</div>
</div>

<div class="table-responsive">
<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
<thead class="student-thread">
<tr>
<th hidden>ID</th>
<th>Nom de module</th>
<th>Heure</th>
<th>Nom de matiere</th>
</tr>
</thead>
<tbody>
<?php foreach ($filieres as $filiere) : ?>
<tr>

<td hidden><?php echo $filiere['id']; ?></td>
<td>
<h2>
<a><?php echo $filiere['nom_mudole']; ?></a>
</h2>
</td>
<td><?php echo $filiere['heure']; ?></td>
<td><?php echo $filiere['nom_module']; ?></td>


</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>

<footer>
<p>Copyright © 2023 ZAKARIAE.</p>
</footer>

</div>

</div>


<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/datatables/datatables.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>