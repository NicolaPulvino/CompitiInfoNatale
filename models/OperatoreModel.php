<?php
require_once 'config.php';

class OperatoreModel {
    public static function getAll() {
        return readCsv(OPERATORI_CSV);
    }

    public static function authenticate($username, $password) {
        $operatori = self::getAll();
        foreach ($operatori as $o) {
            if ($o[1] == $username && password_verify($password, $o[2])) {
                return $o;
            }
        }
        return null;
    }
}
?>