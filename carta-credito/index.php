<?php
    session_start();
    include "../script/login-control.php";
$nome_proprietario = "Leonardo Aliperti";
$credito_disponibile = 1245.78;
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Carta di Credito</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <?php include "../script/header.php"; ?>

        <div class="cartacontainer">
            <div class="carta-di-credito">
                <div class="chip"></div>

                <div class="numero-carta">
                    1234 5678 9012 3456
                    <div class="credito">
                        € <?php echo number_format($credito_disponibile, 2, ',', '.'); ?>
                    </div>
                </div>

                <div class="dati-carta">
                    <div class="proprietario"><?php echo htmlspecialchars($nome_proprietario); ?></div>
                </div>

                <div class="logo-mastercard">
                    <div class="cerchi-container">
                        <div class="cerchio giallo"></div>
                        <div class="cerchio rosso"></div>
                        <div class="cerchio giallo-trasp"></div>
                    </div>
                    <div class="marchio">Mastercard</div>
                </div>
            </div>
        </div>

        <div class="div-sotto-carta">

        </div>
    </body>
</html>
