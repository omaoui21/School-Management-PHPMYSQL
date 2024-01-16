<?php
// Include necessary files and establish database connection
// Replace the placeholders with your actual code for including files and establishing database connection
include 'db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Retrieve the form data
   $etudiantId = $_POST['etudiantId'];
   $nom = $_POST['editNom'];
   $prenom = $_POST['editPrenom'];
   $email = $_POST['editEmail'];
   $telephone = $_POST['editTelephone'];
   $dateNaissance = $_POST['editDateNaissance'];
   $cin = $_POST['editCIN'];
   $adresse = $_POST['editAdresse'];
   $deploma = $_POST['editDeploma'];
   $gender = $_POST['editGender'];
   $nameParent = $_POST['editParentName'];
   $telephoneParent = $_POST['editParentTelephone'];
   $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageDir = 'upload/';
    $imagePath = $imageDir . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $image = $imagePath;
    }

    
}
else {
   // No new image file was uploaded, keep the existing image
   $existingImageQuery = "SELECT image FROM etudiant WHERE id = $etudiantId";
   $existingImageResult = mysqli_query($conn, $existingImageQuery);

   if ($existingImageResult && mysqli_num_rows($existingImageResult) > 0) {
      $existingImageData = mysqli_fetch_assoc($existingImageResult);
      $image = $existingImageData['image'];
   }
}
   // Assuming you are using mysqli to update the etudiant details
   $sql = "UPDATE etudiant SET nom = '$nom', prenom = '$prenom', email = '$email', telephone = '$telephone', date_de_naissance = '$dateNaissance', cin = '$cin', adresse = '$adresse', image = '$image', deploma = '$deploma', gender = '$gender', name_parent = '$nameParent', telephone_parent = '$telephoneParent' WHERE id = $etudiantId";
   $result = mysqli_query($conn, $sql);



   if ($result) {
      // Get the updated etudiant details
      $updatedEtudiantQuery = "SELECT * FROM etudiant WHERE id = $etudiantId";
      $updatedEtudiantResult = mysqli_query($conn, $updatedEtudiantQuery);

      if ($updatedEtudiantResult && mysqli_num_rows($updatedEtudiantResult) > 0) {
         $updatedEtudiant = mysqli_fetch_assoc($updatedEtudiantResult);

         // Return success response with the updated etudiant details
         echo json_encode(['success' => 'Etudiant details updated successfully', 'updatedEtudiant' => $updatedEtudiant]);
      } else {
         // Return error response if failed to fetch updated etudiant details
         echo json_encode(['error' => 'Failed to fetch updated etudiant details']);
      }
   } else {
      // Return error response if failed to update etudiant details
      echo json_encode(['error' => 'Failed to update etudiant details']);
   }
}
?>
