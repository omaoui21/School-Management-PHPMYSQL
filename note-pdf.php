<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['note_sql_query'])) {
    $sql = $_SESSION['note_sql_query'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}


include 'db/db.php';
$result = $conn->query($sql);

// Fetch all formateurs
$etudiants = [];
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
        
    }
   
}


// Check if note data is available
if (count($etudiants) > 0) {
    // Generate PDF using TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Creator');
    $pdf->SetAuthor('Your Author');
    $pdf->SetTitle('Notes List');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Output the note data in the PDF table
    $html = '<h1>Notes List</h1>';
    $html .= '<table border="1">';
    $html .= '<thead><tr><th><div class="form-check check-tables"><input class="form-check-input" type="checkbox" value="something"></div></th><th>Etudiant</th><th>Module</th><th>Note</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($etudiants as $etudiant) {
        $html .= '<tr>';
        $html .= '<td><div class="form-check check-tables"><input class="form-check-input" type="checkbox" value="something"></div></td>';
        $html .= '<td>' . $etudiant['etudiant_prenom'] . '</td>';
        $html .= '<td>' . $etudiant['nom_module'] . '</td>';
        $html .= '<td>' . $etudiant['valeur'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the generated PDF to the browser
    $pdf->Output('notes_list.pdf', 'D');
}
else{
    header('Location:note.php?warning=error');
}