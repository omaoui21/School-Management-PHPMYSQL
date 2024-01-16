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
    $sql = "SELECT etudiant.id,etudiant.nom ,etudiant.prenom ,etudiant.image,
    etudiant.email,etudiant.telephone,etudiant.date_de_naissance,etudiant.adresse,nom_filiere
    FROM etudiant 
    INNER JOIN filiere ON filiere.id = etudiant.filiere_id
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username ='$username'
    and etudiant.filiere_id ='$search_filiere'";
    } else {
      $sql = "SELECT etudiant.id,etudiant.nom ,etudiant.prenom ,etudiant.image,
    etudiant.email,etudiant.telephone,etudiant.date_de_naissance,etudiant.adresse,nom_filiere
    FROM etudiant 
    INNER JOIN filiere ON filiere.id = etudiant.filiere_id
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username ='$username'";
  }
  $_SESSION['etudiant_sql_query'] = $sql;
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
<th class="text-end">Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($etudiants as $etudiant) : ?>
<tr data-etudiant-id="<?php echo $etudiant['id']; ?>">
<td><?php echo $etudiant['id']; ?></td>
<td>
<h2 class="table-avatar">
<a href="formateur-details.php" class="avatar avatar-sm me-2">
<img class="avatar-img rounded-circle etudiant-image" src="<?php echo $etudiant['image']; ?>" alt="Formateur Image" width="200" alt="User Image">

</a>
<a href="formateur-details.php" class="etudiant-nom"><?php echo $etudiant['nom']; ?></a>

</h2>
</td>
<td class="etudiant-prenom"><?php echo $etudiant['prenom']; ?></td>
<td class="etudiant-email"><?php echo $etudiant['email']; ?></td>
<td class="etudiant-date"><?php echo $etudiant['date_de_naissance']; ?></td>
<td class="etudiant-telephone"><?php echo $etudiant['telephone']; ?></td>
<td class="etudiant-adresse"><?php echo $etudiant['adresse']; ?></td>
<td class="etudiant-filiere"><?php echo $etudiant['nom_filiere']; ?></td>

<td class="text-end">
<div class="actions">

<a  class="btn btn-sm bg-success-light me-2 etudiant-details-link" data-etudiant-id="<?php echo $etudiant['id']; ?>"  data-bs-toggle="modal" data-bs-target="#editEtudiantModal">
            <i class="feather-eye"></i>
 </a>

<a class="btn btn-sm bg-danger-light me-2" href="delete-etudiant.php?id=<?php echo $etudiant['id']; ?>"><i class="feather-trash-2"></i></a>
<!-- Delete Confirmation Modal -->


</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="modal fade" id="editEtudiantModal" tabindex="-1" role="dialog" aria-labelledby="editEtudiantModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="editEtudiantModalLabel">Modifier l'étudiant</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <!-- Form to edit etudiant details -->
            <form id="editEtudiantForm">
               <!-- Form inputs for etudiant details -->
               <div class="image-preview">
               <img id="imagePreview" src="" alt="Image Preview" width="100">
            </div>
               <div class="form-group">
                  <label for="editNom">Nom</label>
                  <input type="text" class="form-control" id="editNom" name="editNom" required>
               </div>
               <div class="form-group">
                  <label for="editPrenom">Prénom</label>
                  <input type="text" class="form-control" id="editPrenom" name="editPrenom" required>
               </div>
               <div class="form-group">
                  <label for="editEmail">Email</label>
                  <input type="email" class="form-control" id="editEmail" name="editEmail" required>
               </div>
               <div class="form-group">
                  <label for="editCIN">CIN</label>
                  <input type="text" class="form-control" id="editCIN" name="editCIN" required>
               </div>
               <div class="form-group">
                  <label for="editTelephone">Téléphone</label>
                  <input type="tel" class="form-control" id="editTelephone" name="editTelephone" required>
               </div>
               <div class="form-group">
                  <label for="editDateNaissance">Date de Naissance</label>
                  <input type="date" class="form-control" id="editDateNaissance" name="editDateNaissance" required>
               </div>
               <div class="form-group">
                  <label for="editAdresse">Adresse</label>
                  <input type="text" class="form-control" id="editAdresse" name="editAdresse" required>
               </div>
                <div class="form-group">
                  <label for="editImage">Image</label>
                  <input type="file" class="form-control" id="editImage" name="image">
               </div>
               <div class="form-group">
                  <label for="editDeploma">Diplôme</label>
                  <input type="text" class="form-control" id="editDeploma" name="editDeploma">
               </div>
               <div class="form-group">
                  <label for="editGender">Genre</label>
                  <select class="form-control" id="editGender" name="editGender">
                     <option value="homme">homme</option>
                     <option value="femme">femme</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="editParentName">Nom du Parent</label>
                  <input type="text" class="form-control" id="editParentName" name="editParentName">
               </div>
               <div class="form-group">
                  <label for="editParentTelephone">Téléphone du Parent</label>
                  <input type="tel" class="form-control" id="editParentTelephone" name="editParentTelephone">
               </div>
           
               <input type="hidden" id="etudiantId" name="etudiantId">

               <!-- Submit button -->
               <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
