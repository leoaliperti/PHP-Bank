<?php
    $ContiQuery = $conn->prepare("SELECT id_conto, titolo from conto_bancario WHERE id_utente = ?");
    $ContiQuery->bind_param("s", $_SESSION["id_utente"]);
    $ContiQuery->execute();

    $result = $ContiQuery->get_result();
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $SpeseQuery = $conn->prepare("SELECT importo, descrizione, data_aggiunta from spese WHERE id_conto = ?");
            $SpeseQuery->bind_param("i", $row["id_conto"]);
            $SpeseQuery->execute();

            $resultSpese = $SpeseQuery->get_result();
            if ($resultSpese->num_rows > 0)
            {
            $i=0;
            echo '
            <div class="card">
                <h4> Conto ' . $row['titolo'] . ' <h8> - Ultime 10 tranzazioni</h8></h4>';
            while ($rowSpese = $resultSpese->fetch_assoc())
            {
                if ($i >= 10) {
                break; // esce appena raggiunti 10 elementi
                }
                $data_aggiunta = $rowSpese['data_aggiunta'];
                echo '<hr class="chiaro"><p><b>' . $rowSpese['descrizione'] . ': ' . $rowSpese['importo'] . '</b>€ <dx>'. date("h:i d-m-y", strtotime($data_aggiunta)) . '</dx> </p>';
                $i++;
            }
            echo '</div>';
            }
        }
        
    }
    else
    {
        echo 'nessuna spesa';
    }
?>