<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'formateur') {
    header('Location: login.php');
    exit;
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
<h3 class="page-title">présences</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="formateur-dashboard.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">présences</li>
</ul>
</div>
</div>
</div>
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
<div class="row">
<div class="col-sm-12">
<div class="card card-table">
<div class="card-body">

<div class="page-header">
<div class="row align-items-center">

<div class="col">
<h3 class="page-title">présence</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="attendance-pdf.php" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
<a href="add-attendance.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
</div>
</div>
</div>
<div class="row">
    <div class="col-12 mb-3">
        <form method="POST" action="attendance.php">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Rechercher par Date:</label>
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_search" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Rechercher par Matière:</label>
                    <div class="input-group">
                        <select class="form-control" name="module_search" required>
                            <option value="" selected disabled>Sélectionner un Matière</option>
                            <?php
                                // Retrieve the modules associated with the formateur
                                $moduleQuery = "SELECT module.nom_module FROM module
                                                INNER JOIN module_formateur ON module.id = module_formateur.module_id
                                                INNER JOIN formateur ON formateur.id = module_formateur.formateur_id
                                                INNER JOIN _user ON _user.id = formateur.user_id
                                                WHERE _user.username = '$username'";
                                $moduleResult = mysqli_query($conn, $moduleQuery);
                                while ($moduleRow = mysqli_fetch_assoc($moduleResult)) {
                                    echo '<option value="' . $moduleRow['nom_module'] . '">' . $moduleRow['nom_module'] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" name="submit">Rechercher</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="table-responsive">
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
          <th>Status</th>
          <th class="text-end">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        
$username=$_SESSION['username'];

$sql = "SELECT formateur.id
        FROM formateur
        INNER JOIN _user ON _user.id = formateur.user_id
        WHERE _user.username = '$username'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$formateurId = $row['id'];

        // Perform the SQL query to fetch attendance data
     // Perform the SQL query to fetch attendance data with date and module filtering
if (isset($_POST['submit'])) {
  $dateSearch = $_POST['date_search'];
  $moduleSearch = $_POST['module_search'];

  // Perform the SQL query to fetch attendance data with date and module filtering
  $query = "SELECT attendance.*, etudiant.nom AS etudiant_nom, etudiant.prenom AS etudiant_prenom, module.nom_module 
            FROM attendance
            INNER JOIN etudiant ON etudiant.id = attendance.etudiant_id
            INNER JOIN filiere_formateur ON filiere_formateur.filiere_id = etudiant.filiere_id
            INNER JOIN module_formateur ON module_formateur.module_id = attendance.module_id AND module_formateur.formateur_id = $formateurId
            INNER JOIN module ON module.id = attendance.module_id
            WHERE filiere_formateur.formateur_id = $formateurId
            AND filiere_formateur.filiere_id IN (SELECT filiere_id FROM filiere_formateur WHERE formateur_id = $formateurId)";

  // Add the date and module filters to the query if they are provided
  if (!empty($dateSearch)) {
      $query .= " AND DATE(attendance.date) = '$dateSearch'";
  }

  if (!empty($moduleSearch)) {
      $query .= " AND module.nom_module LIKE '%$moduleSearch%'";
  }

  $_SESSION['attendance_sql_query'] = $query;
}
else {
            // Perform the SQL query to fetch attendance data
            $query = "SELECT attendance.*, etudiant.nom AS etudiant_nom, etudiant.prenom AS etudiant_prenom, module.nom_module 
                      FROM attendance
                      INNER JOIN etudiant ON etudiant.id = attendance.etudiant_id
                      INNER JOIN filiere_formateur ON filiere_formateur.filiere_id = etudiant.filiere_id
                      INNER JOIN module_formateur ON module_formateur.module_id = attendance.module_id AND module_formateur.formateur_id = $formateurId
                      INNER JOIN module ON module.id = attendance.module_id
                      WHERE filiere_formateur.formateur_id = $formateurId
                      AND filiere_formateur.filiere_id IN (SELECT filiere_id FROM filiere_formateur WHERE formateur_id = $formateurId)";
                      $_SESSION['attendance_sql_query']=$query;
        }
        $result = mysqli_query($conn, $query);
        
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) :
        ?>
            <tr>
              <td>
                <div class="form-check check-tables">
                  <input class="form-check-input" type="checkbox" value="something">
                </div>
              </td>
              <td><?php echo $row['etudiant_prenom'] . ' ' . $row['etudiant_nom']; ?></td>
              <td><?php echo $row['nom_module']; ?></td>
              <td><?php echo $row['date']; ?></td>
              <td><?php echo $row['status']; ?></td>
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
        <?php
          endwhile;
        } else {
          // No attendance data available
          echo '<tr><td colspan="6">No attendance data available.</td></tr>';
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