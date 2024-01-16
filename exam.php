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

    // Retrieve the etudiant's filiere ID
    $sql = "SELECT filiere_id
            FROM etudiant
            WHERE id = $etudiantId";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $filiereId = $row['filiere_id'];

    // Retrieve all exams for the etudiant with the same filiere and module
    $sql = "SELECT exam.id, exam.exam_date, exam.exam_time, exam.exam_title, exam.exam_description, module.nom_module, formateur.nom as formateur_nom, filiere.nom_filiere
            FROM exam
            INNER JOIN module ON module.id = exam.module_id
            INNER JOIN formateur ON formateur.id = exam.formateur_id
            INNER JOIN filiere ON filiere.id = module.filiere_id
            AND filiere.id = $filiereId";

$result = mysqli_query($conn, $sql);
$_SESSION['exams_sql_query']=$sql;

// Fetch all formateurs
$exams = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exams[] = $row;
        
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
$sql = "SELECT exam.id, exam.exam_date, exam.exam_time, exam.exam_title, exam.exam_description, module.nom_module, formateur.nom as formateur_nom , filiere.nom_filiere
        FROM exam
        INNER JOIN module ON module.id = exam.module_id
        INNER JOIN formateur ON formateur.id = exam.formateur_id
        INNER JOIN filiere ON filiere.id = module.filiere_id
        WHERE exam.formateur_id = $formateurId";

$result = mysqli_query($conn, $sql);
$_SESSION['exams_sql_query']=$sql;

// Fetch all formateurs
$exams = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exams[] = $row;
        
    }
   
}
}

elseif ($_SESSION['role'] == 'admin') {
    // Check if user is not logged in or not an admin
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit;
    }
    include 'db/db.php';
    
    $username = $_SESSION['username'];
    $sql = "SELECT centre.id
            FROM centre
            INNER JOIN _admin ON _admin.centre_id = centre.id
            INNER JOIN _user ON _user.id = _admin.user_id
            WHERE _user.username = '$username'";
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $centreId = $row['id'];
    
    // Retrieve all absences of etudiants taught by the formateur
    $sql = "SELECT exam.id, exam.exam_date, exam.exam_time, exam.exam_title, exam.exam_description, formateur.nom as formateur_nom, module.nom_module, filiere.nom_filiere
    FROM exam
    INNER JOIN formateur ON formateur.id = exam.formateur_id
    INNER JOIN module ON module.id = exam.module_id
    INNER JOIN filiere ON filiere.id = module.filiere_id
    WHERE formateur.id IN (
        SELECT formateur_id
        FROM filiere_formateur
        WHERE filiere_id IN (
            SELECT id
            FROM filiere
            WHERE centre_id = $centreId
        )
    )";
    $_SESSION['exams_sql_query']=$sql;
    $result = mysqli_query($conn, $sql);
    
    // Fetch all formateurs
    $exams = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exams[] = $row;
            
        }
       
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Examens</title>

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
<h3 class="page-title">Examens</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur-dashboard.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Examens</li>
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
              No exam found
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
              exam a été Ajouter success
          </div>';

    echo '<script>
              if (typeof window.history.replaceState === "function") {
                  window.history.replaceState({}, "", "exam.php");
              }
          </script>';
}
?>
<div class="col">
<h3 class="page-title">Examen</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="exam-pdf.php" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
<?php  if ($_SESSION['role'] == 'formateur') {?><a href="add-exam.php" class="btn btn-primary"><i class="fas fa-plus"></i></a><?php }?>
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
<th>date de l'examen </th>
<th>heure de l'examen</th>
<th>nom de l'examen</th>
<th>Description de l'examen</th>
<th>nom de Matière</th>
<th>nom de Formateur</th>
<th>nom de Filiére</th>
</tr>
</thead>
<tbody>
<?php foreach ($exams as $exam) : ?>
<tr>
<td>
 <div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</td>
<td><?php echo $exam['exam_date']; ?></td>
<td><?php echo $exam['exam_time']; ?></td>
<td><?php echo $exam['exam_title']; ?></td>
<td><?php echo $exam['exam_description']; ?></td>
<td><?php echo $exam['nom_module']; ?></td>
<td><?php echo $exam['formateur_nom']; ?></td>
<td><?php echo $exam['nom_filiere']; ?></td>

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