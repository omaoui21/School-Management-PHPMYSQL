<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['centre_sql_query'])) {
    $sql = $_SESSION['centre_sql_query'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}


include 'db/db.php';
$result = $conn->query($sql);

// Fetch all formateurs
$centres = [];
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        $centres[] = $row;
        
    }
   
}


// Check if centre data is available
if (count($centres) > 0) {
    // Generate PDF using TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Creator');
    $pdf->SetAuthor('Your Author');
    $pdf->SetTitle('Centre List');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Output the centre data in the PDF table
    $html = '<h1>Centre List</h1>';
    $html .= '<table border="1">';
    $html .= '<thead><tr><th><div class="form-check check-tables"><input class="form-check-input" type="checkbox" value="something"></div></th><th>ID</th><th>Nom</th><th>Adresse</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($centres as $centre) {
        $html .= '<tr>';
        $html .= '<td><div class="form-check check-tables"><input class="form-check-input" type="checkbox" value="something"></div></td>';
        $html .= '<td>' . $centre['id'] . '</td>';
        $html .= '<td><h2>' . $centre['nom'] . '</h2></td>';
        $html .= '<td>' . $centre['adresse'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the generated PDF to the browser
    $pdf->Output('centre_list.pdf', 'D');
}
else{
    header('Location:centre.php?warning=error');
}