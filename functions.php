<?php
require 'config.php';

function readCsv($file) {
    $data = [];
    if (file_exists($file)) {
        $handle = fopen($file, 'r');
        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (!empty($row) && $row[0][0] !== '#') {
                $data[] = $row;
            }
        }
        fclose($handle);
    }
    return $data;
}

function writeCsv($file, $data) {
    $handle = fopen($file, 'w');
    foreach ($data as $row) {
        fputcsv($handle, $row, ';');
    }
    fclose($handle);
}

function validateDate($date) {
    return strtotime($date) >= strtotime(date('Y-m-d'));
}

function validateTime($time) {
    return preg_match('/^\d{2}:\d{2}$/', $time);
}

function validateCf($cf) {
    return strlen($cf) == 16;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generateId() {
    return time() . rand(1000, 9999);
}

function checkDoubleBooking($data, $ora, $ufficio) {
    $prenotazioni = readCsv(PRENOTAZIONI_CSV);
    foreach ($prenotazioni as $p) {
        if ($p[1] == $data && $p[2] == $ora && $p[3] == $ufficio && in_array($p[8], ['INSERITA', 'CONFERMATA'])) {
            return true;
        }
    }
    return false;
}

function logOperation($idOperatore, $azione, $idPrenotazione) {
    $log = readCsv(LOG_OPERAZIONI_CSV);
    $log[] = [date('Y-m-d H:i:s'), $idOperatore, $azione, $idPrenotazione];
    writeCsv(LOG_OPERAZIONI_CSV, $log);
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
?>
