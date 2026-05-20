<?php
    session_start();
    if($_SESSION['id_utente'] == NULL)
    {
        header("Location: ../login");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Crea Nuovo Conto</title>
        <link rel="stylesheet" href="../css/style.css" />
    </head>
    <body>
        <div class="container form-container">
            <h1 class="centered">Crea Nuovo Conto</h1>
            <form action="crea-conto.php" method="post" class="create-account-form">
            
            <label for="titolo">Titolo conto</label>
            <input type="text" id="titolo" name="titolo" placeholder="Es. Risparmio" required>

            <label for="iban">IBAN</label>
            <input type="text" id="iban" name="iban" placeholder="Inserisci IBAN" required pattern="[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}" title="Inserisci un IBAN valido">

            <label for="saldo">Saldo iniziale (€)</label>
            <input type="number" id="saldo" name="saldo" placeholder="0.00" step="0.01" min="0" required>

            <label class="label-login">Email:
                <input type="email" name="email" placeholder="Inserisci la tua email" required>
            </label><br>

            <label class="label-login">Password:
                <input type="password" name="password" placeholder="Inserisci la tua password" required>
            </label class="label-login"><br>

            <input type="submit" value="Crea Conto" class="save-submit">
            <button onclick="location.href='../home'" class="save-submit">Torna alla home</button>
            </form>
        </div>
    </body>
</html>
