<?php
    session_start();
    //includo connessione.php per stabilire la connessione php -> Mysqli
    require_once "../script/connessione.php";

    //importo i valori inseriti nel form html
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    //adesso preparo la query prima di inserirci i dati da inviare al db
    $PrepQuery = $conn->prepare("SELECT password, id_utente, role FROM utente WHERE email = ?");

    //inserisco nella query tramite bind_param
    $PrepQuery->bind_param("s", $email);

    //eseguo la query
    $PrepQuery->execute();

    //prendo il risultato della query e lo metto nella variabile result
    $result = $PrepQuery->get_result();

    if ($result->num_rows > 0) //verifico la query restituisce dei risultati, quindi esiste una password corrispondente alla mail
    {
        $row = $result -> fetch_assoc();
        //creo un array associatico $row
        //$row contiene la password associata alla mail inserita in posizione password (array assicuativo)
        
        //verifico che la password combaci
        if(password_verify($password, $row["password"])) {
            $_SESSION['email'] = $email;  // Salva l'email nella sessione
            $_SESSION['id_utente'] = $row['id_utente'];
            $_SESSION['role'] = $row['role'];

            //SALVATAGGIO COOKIE
            if(isset($_POST['remember']))
            {
                // Creo un token sicuro random
                $token = bin2hex(random_bytes(16));

                $QueryCookie = $conn->prepare("INSERT INTO user_tokens (id_utente, token) VALUES (?, ?)");
                $QueryCookie->bind_param("is", $row['id_utente'], $token);
                $QueryCookie->execute();

                // Imposto il cookie con il token (scadenza 30 giorni)
                setcookie("rememberme", $token, time() + 60*60*24*30, "/", "", true, true);
            }

            header("Location: ../home");
            exit;
        }
        else
        {
            include "../script/errore.php";
        }
        //password_verify controlla che la password contenuta nell'array $row in posizione password sia uguale alla password inserita nel login
        //la password contenuta in $row è criptata quindi si usa la funzione password_verify per ovviare a questo problema
        //con header vengo reindirizzatto nella pagina home.html
        //exit interrompe lo sketch per evitare che rimanga in esecuzione
    }
    else 
    {
        include "../script/errore.php";
    }
?>