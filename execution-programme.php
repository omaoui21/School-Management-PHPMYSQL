
<?php
session_start();


// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';

$username=$_SESSION['username'];

$sql = "SELECT COUNT(*) as count, gender FROM formateur GROUP BY gender";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

$chartData = array();
foreach ($data as $row) {
    $chartData[$row['gender']] = $row['count'];
}

$chartJSON = json_encode($chartData);

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Execution Programme </title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/feather/feather.css">

<link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="assets/css/style.css">
<style>
    #studentChart {
        max-width: 400px;
        margin: 0 auto;
    }
</style>
</head>
<body>
<?php include 'navbar/navbar.php' ?>


<div class="page-wrapper">
<div class="content container-fluid">

<div class="page-header">
<div class="row">
<div class="col">
<h3 class="page-title">Execution Programme</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php">Tableau de board</a></li>
<li class="breadcrumb-item active">Execution Programme</li>
</ul>
</div>
</div>
</div>

<div class="row">
 <div class="col-sm-12">
 <div class="card">
  <div class="card-body">
  <div class="col-12">
 <h5 class="form-title"><span>Execution Programme</span></h5>
 <div class="row">
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste des apprentis:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-apprentis.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
      
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste des entreprises:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-entreprise.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste Frais Formation:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-frais-formation.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
      
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste Frais Formation Suivi:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-frais-formation-suivi.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste Frais Vacation:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-frais-vacation.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
      
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste Acquisition materiel didactique:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-acquisituin-materiel-didactique.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste Acquisition materiel informatique:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-acquisituin-materiel-informatique.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
      
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste Acquisition materiel bureau:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-acquisituin-materiel-bureau.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste achat fournitures bureau:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-achat-fournitures-bureau.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
      
            <div class="col-6 mb-2">
                    <div class="form-group">
                        <label>Liste des apprentis:</label>
                        <div class="input-group">
                            <input disabled type="text" class="form-control" placeholder="Total global" name="search_convention">
                            <div class="input-group-append">
                            <a href="add-apprentis.php" class="btn btn-primary mx-2"> voir les détails</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

      

</div>
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