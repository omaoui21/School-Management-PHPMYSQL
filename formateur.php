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

    $sql = "SELECT formateur.id,formateur.nom as nom_formateur,formateur.prenom as prenom_formateur,formateur.image,
    formateur.email,formateur.telephone,formateur.date_de_naissance,formateur.adresse,nom_filiere
    FROM formateur 
    INNER JOIN filiere_formateur ON filiere_formateur.formateur_id = formateur.id
    INNER JOIN filiere ON filiere.id = filiere_formateur.filiere_id
    INNER JOIN centre ON centre.id = filiere.centre_id
    INNER JOIN _admin ON _admin.centre_id = centre.id
    INNER JOIN _user ON _user.id = _admin.user_id
    WHERE _user.username ='$username'
    and filiere_formateur.filiere_id ='$search_filiere'
    GROUP BY formateur.id";
    } else {
      $sql = "SELECT formateur.id,formateur.nom as nom_formateur,formateur.prenom as prenom_formateur,formateur.image,
      formateur.email,formateur.telephone,formateur.date_de_naissance,formateur.adresse,nom_filiere
      FROM formateur 
      INNER JOIN filiere_formateur ON filiere_formateur.formateur_id = formateur.id
      INNER JOIN filiere ON filiere.id = filiere_formateur.filiere_id
      INNER JOIN centre ON centre.id = filiere.centre_id
      INNER JOIN _admin ON _admin.centre_id = centre.id
      INNER JOIN _user ON _user.id = _admin.user_id
      WHERE _user.username ='$username'
      GROUP BY formateur.id";
  }
  $_SESSION['formateur_sql_query'] = $sql;
$result = $conn->query($sql);

// Fetch all formateurs
$formateurs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formateurs[] = $row;
        
    }
   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>ShemsyMassar - Formateurs</title>

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
<h3 class="page-title">Formateurs</h3>
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
<li class="breadcrumb-item active">Formateurs</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="card card-table">
<div class="card-body">
<?php
if (isset($_GET['warning']) && $_GET['warning'] == "error") {
    echo '<div class="alert alert-warning" role="alert">
              No formateur found
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
    echo '<div class="alert alert-danger" role="alert">
              formateur a été supprimé
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
    echo '<div class="alert alert-success" role="alert">
              Formateur a été Ajouter success
          </div>';

    echo '<script>
              if (typeof window.history.replaceState === "function") {
                  window.history.replaceState({}, "", "formateur.php");
              }
          </script>';
}
?>
<div class="col">
<h3 class="page-title">Formateur</h3>
</div>
<div class="col-auto text-end float-end ms-auto download-grp">
<a href="formateur-pdf.php" class="btn btn-outline-primary me-2" ><i class="fas fa-download"></i> Download</a>
<a href="add-formateur.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                        <label>Rechercher par Filiere:</label>
                        <div class="input-group">
                          <select class="form-control" name="search_filiere" required>
                          <option value="" selected disabled>sélectionnez Filière</option>
                            <?php foreach ($filieres as $filiere) : ?>
                                <option value="<?php echo $filiere['id']?>"><?php echo $filiere['nom_filiere']?></option>
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
<div class="table-responsive">
<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="yourTableId">
<thead class="student-thread">
<tr>
<th>
<div class="form-check check-tables">
<input class="form-check-input" type="checkbox" value="something">
</div>
</th>
<th>Nom</th>
<th>Prénom</th>
<th>Email</th>
<th>Date de Naissance</th>
<th>Telephone</th>
<th>Address</th>
<th>Filiere</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($formateurs as $formateur) : ?>
<tr data-formateur-id="<?php echo $formateur['id']; ?>">
   <td>
      <div class="form-check check-tables">
         <input class="form-check-input" type="checkbox" value="something">
      </div>
   </td>
   <td>
      <h2 class="table-avatar">
         <a href="formateur-details.php?id=<?php echo $formateur['id']; ?>" class="avatar avatar-sm me-2">
            <img class="avatar-img rounded-circle" src="<?php echo $formateur['image']; ?>" alt="Formateur Image" width="200" alt="User Image">
         </a>
         <a href="formateur-details.php?id=<?php echo $formateur['id']; ?>" class="formateur-nom">
            <?php echo $formateur['nom_formateur']; ?>
         </a>
      </h2>
   </td>
   <td class="formateur-prenom"><?php echo $formateur['prenom_formateur']; ?></td>
   <td class="formateur-email"><?php echo $formateur['email']; ?></td>
   <td class="formateur-date"><?php echo $formateur['date_de_naissance']; ?></td>
   <td class="formateur-telephone"><?php echo $formateur['telephone']; ?></td>
   <td class="formateur-adresse"><?php echo $formateur['adresse']; ?></td>
   <td><?php echo $formateur['nom_filiere']; ?></td>
   <td>
