<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['attendance_sql_query'])) {
    $sql = $_SESSION['attendance_sql_query'];
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

// Check if absence data is available
if (count($etudiants) > 0) {
    // Generate PDF using TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Creator');
    $pdf->SetAuthor('Your Author');
    $pdf->SetTitle('presence List');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Output the absence data in the PDF table
    $html = '<h1>Absence List</h1>';
    $html .= '<table border="1">';
    $html .= '<thead><tr><th>Etudiant</th><th>Matière</th><th>Status</th><th>Date</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($etudiants as $etudiant) {
        $html .= '<tr>';
        $html .= '<td>' . $etudiant['etudiant_prenom'] . ' ' . $etudiant['etudiant_nom'] . '</td>';
        $html .= '<td>' . $etudiant['nom_module'] . '</td>';
        $html .= '<td>' . $etudiant['status'] . '</td>';
        $html .= '<td>' . $etudiant['date'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the generated PDF to the browser
    $pdf->Output('attendance_list.pdf', 'D');
} 
else {
    header('Location: attendance.php?warning=error');
}
