<?php
require 'functions.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $cf = $_POST['codiceFiscale'];
    $prenotazioni = readCsv(PRENOTAZIONI_CSV);
    $found = false;
    foreach ($prenotazioni as $p) {
        if ($p[0] == $id && $p[6] == $cf) {
            $message = "Data: {$p[1]}, Ora: {$p[2]}, Ufficio: {$p[3]}, Stato: {$p[8]}";
            $found = true;
            break;
        }
    }
    if (!$found) $message = "Prenotazione non trovata.";
}
?>
<form method="post">
    ID Prenotazione: <input type="text" name="id" required><br>
    Codice Fiscale: <input type="text" name="codiceFiscale" required><br>
    <input type="submit" value="Verifica">
</form>
<?php echo htmlspecialchars($message); ?>
<a href="index.php">Home</a>
