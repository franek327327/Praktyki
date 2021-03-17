<?php
session_start();
if(isset($_POST['zdj']))
{
    file_put_contents("planlekcji.jpg", base64_decode(explode(",", $_POST['zdj'])[1]));
    require("PHPMailer/src/PHPMailer.php");
    require("PHPMailer/src/SMTP.php");
    require("PHPMailer/src/Exception.php");

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet="UTF-8";
    $mail->Host = "smtp.gmail.com"; /* Zależne od hostingu poczty*/
    $mail->SMTPDebug = 0;
    $mail->Port = 465; /* Zależne od hostingu poczty, czasem 587 */
    $mail->SMTPSecure = 'ssl'; /* Jeżeli ma być aktywne szyfrowanie SSL */
    $mail->SMTPAuth = true;
    $mail->Username = "planlekcji06"; /* login do skrzynki email często adres*/
    $mail->Password = "planlekcji123"; /* Hasło do poczty */
    $mail->setFrom('planlekcji06@gmail.com', 'Plan Lekcji'); /* adres e-mail i nazwa nadawcy */
    $mail->AddAddress($_SESSION['email']); /* adres lub adresy odbiorców */
    $mail->Subject = "Plan lekcji"; /* Tytuł wiadomości */
    $mail->Body = "Witaj, w załączniku wysłano plan lekcji!";
    $mail->AddAttachment('planlekcji.jpg');


    if(!$mail->Send()) {
    echo "Wiadmość nie została wysłana!";
    } else 
    {
        echo "Wiadmość została wysłana!";
    }
    unlink('planlekcji.jpg');
}

?>