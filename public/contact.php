<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ekow</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../line-awesome-1.3.0/1.3.0/css/line-awesome.min.css">
<link rel="stylesheet" type="text/css" href="style.css" ver="1.1">
</head>
<body>

<?php include "../config/database.php";
global $db;
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));
    $id_user = "None";
    if (isset($_SESSION['id_user'])) {
      $id_user = $_SESSION['id_user'];
    }

    if (!empty($email) && !empty($message)) {
        $to = "lobelloromain@email.com";
        $subject = "Contact Ekow";
        $body = "Email: $email\n\nMessage:\n$message\nid_user: $id_user";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            header('Location:contactSucess.php');
            exit(); 
        } else {
            $erreur = "Erreur lors de l'envoi. Réessayez plus tard.";
        }
    } else {
        $erreur = "Tous les champs sont requis.";
    }
}

?>

<div class="page-wrapper">
  <div class="login-container">
    <a class="login-title" >Contact</a>
    <form method="POST">
    <div class="input-group">
      <label for="email">Adresse e-mail</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="input-group">
      <label for="password">Message</label>
      <textarea class="contact-textarea" id="message" name="message" rows="5" required></textarea>
    </div>
    <label class="errLabel"><?=$erreur?></label>
    <div class="hookBtn">
        <button class="CoBtn offerBtn logBtn" name="subLog">Envoyer</button>
        <a class="CoBtn offerBtn logBtn" href="main.php">Retour</a>
    </div>
    </form>
  </div>
</div>
</body>
</html>
