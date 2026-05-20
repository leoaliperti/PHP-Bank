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
  <title>Bonifico</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
  <div class="container">
    <h1 class="centered">Effettua un Bonifico</h1>
    <form action="bonifico.php" method="post" class="bonifico-form">
        <label for="conto_sorgente">Scegli il conto</label><br />
        <select name="mittente" required>
            <option value="" disabled selected>Seleziona il conto</option>
            <?php
                require_once '../script/connessione.php';

                $ContiQuery = $conn->prepare("SELECT id_conto, titolo, iban from conto_bancario WHERE id_utente = ?");
                $ContiQuery->bind_param("s", $_SESSION["id_utente"]);
                $ContiQuery->execute();

                $result = $ContiQuery->get_result();
                if ($result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                    {
                        echo '<option value="'. $row["iban"] . '|' . $_SESSION["id_utente"] . '" >Conto'. $row['titolo'] . ' - ' . $row['iban'] . '</option>';
                    }
                }
            ?>
        </select><br />


        <label for="iban_destinatario">IBAN Destinatario</label><br />
        <input
            type="text"
            id="iban_destinatario"
            name="iban_destinatario"
            placeholder="IT0000000000000000000000000"
            required       
        /><br />

        <label for="intestazione">Intestazione</label><br />
        <input
            type="text"
            id="intestazione"
            name="intestazione"
            placeholder="Nome e Cognome"
            required
        /><br />

        <label for="importo">Importo (€)</label><br />
        <input
            type="number"
            id="importo"
            name="importo"
            placeholder="0.00"
            min="0.01"
            step="0.01"
            required
        /><br />

        <label for="causale">Causale</label><br />
        <input
            type="text"
            id="causale"
            name="causale"
            placeholder="Descrizione del bonifico"
            required
        /><br />

      <input type="submit" value="Invia Bonifico Istantaneo" class="save-submit" />
    </form>
  </div>
</body>
</html>
