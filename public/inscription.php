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

if (isset($_POST['mailLog']) && isset($_POST['mdpLog'])) {
  $mail = htmlspecialchars($_POST['mailLog']);
  $mdpSet = htmlspecialchars($_POST['mdpLog']);
  if (!empty($mail) && !empty($mdpSet) ) {
      $mdp = hash('md5', $mdpSet);
         $verif_mail = $db->prepare("SELECT * FROM users WHERE mail_user = ?");
         $verif_mail->execute(array($mail));
        if ($verif_mail->rowCount() == 0) {
           $verif_mdp = $db->prepare("SELECT * FROM users WHERE mdp_user = ?");
           $verif_mdp->execute(array($mdp));
           if ($verif_mdp->rowCount() == 0) {
              $crée_cmt = $db->prepare("INSERT INTO users (mail_user,mdp_user) VALUES (?,?) ");
              $success = $crée_cmt -> execute(array($mail,$mdp));
              if ($success) {
                $erreur = 'compte crée';
                $connect = $db->prepare("SELECT id_user FROM users WHERE mail_user = ? AND mdp_user = ? ");
                $connect->execute(array($mail,$mdp));
                $getId = $connect->fetch();
                $_SESSION['id_user'] = $getId['id_user'];
                header('Location:dashboard.php');
                exit();
            }
           }
          else{
            $erreur = 'Votre mot de passe est déja utilisée';
          }
        }
        else{
          $erreur = 'Votre adresse mail est déja utilisée';
        }
  }
}

?>

<div class="page-wrapper">
  <div class="login-container">
    <a class="login-title" href="main.php">Ekow</a>
    <form method="POST">
    <div class="input-group">
      <label for="email">Adresse e-mail</label>
      <input type="email" id="email" placeholder="adresse mail" name="mailLog" required>
    </div>

    <div class="input-group">
      <label for="password">Mot de passe</label>
      <input type="password" id="password" placeholder="mot de passe" name="mdpLog" required>
      <i class="las la-eye toggle-password" id="togglePassword"></i>
    </div>
    <label class="errLabel"><?=$erreur?></label>
    <div class="hookBtn">
        <button class="CoBtn offerBtn logBtn" name="subLog">Créer</button>
    </div>
    </form>
  </div>
</div>
 <script src="../javascript/connexion.js"></script>
</body>
</html>
