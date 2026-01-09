<?php
session_start();
require 'functions.php';
requireLogin();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $azione = $_POST['azione'];
    $prenotazioni = readCsv(PRENOTAZIONI_CSV);
    foreach ($prenotazioni as &$p) {
        if ($p[0] == $id) {
            if ($azione == 'conferma') $p[8] = 'CONFERMATA';
            elseif ($azione == 'annulla') $p[8] = 'ANNULATA';
            logOperation($_SESSION['user'], $azione, $id);
            break;
        }
    }
    writeCsv(PRENOTAZIONI_CSV, $prenotazioni);
}
header('Location: dashboard.php');
?>
