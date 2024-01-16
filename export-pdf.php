<?php
require_once 'vendor/autoload.php';

// Check if the convention ID is present in the URL
if (isset($_GET['id'])) {
    // Retrieve the convention ID from the query parameter
    $conventionId = $_GET['id'];

    include 'db/db.php';
    // Fetch convention data from the database using the convention ID
       // Fetch convention data from the database using the convention ID
       $sql = "SELECT n_convention, date_convention, annee_convention, signature, objet, montant_subvention, source_financement, date_demarrage, date_achevement, delai_execution, effectif_apprentis, province_localite, modalite_deblocage_subvention FROM convention WHERE n_convention = '$conventionId'";
       $result = $conn->query($sql);
   
       // Check if data was retrieved successfully
       if ($result->num_rows > 0) {
        // Assuming the query returns a single row
        $row = $result->fetch_assoc();
        $nConvention = $row['n_convention'];
        $dateConvention = $row['date_convention'];
        $anneeConvention = $row['annee_convention'];
        $signature = $row['signature'];
        $objet = $row['objet'];
        $montantSubvention = $row['montant_subvention'];
        $sourceFinancement = $row['source_financement'];
        $dateDemarrage = $row['date_demarrage'];
        $dateAchevement = $row['date_achevement'];
        $delaiExecution = $row['delai_execution'];
        $effectifApprentis = $row['effectif_apprentis'];
        $provinceLocalite = $row['province_localite'];
        $modaliteDeblocageSubvention = $row['modalite_deblocage_subvention'];

 
        // Generate PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Convention PDF');

        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Remove auto-page-break so we can manually control it
        $pdf->SetAutoPageBreak(false, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Add a page
        $pdf->AddPage();

        // Set the logo image
        $logo = 'assets/img/logo-small.png';

        // Desired dimensions for the logo
        $desiredLogoWidth = 30;
        $desiredLogoHeight = 30;

        // Get the width and height of the logo image
        list($logoWidth, $logoHeight) = getimagesize($logo);

        // Calculate the position to place the logo at the top of the page
        $logoX = $pdf->GetPageWidth() - $pdf->getMargins()['right'] - $desiredLogoWidth;
        $logoY = $pdf->getMargins()['top'] - 10;

        // Place the logo on the page with the desired size and position
        $pdf->Image($logo, $logoX, $logoY, $desiredLogoWidth, $desiredLogoHeight);

        // Set font
        $pdf->SetFont('helvetica', 'B', 16);

        // Print the convention data
        $pdf->Cell(0, 10, 'Convention AMESIP:', 0, 1, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'N°Convention:', 0, 0, 'R');
        $pdf->Cell(0, 10, $nConvention, 0, 1);
        $pdf->Cell(0, 10, 'Date de Convention: ' . $dateConvention, 0, 1);
        $pdf->Cell(0, 10, 'Année de Convention: ' . $anneeConvention, 0, 1);
        $pdf->Cell(0, 10, 'Signature: ' . $signature, 0, 1);
        $pdf->Cell(0, 10, 'Objet: ' . $objet, 0, 1);
        $pdf->Cell(0, 10, 'Montant de Subvention: ' . $montantSubvention, 0, 1);
        $pdf->Cell(0, 10, 'Source de Financement: ' . $sourceFinancement, 0, 1);
        $pdf->Cell(0, 10, 'Date de Démarrage: ' . $dateDemarrage, 0, 1);
        $pdf->Cell(0, 10, 'Date d\'Achèvement: ' . $dateAchevement, 0, 1);
        $pdf->Cell(0, 10, 'Délai d\'Exécution: ' . $delaiExecution, 0, 1);
        $pdf->Cell(0, 10, 'Effectif d\'Apprentis: ' . $effectifApprentis, 0, 1);
        $pdf->Cell(0, 10, 'Province/Localité: ' . $provinceLocalite, 0, 1);
        $pdf->Cell(0, 10, 'Modalité de Déblocage de Subvention: ' . $modaliteDeblocageSubvention, 0, 1);

        // Output the PDF
        $pdf->Output('convention.pdf', 'D');
    } else {
        echo 'No convention data found.';
    }

    // Close the database connection
    $conn->close();
} else {
    echo 'Convention ID not provided in the URL.';
}
?>