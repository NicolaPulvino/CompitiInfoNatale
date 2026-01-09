<?php
require_once 'models/PrenotazioneModel.php';
require_once 'models/LogModel.php';

class PrenotazioneController {
    public static function prenota() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST['data'];
            $ora = $_POST['ora'];
            $ufficio = $_POST['ufficio'];
            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            $cf = $_POST['codiceFiscale'];
            $email = $_POST['email'];
            if (!validateDate($data)) {
                $message = "Data non valida. Deve essere oggi o futura.";
            } elseif (!validateTime($ora)) {
                $message = "Ora non valida.";
            } elseif (!validateCf($cf)) {
                $message = "Codice fiscale non valido. Deve essere di 16 caratteri.";
            } elseif (!validateEmail($email)) {
                $message = "Email non valida.";
            } elseif (PrenotazioneModel::checkDoubleBooking($data, $ora, $ufficio)) {
                $message = "Prenotazione già esistente per questa data, ora e ufficio.";
            } else {
                $id = PrenotazioneModel::add($data, $ora, $ufficio, $nome, $cognome, $cf, $email);
                $message = "Prenotazione effettuata. Codice: $id";
            }
        }
        include 'views/prenota.php';
    }

    public static function verifica() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $cf = $_POST['codiceFiscale'];
            $p = PrenotazioneModel::getById($id);
            if ($p && $p[6] == $cf) {
                $message = "Data: {$p[1]}, Ora: {$p[2]}, Ufficio: {$p[3]}, Stato: {$p[8]}";
            } else {
                $message = "Prenotazione non trovata.";
            }
        }
        include 'views/verifica.php';
    }

    public static function azione() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $azione = $_POST['azione'];
            if ($azione == 'conferma') {
                PrenotazioneModel::updateStatus($id, 'CONFERMATA');
            } elseif ($azione == 'annulla') {
                PrenotazioneModel::updateStatus($id, 'ANNULATA');
            }
            LogModel::add($_SESSION['user'], $azione, $id);
        }
        header('Location: ?action=dashboard');
        exit;
    }
}
?>