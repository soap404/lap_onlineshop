<?php

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{

    private PHPMailer $mail;

    public function __construct()
    {
        require_once "../vendor/autoload.php";

        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $this->mail->Username = 'alarjawia@gmail.com';                     //SMTP username
        $this->mail->Password = '';                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->mail->setFrom('alarjawia@gmail.com', 'ABDUL Onlineshop');
        $this->mail->isHTML();
    }

    public function pendingOrders($user, $order_products, $order): void
    {
        $orderId = $order['id'];
        $subject = "Wir haben Ihre Bestellung erhalten | #$orderId ";

        $email = $user['email'];

        $this->mail->Subject = $subject;
        $this->mail->addAddress($email);

        $mail_user = $user;
        $mail_order_products = $order_products;
        $mail_order = $order;

        ob_start();

        require "Templates/orderPendingEmailTemplate.php";

        $mail_body = ob_get_clean();

        $this->mail->Body = $mail_body;

        $this->mail->send();

    }

    public function doneOrder($user, $order_products, $order): void
    {
        $orderId = $order['id'];
        $subject = "Ihre Bestellung ist unterwegs | #$orderId ";

        $email = $user['email'];

        $this->mail->Subject = $subject;
        $this->mail->addAddress($email);

        $mail_user = $user;
        $mail_order_products = $order_products;
        $mail_order = $order;

        ob_start();

        require "Templates/orderDoneEmailTemplate.php";

        $mail_body = ob_get_clean();

        $this->mail->Body = $mail_body;


        $invoice_pdf = '../pdf/PDFs/Rechnungen/'.$order['invoice_pdf'].'.pdf';
        $this->mail->addAttachment($invoice_pdf);

        $this->mail->send();
    }

    public function cancelOrder($user, $order_products, $order): void
    {
        $orderId = $order['id'];
        $subject = "Ihre Bestellung ist stoniert | #$orderId ";

        $email = $user['email'];

        $this->mail->Subject = $subject;
        $this->mail->addAddress($email);

        $mail_user = $user;
        $mail_order_products = $order_products;
        $mail_order = $order;

        ob_start();

        require "Templates/orderCancelEmailTemplate.php";

        $mail_body = ob_get_clean();

        $this->mail->Body = $mail_body;


        $this->mail->send();

    }

    public function sendToken($email, $token): void
    {

        $subject = 'Bitte bestätigen Sie Ihre E-Mail-Adresse für Abdul Onlineshop';

        $this->mail->Subject = $subject;
        $this->mail->addAddress($email);

        $mail_token = $token;

        ob_start();

        require "Templates/tokenEmailTemplate.php";

        $mail_body = ob_get_clean();

        $this->mail->Body = $mail_body;

        $this->mail->send();

    }


}