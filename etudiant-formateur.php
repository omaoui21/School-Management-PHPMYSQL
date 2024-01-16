<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'formateur') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';

$username=$_SESSION['username'];

    $sql = "SELECT DISTINCT etudiant.id,etudiant.nom ,etudiant.prenom ,etudiant.image,
    etudiant.email,etudiant.telephone,etudiant.date_de_naissance,etudiant.adresse,nom_filiere
    FROM etudiant 
    INNER JOIN filiere ON filiere.id = etudiant.filiere_id
    INNER JOIN filiere_formateur ON filiere_formateur.filiere_id = etudiant.filiere_id
    INNER JOIN formateur ON formateur.id = filiere_formateur.formateur_id
    INNER JOIN _user ON _user.id = formateur.user_id
    WHERE _user.username ='$username'
    GROUP BY etudiant.id";
$result = $conn->query($sql);

// Fetch all formateurs
$etudiants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
        
    }
   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Etudiants</title>

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
<h3 class="page-title">Etudiants</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur-dashboard.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Etudiants</li>
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
<h3 class="page-title">Etudiants</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
</div>
</div>
</div>

<div class="table-responsive">
<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
<thead class="student-thread">
<tr>
<th>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</th>
<th>ID</th>
<th>Nom</th>
<th>Prénom</th>
<th>Email</th>
<th>Date de Naissance</th>
<th>Telephone</th>
<th>Address</th>
<th>Filiere</th>
</tr>
</thead>
<tbody>
<?php foreach ($etudiants as $etudiant) : ?>
<tr>
<td>
 <div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td><?php echo $etudiant['id']; ?></td>
<td>
<h2 class="table-avatar">
<a href="formateur-details.php" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="<?php echo$etudiant['image']; ?>" alt="Formateur Image" width="200"alt="User Image">
<a href="formateur-details.php"><?php echo $etudiant['nom']; ?></a>
</h2>
</td>
<td><?php echo $etudiant['prenom']; ?></td>
<td><?php echo $etudiant['email']; ?></td>
<td><?php echo $etudiant['date_de_naissance']; ?></td>
<td><?php echo $etudiant['telephone']; ?></td>
<td><?php echo $etudiant['adresse']; ?></td>
<td><?php echo $etudiant['nom_filiere']; ?></td>

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