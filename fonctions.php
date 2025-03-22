<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

function envoyerEmailConfirmation($email, $nom, $prenom) {
    $mail = new PHPMailer(true);

    try {
        // Activer le mode debug si besoin
        $mail->SMTPDebug = 0; // 0 = désactivé, 2 = debug
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mouadou.n666@gmail.com'; // Remplace avec ton email
        $mail->Password = 'hgup drnj hekl usbh'; // Utilise un "mot de passe d'application" si besoin
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom('mouadou.n666@gmail.com', 'Sonatrach');
        $mail->addAddress($email, "$prenom $nom");

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de votre inscription';
        $mail->Body = "<h1>Bonjour $prenom,</h1>
               <p>Merci pour votre inscription sur notre site de gestion du matériel informatique.</p>
               <p>Nous sommes ravis de vous compter parmi nous. Vous recevrez prochainement plus d'informations sur l'utilisation de notre plateforme.</p>
               <p>Cordialement,<br>L'équipe de gestion du matériel informatique.</p>" ;


        // Envoi de l'email
        if ($mail->send()) {
            return true;
        } else {
            return "Erreur d'envoi : " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        return "Exception : " . $mail->ErrorInfo;
    }
}




function check_login($con) {
    if (!isset($_SESSION["user_id"])) {
        header("Location: connexion.php");
        exit();
    }

    $id = $_SESSION["user_id"];
    $query = "SELECT * FROM users WHERE id = ? LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        return $result->fetch_assoc();
    } else {
        header("Location: connexion.php");
        exit();
    }
}



function random_num($length) {
    if ($length < 5) {
        $length = 5;
    }
    $text = "";
    for ($i = 0; $i < $length; $i++) {
        $text .= rand(0, 9);
    }
    return $text;
}
function envoyerEmailReinitialisation($email, $reset_link) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mouadou.n666@gmail.com';
        $mail->Password = 'hgup drnj hekl usbh'; // Utilise un mot de passe d'application Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('votre-email@gmail.com', 'Sonatrach');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reinitialisation de votre mot de passe';
        $mail->Body = "<p>Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>
                       <a href='$reset_link'>$reset_link</a>
                       <p>Ce lien est valide pendant 1 heure.</p>";

        $mail->send();
    } catch (Exception $e) {
        error_log("Erreur d'envoi de l'email : " . $mail->ErrorInfo);
    }
}
