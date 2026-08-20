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
if (empty($_SESSION['id_user'])) { 
  if (isset($_POST['subLog'])) {
    $mdp_user = htmlspecialchars($_POST['mdpLog']);
    $mail_user = htmlspecialchars($_POST['mailLog']);
    if (!empty($mail_user) && !empty($mdp_user)) {
      //on crypte le mdp
      $mdp = hash('md5', $mdp_user);
      $req_verif_db = $db->prepare("SELECT * FROM users WHERE mail_user = ? AND mdp_user = ? ");
      $req_verif_db->execute(array($mail_user,$mdp));
      $verif_db = $req_verif_db->rowCount();
      if ($verif_db == 1) {
        $info_user = $req_verif_db->fetch();
        $_SESSION['id_user'] = $info_user['id_user'];
        header('Location:dashboard.php');
        exit();         
      }else{
        $erreur = "Identifiant ou mot de passe invalide";
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
      <a href="inscription.php" class="signLink">Inscription</a>
        <button class="CoBtn offerBtn logBtn" name="subLog">Se connecter</button>
    </div>
    </form>
  </div>
</div>
<?php }
elseif (!empty($_SESSION['id_user'])) {
  header('Location:dashboard.php');
  exit();
}
?>
 <script src="../javascript/connexion.js"></script>
</body>
</html>
