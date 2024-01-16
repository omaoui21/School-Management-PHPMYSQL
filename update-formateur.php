<?php
// Include necessary files and establish database connection
// Replace the placeholders with your actual code for including files and establishing database connection
include 'db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Retrieve form data
   $formateurId = $_POST['formateurId'];
   $nom = $_POST['editNom'];
   $prenom = $_POST['editPrenom'];
   $email = $_POST['editEmail'];
   $telephone = $_POST['editTelephone'];
   $dateNaissance = $_POST['editDateNaissance'];
   $cin = $_POST['editCIN'];
   $adresse = $_POST['editAdresse'];

   // Update formateur details in the database
   // Replace the placeholders with your actual code for updating formateur details in the database

   // Assuming you are using mysqli to update formateur details
   $sql = "UPDATE formateur SET nom = '$nom', prenom = '$prenom', email = '$email', telephone = '$telephone', date_de_naissance = '$dateNaissance', cin = '$cin', adresse = '$adresse' WHERE id = $formateurId";
   $result = mysqli_query($conn, $sql);

   if ($result) {
      // Get the updated formateur details from the database
      $updatedFormateurSql = "SELECT * FROM formateur WHERE id = $formateurId";
      $updatedFormateurResult = mysqli_query($conn, $updatedFormateurSql);
      $updatedFormateur = mysqli_fetch_assoc($updatedFormateurResult);

      // Return success response with updated formateur details
      echo json_encode(['success' => 'Formateur details updated successfully', 'updatedFormateur' => $updatedFormateur]);
   } else {
      // Return error response
      echo json_encode(['error' => 'Failed to update formateur details']);
   }
}
?>
