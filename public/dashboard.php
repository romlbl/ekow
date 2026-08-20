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
<style>
.left_panel{
	background-color: var(--primary-color);
	box-sizing: border-box;
	padding: 1em;
	min-height: 100vh;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: flex-start;
}

#background{
	width: 100vw;
	min-height: 100vh;
	background-color: white;
	display: flex;
	justify-content: space-between;
	align-items: flex-start;
	z-index: 2;
}

.dsh_left_cat{
	display: flex;
	width: 100%;
	justify-content: space-between;
	align-items: center;
	margin-top: 0.7em;
	margin-bottom: 0.7em;
}
.dsh_left_cat:hover{
	transform: scale(1.01);
	transition: 0.3s;
}

.dsh_btn_left{
	outline: none;
	background-color: transparent;
	border: none;
	color: white;
	font-size: 1.2em;
	font-family: var(--font-main);
	display: flex;           
	align-items: center; 
	justify-content: center;
	gap: 0.5em;
	cursor: pointer;
}
.dsh_left_icon{
	font-size: 1.5em;
}
.dsh_left_text{
	font-size: 1.1em;
}
.la-angle-down{
	margin-left: 1em;
	cursor: pointer;
}

</style>

<body>
<?php include "../config/database.php";
global $db;
?>
<div id="background">

<div class="left_panel">
	<a class="logo" href="main.php">Ekow</a>
	<div class="dsh_left_cat">
		<button class="dsh_btn_left">
			<i class="las la-user-circle dsh_left_icon"></i>
			<small class="dsh_left_text">Profil</small>
		</button>
	</div>
	<div class="dsh_left_cat">
		<button class="dsh_btn_left">
			<i class="las la-credit-card dsh_left_icon"></i>
			<small class="dsh_left_text">Abonnements</small>
		</button>
		<i class="las la-angle-down"></i>
	</div>
	<div class="dsh_left_cat">
		<button class="dsh_btn_left">
			<i class="las la-chart-pie dsh_left_icon"></i>
			<small class="dsh_left_text">Analyses</small>
		</button>
		<i class="las la-angle-down"></i>
	</div>
	<div class="dsh_left_cat">
		<button class="dsh_btn_left">
			<i class="las la-cog dsh_left_icon"></i>
			<small class="dsh_left_text">Paramètres</small>
		</button>
	</div>
	<div class="dsh_left_cat">
		<button class="dsh_btn_left">
			<i class="las la-arrow-circle-left dsh_left_icon"></i>
			<small class="dsh_left_text">Déconnexion</small>
		</button>
	</div>
</div>	
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="../javascript/dashboard.js"></script>
</body>
</html>