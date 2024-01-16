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
    $sql = "SELECT module.id, module.nom_module
    FROM module
    INNER JOIN module_formateur ON module_formateur.module_id = module.id
    WHERE module_formateur.formateur_id = $formateurId";

    $result = mysqli_query($conn, $sql);
    $moduleOptions = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $moduleId = $row['id'];
        $moduleName = $row['nom_module'];
        $moduleOptions .= '<option value="' . $moduleId . '">' . $moduleName . '</option>';
    }

    // Retrieve the etudiant data
    $sql = "SELECT id, nom, prenom FROM etudiant WHERE filiere_id IN (SELECT filiere_id FROM filiere_formateur WHERE formateur_id = $formateurId)";
    $result = mysqli_query($conn, $sql);
    $etudiantOptions = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $etudiantId = $row['id'];
        $etudiantNom = $row['nom'];
        $etudiantPrenom = $row['prenom'];
        $etudiantOptions .= '<option value="' . $etudiantId . '">' . $etudiantNom . ' ' . $etudiantPrenom . '</option>';
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $moduleID = $_POST['module_id'];
        $etudiantID = $_POST['etudiant_id'];
        $date = $_POST['date'];
        $reason = $_POST['reason'];

        // Insert the absence record into the database
        $sql = "INSERT INTO absence (date, reason, module_id, etudiant_id) VALUES ('$date', '$reason', $moduleID, $etudiantID)";

        if (mysqli_query($conn, $sql)) {
            header('Location:absence.php?success=ajouter');
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo "Invalid request.";
    }
    ?>
    


</body>
</html>
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

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'navbar/navbar.php' ?>


<div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row">
<div class="col">
<h3 class="page-title">Ajouter Absences</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur-dashboard.php">Dashboard</a></li>
<li class="breadcrumb-item active">Ajouter Absences</li>
</ul>
</div>
</div>
</div>


<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-body">
    <form method="POST" action="add-absence-etudiant.php">
    <div class="col-12 col-sm-4">
<div class="form-group local-forms">
        <label for="module_id">Select Matière:</label>
        <select name="module_id" id="module_id" class="form-control">
            <?php echo $moduleOptions; ?>
        </select>
        </div>
</div>

        <div class="col-12 col-sm-4">
<div class="form-group local-forms">

        <label for="etudiant_id">Select Etudiant:</label>
        <select name="etudiant_id" id="etudiant_id" class="form-control" required>
            <?php echo $etudiantOptions; ?>
        </select>
        </div>
</div>

        <div class="col-12 col-sm-4">
<div class="form-group local-forms">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date"  class="form-control" required>
        </div>
</div>

<div class="col-12 col-sm-4">
<div class="form-group local-forms">
        <label for="reason">Reason:</label>
        <input type="text" name="reason" id="reason" class="form-control" required>
        </div>
</div>

        <div class="col-12">
<div class="student-submit">
<button type="submit" class="btn btn-primary">Submit</button>
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