<?php
if (isset($_GET['file'])) {

    $file = basename($_GET['file']);
    $filePath = __DIR__ .DIRECTORY_SEPARATOR . 'pdf'. DIRECTORY_SEPARATOR . 'PDFs' . DIRECTORY_SEPARATOR . 'Rechnungen' . DIRECTORY_SEPARATOR . $file . '.pdf';

    if (file_exists($filePath)) {
        // Define headers
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($filePath));

        // Clear output buffer
        ob_clean();
        flush();

        // Read the file
        readfile($filePath);
    } else {
        header("location: admin_orders.php");
    }
} else {
    header("location: admin_orders.php");
}
exit();
