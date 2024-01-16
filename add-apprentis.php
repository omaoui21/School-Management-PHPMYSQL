<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'db/db.php';

$username = $_SESSION['username'];
$query = "SELECT convention.n_convention
          FROM convention
          INNER JOIN centre ON centre.id = convention.centre_id
          INNER JOIN _admin ON _admin.centre_id = centre.id
          INNER JOIN _user ON _user.id = _admin.user_id
          WHERE _user.username = '$username'";


$result = mysqli_query($conn, $query);

$n_conventions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $n_conventions[] = $row['n_convention'];
}

// Check if the form is submitted
if (isset($_POST['add'])) {
    // Retrieve the form data
    $nom_apprentis = $_POST['nom_apprentis'];
    $n_contract = $_POST['n_contract'];
    $adresse_apprentis = $_POST['adresse_apprentis'];
    $telephone = $_POST['telephone'];
    $situation = $_POST['situation'];
    $n_convention = $_POST['n_convention'];


        // Prepare the SQL statement
        $sql = "INSERT INTO liste_apprentis (nom_apprentis, n_contract, adresse_apprentis, telephone, situation, n_convention)
                VALUES ('$nom_apprentis', '$n_contract', '$adresse_apprentis', $telephone, '$situation', '$n_convention')";

if (mysqli_query($conn, $sql)) {
  // Insertion successful
  header('Location:add-apprentis.php?success=ajouter');
} else {
  // Error message
  echo "Error: " . mysqli_error($conn);
}
    // Close the database connection
    mysqli_close($conn);
}
// Close the database connection

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
                        <h3 class="page-title">Ajouter Apprentis</h3>
                        <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="execution-programme.php">Execution Programme</a></li>
                            <li class="breadcrumb-item active">Ajouter Apprentis</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="add-apprentis.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nom de l'apprentis</label>
                                            <input type="text" class="form-control" name="nom_apprentis" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Numéro de contrat</label>
                                            <input type="text" class="form-control" name="n_contract" required>
                                        </div>
                                    </div>
                                
                               
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Adresse de l'apprentis</label>
                                            <input type="text" class="form-control" name="adresse_apprentis" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Téléphone</label>
                                            <input type="text" class="form-control" name="telephone" required>
                                        </div>
                                    </div>
                            
                               
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Situation</label>
                                            <input type="text" class="form-control" name="situation" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="n_convention">N Convention</label>
                                    <select class="form-control" id="n_convention" name="n_convention" required>
                                        <?php foreach ($n_conventions as $n_convention) { ?>
                                            <option value="<?php echo $n_convention; ?>"><?php echo $n_convention; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                    </div>
                              
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" name="add">Ajouter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
<div class="row">
<div class="col-sm-12">
<div class="card card-table">
<div class="card-body">

<div class="page-header">
<div class="row align-items-center">
<?php if(isset($_GET['success']) && $_GET['success']=="ajouter") { ?>
<div class="alert alert-success" role="alert">
apprentis a été Ajouter success
</div>
<?php } ?>
<div class="col">
<h3 class="page-title">apprentis</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="#"  class="btn btn-outline-primary me-2" id="downloadLink" download="table_export.xlsx"><i class="fas fa-download"></i> Download Excel</a>
</div>
</div>
</div>
<div class="row">
            <div class="col-12 mb-3">
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Rechercher par N°Convention:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Entrez le N°Convention" name="search_convention">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" name="search">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
<div class="table-responsive">
    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="myTable">
        <thead class="student-thread">
            <tr>
                <th>ID</th>
                <th>Nom Apprenti</th>
                <th>Numéro de Contrat</th>
                <th>Adresse Apprenti</th>
                <th>Téléphone</th>
                <th>Situation</th>
                <th>Numéro de Convention</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch data from the liste_apprentis table in the database
            $username = $_SESSION['username'];
            if (isset($_POST['search_convention'])) {
            $searchConvention = $_POST['search_convention'];
            $query = "SELECT liste_apprentis.id, liste_apprentis.nom_apprentis, liste_apprentis.n_contract, liste_apprentis.adresse_apprentis, liste_apprentis.telephone, liste_apprentis.situation, convention.n_convention
            FROM liste_apprentis
            INNER JOIN convention ON convention.n_convention = liste_apprentis.n_convention
            INNER JOIN centre ON centre.id = convention.centre_id
            INNER JOIN _admin ON _admin.centre_id = centre.id
            INNER JOIN _user ON _user.id = _admin.user_id
            WHERE _user.username = '$username'
            and liste_apprentis.n_convention = '$searchConvention'";
            } else {
                $query = "SELECT liste_apprentis.id, liste_apprentis.nom_apprentis, liste_apprentis.n_contract, liste_apprentis.adresse_apprentis, liste_apprentis.telephone, liste_apprentis.situation, convention.n_convention
                FROM liste_apprentis
                INNER JOIN convention ON convention.n_convention = liste_apprentis.n_convention
                INNER JOIN centre ON centre.id = convention.centre_id
                INNER JOIN _admin ON _admin.centre_id = centre.id
                INNER JOIN _user ON _user.id = _admin.user_id
                WHERE _user.username = '$username'";
            }
  
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nom_apprentis']; ?></td>
                <td><?php echo $row['n_contract']; ?></td>
                <td><?php echo $row['adresse_apprentis']; ?></td>
                <td><?php echo $row['telephone']; ?></td>
                <td><?php echo $row['situation']; ?></td>
                <td><?php echo $row['n_convention']; ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
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

<script src="assets/plugins/datatables/datatables.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>
