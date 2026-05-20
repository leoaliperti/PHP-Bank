<?php
    $ContiQuery = $conn->prepare("SELECT id_conto, titolo, iban, saldo, valuta from conto_bancario WHERE id_utente = ?");
    $ContiQuery->bind_param("s", $_SESSION["id_utente"]);
    $ContiQuery->execute();

    $result = $ContiQuery->get_result();
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $saldo = $row['saldo'];
            echo '
            <div class="card">
                <h4> Conto ' . $row['titolo'] . '</h4>
                <p> Saldo: <b>' . number_format("$saldo", 0, ',', '.') . '</b></p>
                <p> IBAN: ' . $row['iban']. '</p>
            </div>';
        }
        
    }
    else
    {
        echo '
            <div class="card">
                <a href="../crea-conto" class="button">Crea il tuo primo conto!</a>
            </div>';
    }
?>