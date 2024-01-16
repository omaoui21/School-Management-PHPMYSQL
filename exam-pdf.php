<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['exams_sql_query'])) {
    $sql = $_SESSION['exams_sql_query'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}


include 'db/db.php';
$result = $conn->query($sql);

// Fetch all formateurs
$exams = [];
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        $exams[] = $row;
        
    }
   
}


// Check if exams data is available
if (count($exams) > 0) {
    // Generate PDF using TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Creator');
    $pdf->SetAuthor('Your Author');
    $pdf->SetTitle('Exams List');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Output the exams data in the PDF table
    $html = '<h1>Exams List</h1>';
    $html .= '<table border="1">';
    $html .= '<thead><tr><th><div class="form-check check-tables"><input class="form-check-input" type="checkbox" value="something"></div></th><th>Date de l\'examen</th><th>Heure de l\'examen</th><th>Nom de l\'examen</th><th>Description de l\'examen</th><th>Nom de Module</th><th>Nom de Formateur</th><th>Nom de Filière</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($exams as $exam) {
        $html .= '<tr>';
        $html .= '<td><div class="form-check check-tables"><input class="form-check-input" type="checkbox" value="something"></div></td>';
        $html .= '<td>' . $exam['exam_date'] . '</td>';
        $html .= '<td>' . $exam['exam_time'] . '</td>';
        $html .= '<td>' . $exam['exam_title'] . '</td>';
        $html .= '<td>' . $exam['exam_description'] . '</td>';
        $html .= '<td>' . $exam['nom_module'] . '</td>';
        $html .= '<td>' . $exam['formateur_nom'] . '</td>';
        $html .= '<td>' . $exam['nom_filiere'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the generated PDF to the browser
    $pdf->Output('exams_list.pdf', 'D');
}
else{
    header('Location:exam.php?warning=error');
}