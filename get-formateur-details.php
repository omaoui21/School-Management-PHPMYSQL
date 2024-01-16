<?php
// Include necessary files and establish database connection
// Replace the placeholders with your actual code for including files and establishing database connection
include 'db/db.php';

if (isset($_GET['id'])) {
   $formateurId = $_GET['id'];

   // Retrieve formateur details from the database based on the formateur ID
   // Replace the placeholders with your actual code for fetching formateur details from the database

   // Assuming you are using mysqli to fetch formateur details
   $sql = "SELECT * FROM formateur WHERE id = $formateurId";
   $result = mysqli_query($conn, $sql);

   if ($result) {
      $formateur = mysqli_fetch_assoc($result);

      // Return the formateur details as JSON response
      echo json_encode($formateur);
   } else {
      // Handle the error case when formateur details are not found
      echo json_encode(['error' => 'Formateur not found']);
   }
}
?>
