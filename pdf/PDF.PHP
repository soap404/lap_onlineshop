<?php
require_once('../autoload.php');
require_once('../vendor/autoload.php');
require_once('../models/UserModel.php');
require_once('../models/OrderModel.php');

use Dompdf\Dompdf;

class PDF
{

    private Dompdf $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }



    public function order($order_id): void
    {

        $userModel = new UserModel();
        $orderModel = new OrderModel();

        $user_id = $_SESSION['user']['id'];

        $user = $userModel->get_user_by_id($user_id);

        $order = $orderModel->get_order_by_id($order_id);

        $order_products = $orderModel->get_order_products($order_id);

        $get_invoice_address = $orderModel->get_invoice_address($order_id);

        ob_start();

        include('templates/orderRechnug.php');

        $html = ob_get_clean();


        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4');
        $this->dompdf->render();

        $output = $this->dompdf->output();
        file_put_contents(__DIR__ . '/PDFs/Rechnugen/' . $order['invoice_pdf'], $output);
    }
}
