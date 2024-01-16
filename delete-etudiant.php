<?php
// Include necessary files and establish database connection
include 'db/db.php';

if (isset($_GET['id'])) {
   $etudiantId = $_GET['id'];

   // Start a database transaction
   mysqli_begin_transaction($conn);

   try {
      // Retrieve etudiant details before deletion
      $selectEtudiantSql = "SELECT * FROM etudiant WHERE id = $etudiantId";
      $etudiantResult = mysqli_query($conn, $selectEtudiantSql);
      $etudiant = mysqli_fetch_assoc($etudiantResult);

      // Insert etudiant details into archive-etudiant table
      $insertArchiveSql = "INSERT INTO archive_etudiant (nom, prenom, email, telephone, date_de_naissance, cin, adresse, image, deploma, gender, name_parent, telephone_parent, session_year, user_id, filiere_id)
                          VALUES ('{$etudiant['nom']}', '{$etudiant['prenom']}', '{$etudiant['email']}', '{$etudiant['telephone']}', '{$etudiant['date_de_naissance']}', '{$etudiant['cin']}', '{$etudiant['adresse']}', '{$etudiant['image']}', '{$etudiant['deploma']}', '{$etudiant['gender']}', '{$etudiant['name_parent']}', '{$etudiant['telephone_parent']}', '{$etudiant['session_year']}', '{$etudiant['user_id']}', '{$etudiant['filiere_id']}')";
      mysqli_query($conn, $insertArchiveSql);

      // Delete records from absence table related to the etudiant
      $deleteAbsenceSql = "DELETE FROM absence WHERE etudiant_id = $etudiantId";
      mysqli_query($conn, $deleteAbsenceSql);

      // Delete records from note table related to the etudiant
      $deleteNoteSql = "DELETE FROM note WHERE etudiant_id = $etudiantId";
      mysqli_query($conn, $deleteNoteSql);

      // Finally, delete the etudiant from the etudiant table
      $deleteEtudiantSql = "DELETE FROM etudiant WHERE id = $etudiantId";
      mysqli_query($conn, $deleteEtudiantSql);

      // Commit the transaction if all queries executed successfully
      mysqli_commit($conn);
      header('Location:etudiant.php?success=delete');
   } catch (Exception $e) {
      // Rollback the transaction if any error occurred
      mysqli_rollback($conn);

      echo "Failed to delete etudiant from etudiant table";
   }
}
?>