$(document).ready(function() {
   // Handle form submission
   $('#editEtudiantForm').submit(function(e) {
      e.preventDefault(); // Prevent the default form submission

      // Get the form data
      var formData = new FormData(this);

      // Send AJAX request to update etudiant details
      $.ajax({
         url: 'update-etudiant.php',
         type: 'POST',
         data: formData,
         dataType: 'json', // Specify the expected response data type
         processData: false, // Prevent jQuery from processing the data
         contentType: false, // Prevent jQuery from setting the content type
         success: function(response) {
            // Check if the update was successful
            if (response.hasOwnProperty('success')) {
               // Display success message
               alert(response.success);

               var updatedEtudiant = response.updatedEtudiant;
               var etudiantId = updatedEtudiant.id;

               var tableRow = $('tr[data-etudiant-id="' + etudiantId + '"]');

               // Update the table cells with the new etudiant details
               tableRow.find('.etudiant-nom').text(updatedEtudiant.nom);
               tableRow.find('.etudiant-prenom').text(updatedEtudiant.prenom);
               tableRow.find('.etudiant-email').text(updatedEtudiant.email);
               tableRow.find('.etudiant-date').text(updatedEtudiant.date_de_naissance);
               tableRow.find('.etudiant-telephone').text(updatedEtudiant.telephone);
               tableRow.find('.etudiant-adresse').text(updatedEtudiant.adresse);
               tableRow.find('.etudiant-image').attr('src', updatedEtudiant.image);


               $('#editEtudiantModal').modal('hide');
            } else if (response.hasOwnProperty('error')) {
               // Display error message
               alert(response.error);
            }
         },
         error: function() {
            // Handle error case
            alert('Failed to update etudiant details.');
         }
      });
   });
});


$(document).ready(function() {
   // Handle click event on etudiant details link
   $('.etudiant-details-link').click(function(e) {
      e.preventDefault();

      // Get the etudiant ID from the link data attribute
      var etudiantId = $(this).data('etudiant-id');

      // Send AJAX request to get etudiant details
      $.ajax({
         url: 'get-etudiant-details.php',
         type: 'GET',
         data: { id: etudiantId },
         dataType: 'json', // Specify the expected response data type
         success: function(response) {
            // Check if the retrieval was successful
            if (response.hasOwnProperty('error')) {
               // Display error message
               alert(response.error);
            } else {
               // Update the form inputs with the retrieved etudiant details
               $('#etudiantId').val(response.id);
               $('#editNom').val(response.nom);
               $('#editPrenom').val(response.prenom);
               $('#editEmail').val(response.email);
               $('#editTelephone').val(response.telephone);
               $('#editDateNaissance').val(response.date_de_naissance);
               $('#editCIN').val(response.cin);
               $('#editAdresse').val(response.adresse);
               $('#editDeploma').val(response.deploma);
               $('#editGender').val(response.gender);
               $('#editParentName').val(response.name_parent);
               $('#editParentTelephone').val(response.telephone_parent);

               // Show the edit etudiant modal
               $('#editEtudiantModal').modal('show');

               if (response.image) {
               var imagePath =response.image;
               $('#imagePreview').attr('src', imagePath);
            } else {
               // Clear the image preview if there is no image
               $('#imagePreview').attr('src', '');
            }
            }
         },
         error: function() {
            // Handle error case
            alert('Failed to retrieve etudiant details.');
         }
      });
   });
});

</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/datatables/datatables.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>