<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['etudiant_sql_query'])) {
    $sql = $_SESSION['etudiant_sql_query'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}


include 'db/db.php';
$result = $conn->query($sql);

// Fetch all formateurs
$etudiants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
        
    }
   
}
if (count($etudiants) > 0) {
// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document properties
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Etudiant Report');
$pdf->SetHeaderData('', 0, '', '');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Display the SQL query in the PDF
$pdf->Cell(0, 10, 'Liste Etudiants', 0, 1);
$pdf->SetFont('courier', '', 10);
$pdf->Ln(10);

// Fetch formateurs data

// Your existing code to fetch the data goes here

$html = '<table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Nom et Prénom</th>
                    <th>Email</th>
                    <th>Date de Naissance</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Filière</th>
                </tr>
            </thead>
            <tbody>';

foreach ($etudiants as $etudiant) {
    $html .= '<tr>
                <td><h2 class="table-avatar"><a href="#" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="' . $etudiant['image'] . '" alt="etudiant Image" width="100" alt="User Image"></a><a href="#"></a></h2></td>
                <td>' . $etudiant['prenom'] .' '. $etudiant['nom'] . '</td>
                <td>' . $etudiant['email'] . '</td>
                <td>' . $etudiant['date_de_naissance'] . '</td>
                <td>' . $etudiant['telephone'] . '</td>
                <td>' . $etudiant['adresse'] . '</td>
                <td>' . $etudiant['nom_filiere'] . '</td>
            </tr>';
}

$html .= '</tbody>
          </table>';

// Output the HTML table to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF document
$pdf->Output('etudiant.pdf', 'I');
}
else{
    header('Location:etudiant.php?warning=error');
}