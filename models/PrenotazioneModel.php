<?php
require_once 'config.php';

class PrenotazioneModel {
    public static function getAll() {
        return readCsv(PRENOTAZIONI_CSV);
    }

    public static function getById($id) {
        $prenotazioni = self::getAll();
        foreach ($prenotazioni as $p) {
            if ($p[0] == $id) return $p;
        }
        return null;
    }

    public static function add($data, $ora, $ufficio, $nome, $cognome, $cf, $email) {
        $id = generateId();
        $prenotazioni = self::getAll();
        $prenotazioni[] = [$id, $data, $ora, $ufficio, $nome, $cognome, $cf, $email, 'INSERITA', date('Y-m-d H:i:s')];
        writeCsv(PRENOTAZIONI_CSV, $prenotazioni);
        return $id;
    }

    public static function updateStatus($id, $status) {
        $prenotazioni = self::getAll();
        foreach ($prenotazioni as &$p) {
            if ($p[0] == $id) {
                $p[8] = $status;
                break;
            }
        }
        writeCsv(PRENOTAZIONI_CSV, $prenotazioni);
    }

    public static function filter($data = '', $ufficio = '', $stato = '') {
        $prenotazioni = self::getAll();
        return array_filter($prenotazioni, function($p) use ($data, $ufficio, $stato) {
            return (!$data || $p[1] == $data) &&
                   (!$ufficio || $p[3] == $ufficio) &&
                   (!$stato || $p[8] == $stato);
        });
    }

    public static function checkDoubleBooking($data, $ora, $ufficio) {
        $prenotazioni = self::getAll();
        foreach ($prenotazioni as $p) {
            if ($p[1] == $data && $p[2] == $ora && $p[3] == $ufficio && in_array($p[8], ['INSERITA', 'CONFERMATA'])) {
                return true;
            }
        }
        return false;
    }
}
?>