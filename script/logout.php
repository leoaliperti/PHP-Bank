<?php
    session_start();
    session_unset();             // 2. Rimuove tutte le variabili di sessione
    session_destroy();           // 3. Distrugge la sessione stessa

    header("Location: ../login/");
    exit;
?>