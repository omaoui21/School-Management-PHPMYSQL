<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'db/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $n_convention = $_POST['convention'];
    $date_convention = $_POST['date_convention'];
    $Annee_convention = $_POST['Annee_convention'];
    $signature = $_POST['signature'];
    $objet = $_POST['objet'];
    $montant_subvention = $_POST['montant_subvention'];
    $source_financement = $_POST['source_financement'];
    $date_demarrage = $_POST['date_demarrage'];
    $date_achevement = $_POST['date_achevement'];
    $delai_execution = $_POST['delai_execution'];
    $effectif_apprentis = $_POST['effectif_apprentis'];
    $province_localite = $_POST['province_localite'];
    $modalite_deblocage_subvention = $_POST['modalite_deblocage_subvention'];
    
    // Retrieve the id_centre from the centre table based on username=admin
    $username = $_SESSION['username']; // Replace with the appropriate username value
    $query = "SELECT centre.id AS id_centre
        FROM _admin
        INNER JOIN _user ON _user.id = _admin.user_id
        INNER JOIN centre ON centre.id = _admin.centre_id
        WHERE _user.username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $id_centre = $row['id_centre'];

    // Prepare the SQL statement
    $sql = "INSERT INTO convention (n_convention,date_convention, annee_convention, signature, objet, montant_subvention, source_financement, date_demarrage, date_achevement, delai_execution, effectif_apprentis, province_localite, modalite_deblocage_subvention, centre_id)
            VALUES ('$n_convention','$date_convention', '$Annee_convention', '$signature', '$objet', '$montant_subvention', '$source_financement', '$date_demarrage', '$date_achevement', '$delai_execution', '$effectif_apprentis', '$province_localite', '$modalite_deblocage_subvention', '$id_centre')";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
        // Insertion successful
        header('Location:convention.php?success=ajouter');
    } else {
        // Error message
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);

       
       
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Convention</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'navbar/navbar.php' ?>


<div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row align-items-center">
<div class="col">
<h3 class="page-title">Ajouter Convention</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="convention.php">Convention</a></li>
<li class="breadcrumb-item active">Ajouter Convention</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-body">
<form method="POST" action="add-convention.php" enctype="multipart/form-data">
<div class="row">
<div class="col-12">
<h5 class="form-title"><span>Creation Convention</span></h5>
</div>
<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>N°Convention <span class="login-danger">*</span></label>
    <input type="text" class="form-control" placeholder="Entrez N°Convention" name="convention" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Date de Convention <span class="login-danger">*</span></label>
    <input type="date" class="form-control" name="date_convention" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Année de Convention <span class="login-danger">*</span></label>
    <input type="number" class="form-control" placeholder="Entrez l'année de Convention" name="annee_convention" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Signature <span class="login-danger">*</span></label>
    <input type="text" class="form-control" placeholder="Entrez la signature" name="signature" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Objet <span class="login-danger">*</span></label>
    <input type="text" class="form-control" placeholder="Entrez l'objet" name="objet" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Montant de Subvention <span class="login-danger">*</span></label>
    <input type="number" step="0.01" class="form-control" placeholder="Entrez le montant de subvention" name="montant_subvention" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Source de Financement <span class="login-danger">*</span></label>
    <input type="text" class="form-control" placeholder="Entrez la source de financement" name="source_financement" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Date de Démarrage <span class="login-danger">*</span></label>
    <input type="date" class="form-control" name="date_demarrage" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Date d'Achèvement <span class="login-danger">*</span></label>
    <input type="date" class="form-control" name="date_achevement" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Délai d'Exécution <span class="login-danger">*</span></label>
    <input type="number" class="form-control" placeholder="Entrez le délai d'exécution" name="delai_execution" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Effectif d'Apprentis <span class="login-danger">*</span></label>
    <input type="number" class="form-control" placeholder="Entrez l'effectif d'apprentis" name="effectif_apprentis" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Province/Localité <span class="login-danger">*</span></label>
    <input type="text" class="form-control" placeholder="Entrez la province/localité" name="province_localite" required>
  </div>
</div>

<div class="col-12 col-sm-6">
  <div class="form-group local-forms">
    <label>Modalité de Déblocage de Subvention <span class="login-danger">*</span></label>
    <input type="number" step="0.01" class="form-control" placeholder="Entrez la modalité de déblocage de subvention" name="modalite_deblocage_subvention" required>
  </div>
</div>





<div class="col-12">
<div class="student-submit">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
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

<script src="assets/plugins/select2/js/select2.min.js"></script>

<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>