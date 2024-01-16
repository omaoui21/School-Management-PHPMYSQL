<?php
require_once 'vendor/autoload.php';

// Retrieve the SQL query from the session
session_start();
if (isset($_SESSION['admin_sql_query'])) {
    $sql = $_SESSION['admin_sql_query'];
} else {
    // Handle the case when the SQL query is not available
    // ...
}


include 'db/db.php';
$result = $conn->query($sql);

// Fetch all formateurs
$admins = [];
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
        
    }
   
}



// Check if admin data is available
if (count($admins) > 0) {
    // Generate PDF using TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Creator');
    $pdf->SetAuthor('Your Author');
    $pdf->SetTitle('Admin List');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    // Output the admin data in the PDF table
    $html = '<h1>Admin List</h1>';
    $html .= '<table border="1">';
    $html .= '<thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Date de Naissance</th><th>Telephone</th><th>Address</th><th>Centre</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($admins as $admin) {
        $html .= '<tr>';
        $html .= '<td><h2 class="table-avatar"><a href="#" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="' . $admin['image'] . '" alt="admin Image" width="200" alt="User Image"></a><a href="#"></a>' . $admin['nom'] . '</h2></td>';
        $html .= '<td>' . $admin['prenom'] . '</td>';
        $html .= '<td>' . $admin['email'] . '</td>';
        $html .= '<td>' . $admin['date_de_naissance'] . '</td>';
        $html .= '<td>' . $admin['telephone'] . '</td>';
        $html .= '<td>' . $admin['adresse'] . '</td>';
        $html .= '<td>' . $admin['centre_nom'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the generated PDF to the browser
    $pdf->Output('admin_list.pdf', 'D');
}
else{
    header('Location:admin.php?warning=error');
}