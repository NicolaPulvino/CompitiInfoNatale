<?php
require 'functions.php';
session_start();
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $operatori = readCsv(OPERATORI_CSV);
    foreach ($operatori as $o) {
        if ($o[1] == $username && password_verify($password, $o[2])) {
            $_SESSION['user'] = $o[0];
            $_SESSION['ruolo'] = $o[3];
            header('Location: dashboard.php');
            exit;
        }
    }
    $message = "Credenziali errate.";
}
?>
<form method="post">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>
<?php echo htmlspecialchars($message); ?>
<a href="index.php">Home</a>
