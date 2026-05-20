<?php
    session_start();
    require_once "../script/connessione.php";

    $id_utente = htmlspecialchars($_SESSION["id_utente"]);
    $password = htmlspecialchars($_POST["password"]);
    

    $PrepQuery = $conn->prepare("SELECT password FROM utente WHERE id_utente = ?");
    $PrepQuery->bind_param("s", $id_utente);
    $PrepQuery->execute();

    $result = $PrepQuery->get_result();
    if ($result->num_rows > 0)
    {
        $row = $result -> fetch_assoc();

        if(password_verify($password, $row["password"])) 
        {
            //PASSWORD CORRETTA
            $titoloConto = htmlspecialchars($_POST["titolo"]);
            $iban = htmlspecialchars($_POST["iban"]);
            $saldo = htmlspecialchars($_POST["saldo"]);

            $savaQuery = $conn->prepare('INSERT INTO conto_bancario (id_utente, titolo, iban, saldo) VALUE(?, ?, ?, ?)');
            $savaQuery->bind_param("issi", $id_utente, $titoloConto, $iban, $saldo);
            $savaQuery->execute();

            header('Location: ../crea-conto');
            exit;
        }
        else
        {
            include "../script/errore.php";
        }
    }
    else 
    {
        include "../script/errore.php";
    }
?>