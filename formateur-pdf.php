<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['formateur_sql_query'])) {
    $sql = $_SESSION['formateur_sql_query'];
} else {
  echo "No SQL query available.";
}
include 'db/db.php';
// Fetch formateurs data
$result = $conn->query($sql);

// Fetch all formateurs
$formateurs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formateurs[] = $row;
        
    }
   
}
if (count($formateurs) > 0) {
// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document properties
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Formateurs Report');
$pdf->SetHeaderData('', 0, '', '');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Display the SQL query in the PDF
$pdf->Cell(0, 10, 'Liste formateurs', 0, 1);
$pdf->SetFont('courier', '', 10);
$pdf->Ln(10);


// Your existing code to fetch the data goes here

// Generate HTML table with data
$html = '<table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Date de naissance</th>
                <th>Adresse</th>
                <th>Filière</th>
            </tr>';

foreach ($formateurs as $formateur) {
    $html .= '<tr>
                <td>' . $formateur['id'] . '</td>
                <td><h2 class="table-avatar"><a href="#" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="' . $formateur['image'] . '" alt="etudiant Image" width="100" alt="User Image"></a><a href="#"></a>' . $formateur['nom_formateur'] . '</h2></td>
                <td>' . $formateur['prenom_formateur'] . '</td>
                <td>' . $formateur['email'] . '</td>
                <td>' . $formateur['telephone'] . '</td>
                <td>' . $formateur['date_de_naissance'] . '</td>
                <td>' . $formateur['adresse'] . '</td>
                <td>' . $formateur['nom_filiere'] . '</td>
            </tr>';
}

$html .= '</table>';

// Output the HTML table to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF document
$pdf->Output('formateurs.pdf', 'I');
}
else{
    header('Location:formateur.php?warning=error');
}