<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['module_sql_query'])) {
    $sql = $_SESSION['module_sql_query'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}


include 'db/db.php';
$result = $conn->query($sql);
$modules = [];
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        $modules[] = $row;
        
    }
   
}
// Check if modules data is available
if (count($modules) > 0) {
    // Generate PDF using TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Creator');
    $pdf->SetAuthor('Your Author');
    $pdf->SetTitle('Modules List');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Output the modules data in the PDF table
    $html = '<h1>Modules List</h1>';
    $html .= '<table border="1">';
    $html .= '<thead><tr><th><div class="form-check check-tables"><input class="form-check-input" type="checkbox" value="something"></div></th><th>ID</th><th>Nom</th><th>Filière</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($modules as $module) {
        $html .= '<tr>';
        $html .= '<td><div class="form-check check-tables"><input class="form-check-input" type="checkbox" value="something"></div></td>';
        $html .= '<td>' . $module['id'] . '</td>';
        $html .= '<td><h2>' . $module['nom_module'] . '</h2></td>';
        $html .= '<td>' . $module['nom_filiere'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the generated PDF to the browser
    $pdf->Output('modules_list.pdf', 'D');
} 
else{
    header('Location:module.php?warning=error');
}