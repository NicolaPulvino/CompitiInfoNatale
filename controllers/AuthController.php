<?php
require_once 'models/OperatoreModel.php';

class AuthController {
    public static function login() {
        session_start();
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $operatore = OperatoreModel::authenticate($username, $password);
            if ($operatore) {
                $_SESSION['user'] = $operatore[0];
                $_SESSION['ruolo'] = $operatore[3];
                header('Location: ?action=dashboard');
                exit;
            } else {
                $message = "Credenziali errate.";
            }
        }
        include 'views/login.php';
    }

    public static function logout() {
        session_start();
        session_destroy();
        header('Location: ?action=home');
        exit;
    }
}
?>