<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';
$username=$_SESSION['username'];

    $sql = "SELECT module.id,module.nom_module,filiere.nom_filiere
    FROM module
    INNER JOIN filiere ON filiere.id = module.filiere_id
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username ='$username'";

    $result = $conn->query($sql);
    $_SESSION['module_sql_query']=$sql;
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
<title>ShemsyMassar - Matieres</title>

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
<h3 class="page-title">Matieres</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Matieres</li>
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
<h3 class="page-title">Matieres</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="module-pdf.php" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i>Download</a>
<a href="add-matiere.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
</div>
</div>
</div>

<div class="table-responsive">
<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
<thead class="student-thread">
<tr>
<th>ID</th>
<th>Nom</th>
<th>Filière</th>
</tr>
</thead>
<tbody>
<?php foreach ($filieres as $filiere) : ?>
<tr>

<td><?php echo $filiere['id']; ?></td>
<td>
<h2>
<a><?php echo $filiere['nom_module']; ?></a>
</h2>
</td>
<td><?php echo $filiere['nom_filiere']; ?></td>

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