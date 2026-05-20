<?php
    session_start();
    require_once "../script/connessione.php";
    include "../script/login-control.php";
?>

<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Gestione Personale</title>
		<link rel="stylesheet" href="../css/style.css" />
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	</head>
	<body>
	
	<?php include "../script/header.php"; ?>

	<main class="dashboard container">
		<h2 class="centered">Benvenuto, <?php include "../script/nome-utente.php"; ?>!</h2>

		<section class="dashboard-section">
			<h3>Grafico conto principale</h3>
			<?php include "../script/spese-grafico.php"; ?>
		</section>

		<section class="dashboard-section">
		<h3>Conti Correnti</h3>
		<div class="card-box">
			<?php include "script-home/card-conto.php"; ?>
		</div>
		</section>

		<section class="dashboard-section">
		<h3>Spese</h3>
		<div class="card-box">
			<?php include "script-home/spese.php"; ?> 
		</section>
	</main>

	<footer>
		<div class="container">
		<p>&copy; 2025 Banca Futuro - Tutti i diritti riservati</p>
		</div>
	</footer>
	</body>
</html>