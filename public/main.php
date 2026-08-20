<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../line-awesome-1.3.0/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="style.css" ver="1.1">
	<title>Ekow</title>
</head>

<?php
$btnString = "Connexion";
if (!empty($_SESSION['id_user'])) {
  $btnString = "Dashboard";
}
?>

<body>
<header>
    <a class="logo">Ekow</a>
    <nav class="nav">
      <a href="#preview">Découvrir</a>
      <a href="#creator">Offres</a>
      <a href="contact.php">Contact</a>
    </nav>
    <div class="buttons">
      <a class="CoBtn" href="Connexion.php"><?=$btnString?></a>
      <a class="CoBtn">Essayer</a>
    </div>
</header>
<div class="glow"></div>
<div class="mainImg" >
  <div class="hookContain">
    <h2 class="accroche" >Optimisez vos décisions en comprenant votre audience</h2>
    <p class="hookPara">Décidez mieux en restant à l'écoute. Des retours clairs pour affiner vos actions et renforcer votre impact.</p>
    <div class="hookBtn">
       <a class="CoBtn" id="preview" >Essayer</a>
    </div>
  </div>
  <img class="hookImg" src="../images/fond1.png" >
  <img class="hookImgSmall" src="../images/fond1_bis.png" >
</div>
<div class="preview_container" >
  <a class="preview a">
    <img class="prevIcon" src="../images/bag.png">
    <h2 class="prevTitle">Boutiques</h2>
    <ul class="prevUl">
      <li class="prevLi"><i class="las la-check-circle"></i>Analyse de sentiment des avis clients</li>
      <li class="prevLi"><i class="las la-check-circle"></i>Détection des défaillances régulières</li>
      <li class="prevLi"><i class="las la-check-circle"></i>Résumé des points positifs et négatifs</li>
    </ul>
  </a>
  <a class="preview b">
    <img class="prevIcon" src="../images/publicity.png">
    <h2 class="prevTitle">Réseaux sociaux</h2>
    <ul class="prevUl">
      <li class="prevLi"><i class="las la-check-circle"></i>Identification des axes d'amélioration</li>
      <li class="prevLi"><i class="las la-check-circle"></i>Détection de badbuzz potentiels</li>
      <li class="prevLi"><i class="las la-check-circle"></i>Analyse des tendances</li>
    </ul>
  </a>
  <a class="preview c">
    <img class="prevIcon" src="../images/hotel.png">
    <h2 class="prevTitle">Établissements</h2>
    <ul class="prevUl">
      <li class="prevLi"><i class="las la-check-circle"></i>Évaluation de la satisfaction client</li>
      <li class="prevLi"><i class="las la-check-circle"></i>Surveillance des critiques récurrentes</li>
      <li class="prevLi"><i class="las la-check-circle"></i>Analyse des retours positifs et négatifs</li>
    </ul>
  </a>
</div>

<div class="widecontainer creator" id="creator">
  <img src="../images/fond3.png" class="offerImg">
  <div class="offerContent">
    <h1 class="offerTitle">Offre Créateur</h1>
    <div class="creator-offer-details">
      <p class="creator-offer-description">
        Optimisez vos performances sur les réseaux sociaux grâce à une analyse complète de vos publications.
      </p>
      <ul class="creator-offer-list">
        <li>Suivi automatique de vos nouveaux posts ou vidéos sur YouTube, TikTok, Instagram, et plus encore</li>
        <li>Vue d’ensemble de l’appréciation de vos contenus</li>
        <li>Statistiques détaillées sur chaque publication</li>
        <li>Détection des signaux négatifs et des bad buzz</li>
        <li>Comparaison et suivi de vos performances dans le temps</li>
      </ul>
      <p class="creator-offer-conclusion">
        Maîtrisez votre image, ajustez votre stratégie, et développez votre audience.
      </p>
    </div>
    <button class="CoBtn offerBtn">Commencer</button>
  </div>
</div>

<div class="widecontainer entre">
  <div class="offerContent">
    <h1 class="offerTitle">Offre Vendeur</h1>
    <div class="creator-offer-details">
      <p class="creator-offer-description">
        Optimisez vos ventes en identifiant rapidement les retours clés et les points faibles, sans perdre de temps.
      </p>
      <ul class="creator-offer-list">
        <li>Analyse automatique des avis clients sur vos produits (Amazon, Shopify, etc.)</li>
        <li>Détection et signalement des problèmes récurrents</li>
        <li>Classement de vos meilleures offres selon les retours et les performances</li>
        <li>Vue d’ensemble de la satisfaction client</li>
        <li>Compte rendu de vos best-sellers et des tendances d’achat</li>
      </ul>
      <p class="creator-offer-conclusion">
        Que vous lanciez un nouveau produit ou gériez un catalogue complet, cette analyse vous aide à prendre des décisions concrètes et orientées résultat.
      </p>
    </div>
    <button class="CoBtn offerBtn">Commencer</button>
  </div>
  <img src="../images/fond2.png" class="offerImg">
</div>

<div class="widecontainer business">
  <img src="../images/fondBusi.png" class="offerImg">
  <div class="offerContent">
    <h1 class="offerTitle">Offre Prestation</h1>
    <div class="creator-offer-details">
      <p class="creator-offer-description">
        Maîtrisez votre réputation locale et optimisez l’expérience client grâce à une analyse automatique et ciblée des avis en ligne.
      </p>
      <ul class="creator-offer-list">
        <li>Suivi de la satisfaction client</li>
        <li>Identification des points forts et des réclamations récurrentes</li>
        <li>Analyse continue des avis Google, TripAdvisor, Booking, etc.</li>
        <li>Comparaison de vos performances</li>
      </ul>
      <p class="creator-offer-conclusion">
        Exploitez chaque retour pour corriger, ajuster et faire progresser votre réputation avant qu’elle ne soit affectée.
      </p>
    </div>
    <button class="CoBtn offerBtn">Commencer</button>
  </div>
</div>

<footer>
  <div class="footer-container">

    <!-- Section Contact -->
    <div class="footer-section">
      <h3>Contact</h3>
      <p>Email : <a href="mailto:contact@example.com">contact@example.com</a></p>
    </div>

    <!-- Section Informations -->
    <div class="footer-section">
      <h3>Informations</h3>
      <ul>
        <li><a href="#">À propos</a></li>
        <li><a href="#">Mentions légales</a></li>
      </ul>
    </div>

    <!-- Section Crédits -->
    <div class="footer-section">
      <h3>Crédits</h3>
      <p>Site réalisé par Romain Lo Bello</p>
      <p>Illustrations :</p>
      <ul class="illustration-list">
        <li><a href="https://www.flaticon.com/free-icons/shopping-bag" title="shopping bag icons" target="_blank">Shopping bag icons created by Freepik - Flaticon</a></li>
        <li><a href="https://www.flaticon.com/free-icons/sns" title="sns icons" target="_blank">Sns icons created by Design Circle - Flaticon</a></li>
        <li><a href="https://www.flaticon.com/free-icons/hotel" title="hotel icons" target="_blank">Hotel icons created by Freepik - Flaticon</a></li>
      </ul>
      <p style="margin-top: 10px;">© 2025 Tous droits réservés</p>
    </div>

  </div>
</footer>
</body>
<script src="../javascript/main.js"></script>
</html>