<?php
session_start();

// Check if user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include 'db/db.php';

$username=$_SESSION['username'];
if (isset($_POST['search'])) {
  $search_filiere = $_POST['search_filiere'];
    $sql = "SELECT archive_etudiant.id,archive_etudiant.nom ,archive_etudiant.prenom ,archive_etudiant.image,
    archive_etudiant.email,archive_etudiant.telephone,archive_etudiant.date_de_naissance,archive_etudiant.adresse,nom_filiere
    FROM archive_etudiant 
    INNER JOIN filiere ON filiere.id = archive_etudiant.filiere_id
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username ='$username'
    and archive_etudiant.filiere_id ='$search_filiere'";
    } else {
      $sql = "SELECT archive_etudiant.id,archive_etudiant.nom ,archive_etudiant.prenom ,archive_etudiant.image,
    archive_etudiant.email,archive_etudiant.telephone,archive_etudiant.date_de_naissance,archive_etudiant.adresse,nom_filiere
    FROM archive_etudiant 
    INNER JOIN filiere ON filiere.id = archive_etudiant.filiere_id
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username ='$username'";
  }
  $_SESSION['archive_etudiant_sql_query'] = $sql;
$result = $conn->query($sql);

// Fetch all formateurs
$etudiants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
        
    }
   
}
if (!isset($_SESSION['language'])) {
   $_SESSION['language'] = 'en'; // Set default language
}

// Include the language file
$langFile = 'lang_' . $_SESSION['language'] . '.php';
include($langFile);

// Check if user is not logged in or not an admin

   ?>


<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Archive Etudiants</title>

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
<h3 class="page-title"><?php echo $lang['etudiant']; ?></h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php"><?php echo $lang['Tableau de bord']; ?></a></li>
<li class="breadcrumb-item active"><?php echo $lang['etudiant']; ?></li>
</ul>
</div>
</div>
</div>
<?php
if (isset($_GET['warning']) && $_GET['warning'] == "error") {
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          No etudiant found
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
<?php
if (isset($_GET['success']) && $_GET['success'] == "delete") {
   echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   Etudiant deleted from etudiant table and inserted into archive-etudiant table successfully
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';


    echo '<script>
              if (typeof window.history.replaceState === "function") {
                  var url = window.location.href;
                  url = url.replace("?success=delete", "");
                  window.history.replaceState({}, "", url);
              }
          </script>';
}
?>
<div class="page-header">
<div class="row align-items-center">
<?php
if (isset($_GET['success']) && $_GET['success'] == "ajouter") {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          etudiant a été Ajouter success
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      
    echo '<script>
              if (typeof window.history.replaceState === "function") {
                  window.history.replaceState({}, "", "etudiant.php");
              }
          </script>';
}
?>

<div class="col-auto text-end float-end ms-auto download-grp">

<a href="etudiant-pdf.php" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> <?php echo $lang['Telecharger']; ?></a>
<a href="add-etudiant.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
</div>
</div>
</div>

<?php 
 $sql ="SELECT filiere.nom_filiere,filiere.id
 FROM filiere
 INNER JOIN centre ON centre.id = filiere.centre_id
 INNER JOIN _admin ON _admin.centre_id = centre.id
 INNER JOIN _user ON _user.id = _admin.user_id
 WHERE _user.username ='$username'";
     $result = $conn->query($sql);

     $filieres = [];
     if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
             $filieres[] = $row;
             
         }
        
     }   
?>
<div class="row">
            <div class="col-12 mb-3">
                <form method="POST" action="">
                    <div class="form-group">
                        <div class="input-group">
                          <select class="form-control" name="search_filiere" required>
                          <option value="" selected disabled>sélectionnez Filière</option>
                            <?php foreach ($filieres as $filiere) : ?>
                                <option value="<?php echo $filiere['id']?>"><?php echo $filiere['nom_filiere']?></option>
                            <?php endforeach; ?>
                          </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" name="search"><?php echo $lang['Rechercher']; ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
<div class="table-responsive">
<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="yourTableId">
<thead class="student-thread">
<tr>
<th>ID</th>
<th>Nom</th>
<th>Prénom</th>
<th>Email</th>
<th>Date de Naissance</th>
<th>Telephone</th>
<th>Address</th>
<th>Filiere</th>
</tr>
</thead>
<tbody>
<?php foreach ($etudiants as $etudiant) : ?>
<tr data-etudiant-id="<?php echo $etudiant['id']; ?>">
<td><?php echo $etudiant['id']; ?></td>
<td>
<h2 class="table-avatar">
<a href="#" class="avatar avatar-sm me-2">
<img class="avatar-img rounded-circle etudiant-image" src="<?php echo $etudiant['image']; ?>" alt="Formateur Image" width="200" alt="User Image">

</a>
<a href="#" class="etudiant-nom"><?php echo $etudiant['nom']; ?></a>

</h2>
</td>
<td class="etudiant-prenom"><?php echo $etudiant['prenom']; ?></td>
<td class="etudiant-email"><?php echo $etudiant['email']; ?></td>
<td class="etudiant-date"><?php echo $etudiant['date_de_naissance']; ?></td>
<td class="etudiant-telephone"><?php echo $etudiant['telephone']; ?></td>
<td class="etudiant-adresse"><?php echo $etudiant['adresse']; ?></td>
<td class="etudiant-filiere"><?php echo $etudiant['nom_filiere']; ?></td>

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
<p>Copyright © 2023 ZAKARIAE.</p>
</footer>

</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>




<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/datatables/datatables.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>