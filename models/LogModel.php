<?php
require_once 'config.php';

class LogModel {
    public static function add($idOperatore, $azione, $idPrenotazione) {
        $log = readCsv(LOG_OPERAZIONI_CSV);
        $log[] = [date('Y-m-d H:i:s'), $idOperatore, $azione, $idPrenotazione];
        writeCsv(LOG_OPERAZIONI_CSV, $log);
    }
}
?>