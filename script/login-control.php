<?php
if($_SESSION['id_utente'] == NULL)
    {
        header("Location: ../login");
        exit;
    }
?>