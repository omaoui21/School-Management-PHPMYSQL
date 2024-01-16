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
<title>ShemsyMassar - Étudiants par Centre</title>

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
<h3 class="page-title">Étudiants par Centre</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="pdg-dashboard.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Étudiants par Centre</li>
</ul>
</div>
</div>
</div>

<?php foreach ($centers as $center) : ?>
    <?php
    $centerId = $center['id'];
    $centerName = $center['nom'];

    // Fetch students for the current center
    $sqlStudents = "SELECT etudiant.*, filiere.nom_filiere AS filiere_nom
                    FROM etudiant
                    INNER JOIN filiere ON etudiant.filiere_id = filiere.id
                    WHERE filiere.centre_id = $centerId";
    $resultStudents = $conn->query($sqlStudents);
    $students = [];
    if ($resultStudents->num_rows > 0) {
        while ($rowStudent = $resultStudents->fetch_assoc()) {
            $students[] = $rowStudent;
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
                            <thead class="student-thread">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Date de Naissance</th>
                                    <th>Téléphone</th>
                                    <th>Adresse</th>
                                    <th>Filière</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student) : ?>
                                    <tr>
                                        <td><?php echo $student['nom']; ?></td>
                                        <td><?php echo $student['prenom']; ?></td>
                                        <td><?php echo $student['email']; ?></td>
                                        <td><?php echo $student['date_de_naissance']; ?></td>
                                        <td><?php echo $student['telephone']; ?></td>
                                        <td><?php echo $student['adresse']; ?></td>
                                        <td><?php echo $student['filiere_nom']; ?></td>
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

</div>
</div>

<footer>
<p>...</p>
</footer>

</div>

</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/plugins/datatables/datatables.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
