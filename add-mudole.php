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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data arrays
    $nomModules = $_POST['nomModule'];
    $heures = $_POST['heure'];
    $moduleIds = $_POST['moduleId'];

        // Loop through the arrays and insert each record into the module_to_module table
      
            $insertSql = "INSERT INTO module_to_module (nom_mudole, heure, module_id)
                          VALUES ('$nomModules', $heures, $moduleIds)";
 if (mysqli_query($conn, $insertSql))
    {
        header('Location: add-mudole.php?ajouter=success');
    } else {
        // Error message
        echo "Error: " . mysqli_error($conn);
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
<h3 class="page-title">Ajouter Modules</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur-dashboard.php">Dashboard</a></li>
<li class="breadcrumb-item active">Ajouter Modules</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-body">
        <form action="add-mudole.php" method="POST">

            <div class="col-12 col-sm-4">
<div class="form-group local-forms">
        <label for="nomModule">Nom Module:</label>
        <input type="text" name="nomModule" id="nomModule"  class="form-control" required>
        </div>
</div>
            <div class="col-12 col-sm-4">
<div class="form-group local-forms">
        <label for="heure">Heure:</label>
        <input type="number" name="heure" id="heure"  class="form-control" required>
        </div>
</div>
            <div class="col-12 col-sm-4">
<div class="form-group local-forms">
        <label for="moduleId">Select Matière:</label>
        <select name="moduleId" id="moduleId" class="form-control" required>
            <?php echo $moduleOptions; ?>
        </select>
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





<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/js/script.js"></script>

</body>
</html>
