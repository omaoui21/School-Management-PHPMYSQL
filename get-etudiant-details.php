<?php
// Include necessary files and establish database connection
// Replace the placeholders with your actual code for including files and establishing database connection
include 'db/db.php';

if (isset($_GET['id'])) {
   // Retrieve the etudiant ID from the request
   $etudiantId = $_GET['id'];

   // Fetch etudiant details from the database
   // Replace the placeholders with your actual code for fetching etudiant details from the database

   // Assuming you are using mysqli to fetch etudiant details
   $sql = "SELECT * FROM etudiant WHERE id = $etudiantId";
   $result = mysqli_query($conn, $sql);

   if ($result && mysqli_num_rows($result) > 0) {
      // Fetch the etudiant details
      $etudiant = mysqli_fetch_assoc($result);

      // Return the etudiant details as JSON response
      echo json_encode($etudiant);
   } else {
      // Return error response if etudiant not found
      echo json_encode(['error' => 'Failed to fetch etudiant details']);
   }
}
?>