<a class="edit-btn" data-formateur-id="<?php echo $formateur['id']; ?>" data-bs-toggle="modal" data-bs-target="#editFormateurModal">
    <i class="fas fa-edit"></i> Modifier
</a>
<div class="modal fade" id="editFormateurModal" tabindex="-1" role="dialog" aria-labelledby="editFormateurModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="editFormateurModalLabel">Modifier le formateur</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <!-- Form to edit formateur details -->
            <form id="editFormateurForm">
               <!-- Form inputs for formateur details -->
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
                  <label for="editTelephone">Téléphone</label>
                  <input type="tel" class="form-control" id="editTelephone" name="editTelephone" required>
               </div>
               <div class="form-group">
                  <label for="editDateNaissance">Date de naissance</label>
                  <input type="date" class="form-control" id="editDateNaissance" name="editDateNaissance" required>
               </div>
               <div class="form-group">
                  <label for="editCIN">CIN</label>
                  <input type="text" class="form-control" id="editCIN" name="editCIN" required>
               </div>
               <div class="form-group">
                  <label for="editAdresse">Adresse</label>
                  <input type="text" class="form-control" id="editAdresse" name="editAdresse" required>
               </div>
               <!-- Add more form inputs for other formateur details -->

               <input type="hidden" id="formateurId" name="formateurId" value="">
               <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
         </div>
      </div>
   </div>
</div>

</td>
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

<script>
      $(document).ready(function() {
         // Handle click event of the edit button
         $('.edit-btn').click(function() {
            // Get the formateur ID from the data attribute
            var formateurId = $(this).data('formateur-id');

            // Send AJAX request to fetch formateur details
            $.ajax({
               url: 'get-formateur-details.php',
               type: 'GET',
               data: { id: formateurId },
               success: function(response) {
                  // Parse the response as JSON
                  var formateur = JSON.parse(response);

            $('#editNom').val(formateur.nom);
            $('#editPrenom').val(formateur.prenom);
            $('#editEmail').val(formateur.email);
            $('#editTelephone').val(formateur.telephone);
            $('#editDateNaissance').val(formateur.date_de_naissance);
            $('#editCIN').val(formateur.cin);
            $('#editAdresse').val(formateur.adresse);
            // Add code to populate other form inputs with respective formateur details
            if (formateur.image) {
               var imagePath =formateur.image;
               $('#imagePreview').attr('src', imagePath);
            } else {
               // Clear the image preview if there is no image
               $('#imagePreview').attr('src', '');
            }
            // Set the formateur ID in the hidden input field
            $('#formateurId').val(formateur.id);
               },
               error: function() {
                  // Handle error case
                  alert('Failed to fetch formateur details.');
               }
            });
         });
      });
      $(document).ready(function() {
   // Handle form submission
   $('#editFormateurForm').submit(function(e) {
      e.preventDefault(); // Prevent the default form submission

      // Get the form data
      var formData = $(this).serialize();

      // Send AJAX request to update formateur details
      $.ajax({
         url: 'update-formateur.php',
         type: 'POST',
         data: formData,
         dataType: 'json', // Specify the expected response data type
         success: function(response) {
            // Check if the update was successful
            if (response.hasOwnProperty('success')) {
               // Display success message
               alert(response.success);

               // Update the form inputs with the updated formateur details
               var updatedFormateur = response.updatedFormateur;
               var formateurId = updatedFormateur.id;

               // Find the table row with the corresponding formateur ID
               var tableRow = $('tr[data-formateur-id="' + formateurId + '"]');

               // Update the table cells with the new formateur details
               tableRow.find('.formateur-nom').text(updatedFormateur.nom);
               tableRow.find('.formateur-prenom').text(updatedFormateur.prenom);
               tableRow.find('.formateur-email').text(updatedFormateur.email);
               tableRow.find('.formateur-date').text(updatedFormateur.date_de_naissance);
               tableRow.find('.formateur-telephone').text(updatedFormateur.telephone);
               tableRow.find('.formateur-adresse').text(updatedFormateur.adresse);
            } else if (response.hasOwnProperty('error')) {
               // Display error message
               alert(response.error);
            }

            // Close the modal
            $('#editFormateurModal').modal('hide');
         },
         error: function() {
            // Handle error case
            alert('Failed to update formateur details.');
         }
      });
   });
});





   </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/plugins/datatables/datatables.min.js"></script>

<script src="assets/js/script.js"></script>
</body>
</html>