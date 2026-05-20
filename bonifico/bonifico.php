<?php
    session_start();
    if($_SESSION['id_utente'] == NULL)
    {
        header("Location: ../login");
        exit;
    }

    $mittente = htmlspecialchars($_POST['mittente']);
    $parti = explode('|', $mittente);
    echo $mittente . "<br>";
    $iban_mittente = $parti[0];
    $id_conto_mittente = $parti[1];

    $iban_destinatario = htmlspecialchars($_POST['iban_destinatario']);
    $intestazione = htmlspecialchars($_POST['intestazione']);
    $importo = htmlspecialchars($_POST['importo']);
    $importo = floatval(str_replace(',', '.', $importo)); // Per sicurezza, se arriva con virgole
    $causale = htmlspecialchars($_POST['causale']);

    echo $iban_destinatario ."<br>";
    echo $importo . "<br>";
    echo $id_conto_mittente;


    require_once "../script/connessione.php";

    $idContoDestinatario = $conn->prepare('SELECT id_conto FROM conto_bancario WHERE iban = ?');
    $idContoDestinatario->bind_param("s", $iban_destinatario);
    $idContoDestinatario->execute();
    $result = $idContoDestinatario->get_result();
    $row = $result->fetch_assoc();

    print_r($row, true);

    $id_conto_destinatario = $row['id_conto'];

    $Bonifico = $conn->prepare('INSERT INTO movimento (id_conto, importo, iban_destinatario, iban_mittente, titolo, descrizione) VALUE(?, ?, ?, ?, ?, ?)');
    $Bonifico -> bind_param("iissss", $id_conto_destinatario, $importo, $iban_destinatario, $iban_mittente, $intestazione, $causale);
    if ($Bonifico -> execute())
    {
        $Sottrazione = $conn->prepare("UPDATE conto_bancario SET saldo = saldo - ? WHERE id_conto = ?");
        $Sottrazione->bind_param("ii", $importo, $id_conto_mittente);
        $Sottrazione->execute();

        $Aggiunta = $conn->prepare("UPDATE conto_bancario SET saldo = saldo + ? WHERE id_conto = ?");
        $Aggiunta->bind_param("ii", $importo, $id_conto_destinatario);
        $Aggiunta->execute();

        header('Location: ../home');
        exit;
    }
?>