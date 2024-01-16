<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pdg') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';

$username = $_SESSION['username'];

// Fetch centers
$sqlCenters = "SELECT * FROM centre";
$resultCenters = $conn->query($sqlCenters);
$centers = [];
if ($resultCenters->num_rows > 0) {
    while ($rowCenter = $resultCenters->fetch_assoc()) {
        $centers[] = $rowCenter;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Formateurs par Centre</title>

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
<h3 class="page-title">Formateurs par Centre</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="pdg-dashboard.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Formateurs par Centre</li>
</ul>
</div>
</div>
</div>

<?php foreach ($centers as $center) : ?>
    <?php
    $centerId = $center['id'];
    $centerName = $center['nom'];

    // Fetch trainers and their associated courses for the current center
    $sqlTrainers = "SELECT DISTINCT formateur.*, filiere.nom_filiere AS filiere_nom
                    FROM formateur
                    INNER JOIN filiere_formateur ON formateur.id = filiere_formateur.formateur_id
                    INNER JOIN filiere ON filiere_formateur.filiere_id = filiere.id
                    WHERE filiere.centre_id = $centerId";
    $resultTrainers = $conn->query($sqlTrainers);
    $trainers = [];
    if ($resultTrainers->num_rows > 0) {
        while ($rowTrainer = $resultTrainers->fetch_assoc()) {
            $trainers[] = $rowTrainer;
        }
    }
    ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="page-header">
                        <h3 class="page-title"><?php echo $centerName; ?></h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Cours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trainers as $trainer) : ?>
                                    <tr>
                                        <td><?php echo $trainer['nom']; ?></td>
                                        <td><?php echo $trainer['prenom']; ?></td>
                                        <td><?php echo $trainer['email']; ?></td>
                                        <td><?php echo $trainer['filiere_nom']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/datatables/datatables.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>
