<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['filiere_sql_query'])) {
    $sql = $_SESSION['filiere_sql_query'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}


include 'db/db.php';
$result = $conn->query($sql);

// Fetch all formateurs
$filieres = [];
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        $filieres[] = $row;
        
    }
   
}

// Check if filieres data is available
if (count($filieres) > 0) {
    // Generate PDF using TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Creator');
    $pdf->SetAuthor('Your Author');
    $pdf->SetTitle('Filieres List');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Output the filieres data in the PDF table
    $html = '<h1>Filieres List</h1>';
    $html .= '<table border="1">';
    $html .= '<thead><tr><th>ID</th><th>Nom</th><th>Centre</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($filieres as $filiere) {
        $html .= '<tr>';
        $html .= '<td>' . $filiere['id'] . '</td>';
        $html .= '<td>' . $filiere['nom_filiere'] . '</td>';
        $html .= '<td>';
        $id = $filiere['centre_id'];
        $sq = "SELECT nom FROM centre WHERE id = '$id'";
        $result1 = $conn->query($sq);
        $row1 = $result1->fetch_assoc();
        $html .= $row1['nom'];
        $html .= '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the generated PDF to the browser
    $pdf->Output('filiere.pdf', 'D');
} 
else{
    header('Location:filiere.php?warning=error');
}