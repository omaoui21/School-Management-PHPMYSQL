<?php
session_start();


if ($_SESSION['role'] == 'etudiant') {
    // Check if user is not logged in or not an etudiant
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'etudiant') {
        header('Location: login.php');
        exit;
    }

    include 'db/db.php';

    $username = $_SESSION['username'];

    // Retrieve the etudiant's ID
    $sql = "SELECT etudiant.id
            FROM etudiant
            INNER JOIN _user ON _user.id = etudiant.user_id
            WHERE _user.username = '$username'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $etudiantId = $row['id'];

    // Retrieve all absences for the etudiant
    $sql = "SELECT absence.id, absence.date, absence.reason, module.nom_module, etudiant.nom AS etudiant_nom, etudiant.prenom AS etudiant_prenom
    FROM absence
    INNER JOIN module ON module.id = absence.module_id
    INNER JOIN etudiant ON etudiant.id = absence.etudiant_id
    WHERE absence.etudiant_id = $etudiantId";

   
    $result = mysqli_query($conn, $sql);
    $_SESSION['absence_sql_query']=$sql;
    // Fetch all formateurs
    $etudiants = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $etudiants[] = $row;
            
        }
       
    }
}


if ($_SESSION['role'] == 'formateur') {
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

// Retrieve all absences of etudiants taught by the formateur
$sql = "SELECT DISTINCT absence.*, etudiant.nom AS etudiant_nom, etudiant.prenom AS etudiant_prenom, module.nom_module 
        FROM absence
        INNER JOIN etudiant ON etudiant.id = absence.etudiant_id
        INNER JOIN filiere_formateur ON filiere_formateur.filiere_id = etudiant.filiere_id
        INNER JOIN module_formateur ON module_formateur.module_id = absence.module_id AND module_formateur.formateur_id = $formateurId
        INNER JOIN module ON module.id = absence.module_id
        WHERE filiere_formateur.formateur_id = $formateurId
        AND filiere_formateur.filiere_id IN (SELECT filiere_id FROM filiere_formateur WHERE formateur_id = $formateurId)";

$result = mysqli_query($conn, $sql);
$_SESSION['absence_sql_query']=$sql;
// Fetch all formateurs
$etudiants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
        
    }
   
}
}elseif ($_SESSION['role'] == 'admin') {
    // Check if user is not logged in or not an admin
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit;
    }

    include 'db/db.php';
    $username = $_SESSION['username'];
    $sql = "SELECT centre.id
            FROM _admin
            INNER JOIN _user ON _user.id = _admin.user_id
            INNER JOIN centre ON centre.id = _admin.centre_id
            WHERE _user.username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $centerId = $row['id'];


    if (isset($_POST['submit'])) {
        $search = $_POST['search'];
        $sql = "SELECT absence.*, etudiant.nom AS etudiant_nom, etudiant.prenom AS etudiant_prenom, module.nom_module
                FROM absence
                INNER JOIN etudiant ON etudiant.id = absence.etudiant_id
                INNER JOIN module ON module.id = absence.module_id
                INNER JOIN filiere ON filiere.id = module.filiere_id
                WHERE filiere.centre_id = $centerId
                AND etudiant.nom = '$search'";
    } else {
        $sql = "SELECT absence.*, etudiant.nom AS etudiant_nom, etudiant.prenom AS etudiant_prenom, module.nom_module
                FROM absence
                INNER JOIN etudiant ON etudiant.id = absence.etudiant_id
                INNER JOIN module ON module.id = absence.module_id
                INNER JOIN filiere ON filiere.id = module.filiere_id
                WHERE filiere.centre_id = $centerId";
    }
    
    $result = mysqli_query($conn, $sql);
    $_SESSION['absence_sql_query'] = $sql;
    
    $etudiants = [];
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $etudiants[] = $row;
        }
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
<h3 class="page-title">Absences</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur-dashboard.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Absences</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card card-table">
<div class="card-body">
<?php
if (isset($_GET['warning']) && $_GET['warning'] == "error") {
    echo '<div class="alert alert-warning" role="alert">
              No absence found
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
              absence a été Ajouter success
          </div>';

    echo '<script>
              if (typeof window.history.replaceState === "function") {
                  window.history.replaceState({}, "", "absence.php");
              }
          </script>';
}
?>
<div class="col">
<h3 class="page-title">Absence</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="absence-pdf.php" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
<a href="add-absence-etudiant.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
</div>
</div>
</div>
<?php if ($_SESSION['role'] == 'formateur' || $_SESSION['role'] == 'admin') { ?>
<div class="row">
            <div class="col-12 mb-3">
                <form method="POST" action="absence.php">
                    <div class="form-group">
                        <label>Rechercher par Nom:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Entrez le Nom etudiant" name="search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" name="submit">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php }?>
<div class="table-responsive">
<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
<thead class="student-thread">
<tr>
<th>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</th>
<th>Etudiant</th>
<th>Matière</th>
<th>Date</th>
<th>Reason</th>
<th class="text-end">Action</th>
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
<td><?php echo $etudiant['etudiant_prenom']; ?> <?php echo $etudiant['etudiant_nom']; ?></td>
<td><?php echo $etudiant['nom_module']; ?></td>
<td><?php echo $etudiant['date']; ?></td>
<td><?php echo $etudiant['reason']; ?></td>

<td class="text-end">
<div class="actions">
<a href="javascript:;" class="btn btn-sm bg-success-light me-2">
<i class="feather-eye"></i>
</a>
<a href="edit-etudiant.php" class="btn btn-sm bg-danger-light">
<i class="feather-edit"></i>
</a>
</div>
</td>
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