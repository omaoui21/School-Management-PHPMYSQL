<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pdg') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';

$username=$_SESSION['username'];

$sql = "SELECT _admin.*, centre.nom AS centre_nom
FROM _admin
LEFT JOIN centre ON _admin.centre_id = centre.id";
$result = $conn->query($sql);
$_SESSION['admin_sql_query']=$sql;
// Fetch all formateurs
$admins = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
        
    }
   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Formateurs</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

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

<div class="page-header">
<div class="row align-items-center">
<div class="col">
<h3 class="page-title">Admins</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="pdg-dashboard.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Admins</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card card-table">
<div class="card-body">
<?php if(isset($_GET['warning']) && $_GET['warning']=="error") { ?>
<div class="alert alert-warning" role="alert">
No admin found
</div>
<?php } ?>
<div class="page-header">
<div class="row align-items-center">
<?php if(isset($_GET['success']) && $_GET['success']=="ajouter") { ?>
<div class="alert alert-success" role="alert">
Admin a été Ajouter success
</div>
<?php } ?>
<div class="col">
<h3 class="page-title">Admin</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="admin-pdf.php"  class="btn btn-outline-primary me-2" ><i class="fas fa-download"></i> Download</a>
<a href="add-admin.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
</div>
</div>
</div>

<div class="table-responsive">
<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="myTable">
<thead class="student-thread">
<tr>

<th>Nom</th>
<th>Prénom</th>
<th>Email</th>
<th>Date de Naissance</th>
<th>Telephone</th>
<th>Address</th>
<th>Centre</th>
</tr>
</thead>
<tbody>
<?php foreach ($admins as $admin) : ?>
<tr>

</td>
<td>
<h2 class="table-avatar">
<a href="#" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="<?php echo$admin['image']; ?>" alt="admin Image" width="200"alt="User Image">
<a href="#"><?php echo $admin['nom']; ?></a>

</h2>
</td>
<td><?php echo $admin['prenom']; ?></td>
<td><?php echo $admin['email']; ?></td>
<td><?php echo $admin['date_de_naissance']; ?></td>
<td><?php echo $admin['telephone']; ?></td>
<td><?php echo $admin['adresse']; ?></td>
<td><?php echo $admin['centre_nom']; ?></td>
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
<p>Copyright © 2023 ZAKARIAE && ISSAM.</p>
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