<?php
require_once('../autoload.php');
require_once('../vendor/autoload.php');
require_once('../models/UserModel.php');
require_once('../models/OrderModel.php');

use Dompdf\Dompdf;

class PDF
{

    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }



    public function order($order_id)
    {

        $userModel = new UserModel();
        $orderModel = new OrderModel();

        $user_id = $_SESSION['user']['id'];

        $user = $userModel->get_user_by_id($user_id);

        $order = $orderModel->show($order_id);

        $order_products = $orderModel->get_order_products($order_id);

        ob_start();
        include('/templates/orderRechnug.php');

        $html = ob_get_clean();


        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'landscape');
        $this->dompdf->render();
        
        $output = $this->dompdf->output();
        file_put_contents('PDFs/Rechnugen/' . $order_id . '.pdf', $output);


        
    }
}
