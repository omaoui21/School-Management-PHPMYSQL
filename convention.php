<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'db/db.php';
$username = $_SESSION['username'];

// Fetch all formateurs
$conventionData = [];

if (isset($_POST['search_convention'])) {
    $searchConvention = $_POST['search_convention'];
    $sql = "SELECT * FROM convention
    INNER JOIN centre ON centre.id = convention.centre_id
          INNER JOIN _admin ON _admin.centre_id = centre.id
          INNER JOIN _user ON _user.id = _admin.user_id
          WHERE _user.username = '$username'
        and n_convention = '$searchConvention' limit 1";
} else {
    $sql = "SELECT * FROM convention
    limit 0";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $conventionData[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nConvention = $_POST['n_convention'];
    $dateConvention = $_POST['date_convention'];
    $anneeConvention = $_POST['annee_convention'];
    $signature = $_POST['signature'];
    $objet = $_POST['objet'];
    $montantSubvention = $_POST['montant_subvention'];
    $sourceFinancement = $_POST['source_financement'];
    $dateDemarrage = $_POST['date_demarrage'];
    $dateAchevement = $_POST['date_achevement'];
    $delaiExecution = $_POST['delai_execution'];
    $effectifApprentis = $_POST['effectif_apprentis'];
    $provinceLocalite = $_POST['province_localite'];
    $modaliteDeblocageSubvention = $_POST['modalite_deblocage_subvention'];

    // Update convention data in the database
    $updateSql = "UPDATE convention SET
                    date_convention = '$dateConvention',
                    annee_convention = '$anneeConvention',
                    signature = '$signature',
                    objet = '$objet',
                    montant_subvention = '$montantSubvention',
                    source_financement = '$sourceFinancement',
                    date_demarrage = '$dateDemarrage',
                    date_achevement = '$dateAchevement',
                    delai_execution = '$delaiExecution',
                    effectif_apprentis = '$effectifApprentis',
                    province_localite = '$provinceLocalite',
                    modalite_deblocage_subvention = '$modaliteDeblocageSubvention'
                WHERE n_convention = '$nConvention'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Convention updated successfully";
        // Refresh the convention data
        $conventionData = [];
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $conventionData[] = $row;
            }
        }
    } else {
        echo "Error updating convention: " . $conn->error;
    }
}
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
                    <h3 class="page-title">Convention</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="add-convention.php">Ajouter Convention</a></li>
                        <li class="breadcrumb-item active">Convention</li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
if (isset($_GET['success']) && $_GET['success'] == "ajouter") {
    echo '<div class="alert alert-success" role="alert">
              convention a été Ajouter success
          </div>';

    echo '<script>
              if (typeof window.history.replaceState === "function") {
                  window.history.replaceState({}, "", "convention.php");
              }
          </script>';
}
?>
        <div class="row">
            <div class="col-12 mb-3">
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Rechercher par N°Convention:</label>
                        <div class="input-group">
                            <?php 
                                $sql = "SELECT * FROM convention
                                INNER JOIN centre ON centre.id = convention.centre_id
                                      INNER JOIN _admin ON _admin.centre_id = centre.id
                                      INNER JOIN _user ON _user.id = _admin.user_id
                                      WHERE _user.username = '$username'";
                                       $result = $conn->query($sql);

                                       $conventions = [];
                                       if ($result->num_rows > 0) {
                                           while ($row = $result->fetch_assoc()) {
                                               $conventions[] = $row;
                                               
                                           }
                                          
                                       }   
                            ?>
                            <select class="form-control" name="search_convention">
                                <option value="" selected disabled>N°Convention</option>
                                <?php foreach ($conventions as $convention) : ?>
                                    <option value="<?php echo $convention['n_convention']?>"><?php echo $convention['n_convention']?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" name="search">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <?php foreach ($conventionData as $row) : ?>
                <div class="col-12 col-sm-6">
                    <form method="POST" action="">
                        <div class="form-group local-forms">
                            <label>N°Convention <span class="login-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Entrez N°Convention" name="n_convention" value="<?php echo $row['n_convention']; ?>" required>
                        </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Date de Convention <span class="login-danger">*</span></label>
                        <input type="date" class="form-control" name="date_convention" value="<?php echo $row['date_convention']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Année de Convention <span class="login-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Entrez l'année de Convention" name="annee_convention" value="<?php echo $row['annee_convention']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Signature <span class="login-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Entrez la signature" name="signature" value="<?php echo $row['signature']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Objet <span class="login-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Entrez l'objet" name="objet" value="<?php echo $row['objet']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Montant de Subvention <span class="login-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" placeholder="Entrez le montant de subvention" name="montant_subvention" value="<?php echo $row['montant_subvention']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Source de Financement <span class="login-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Entrez la source de financement" name="source_financement" value="<?php echo $row['source_financement']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Date de Démarrage <span class="login-danger">*</span></label>
                        <input type="date" class="form-control" name="date_demarrage" value="<?php echo $row['date_demarrage']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Date d'Achèvement <span class="login-danger">*</span></label>
                        <input type="date" class="form-control" name="date_achevement" value="<?php echo $row['date_achevement']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Délai d'Exécution <span class="login-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Entrez le délai d'exécution" name="delai_execution" value="<?php echo $row['delai_execution']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Effectif d'Apprentis <span class="login-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Entrez l'effectif d'apprentis" name="effectif_apprentis" value="<?php echo $row['effectif_apprentis']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group local-forms">
                        <label>Province/Localité <span class="login-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Entrez la province/localité" name="province_localite" value="<?php echo $row['province_localite']; ?>" required>
                    </div>
                </div>

                <div class="col-12 col-sm-12">
                    <div class="form-group local-forms">
                        <label>Modalité de Déblocage de Subvention <span class="login-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Entrez la modalité de déblocage de subvention" name="modalite_deblocage_subvention" value="<?php echo $row['modalite_deblocage_subvention']; ?>" required>
                    </div>
                </div>

                <div class="col-6 my-3">
                <div class="student-submit">
                <button type="submit" class="btn btn-primary" name="update">Mettre à jour</button>
                </div>
                </div>
                <div class="col-6 my-3">
                <a href="export-pdf.php?id=<?php echo $row['n_convention']; ?>" class="btn btn-secondary">Export PDF</a>
                </div>
                
                </form>
                <?php endforeach; ?>
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
