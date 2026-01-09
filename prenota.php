<?php
require 'functions.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST['data'];
    $ora = $_POST['ora'];
    $ufficio = $_POST['ufficio'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $codiceFiscale = $_POST['codiceFiscale'];
    $email = $_POST['email'];
    if (validateDate($data) && validateTime($ora) && validateCf($codiceFiscale) && validateEmail($email) && !checkDoubleBooking($data, $ora, $ufficio)) {
        $id = generateId();
        $prenotazioni = readCsv(PRENOTAZIONI_CSV);
        $prenotazioni[] = [$id, $data, $ora, $ufficio, $nome, $cognome, $codiceFiscale, $email, 'INSERITA', date('Y-m-d H:i:s')];
        writeCsv(PRENOTAZIONI_CSV, $prenotazioni);
        $message = "Prenotazione effettuata. Codice: $id";
    } else {
        $message = "Errore nei dati o prenotazione già esistente.";
    }
}
?>
<form method="post">
    Data: <input type="date" name="data" required><br>
    Ora: <input type="time" name="ora" required><br>
    Ufficio: <select name="ufficio" required>
        <option>Anagrafe</option>
        <option>Tributi</option>
        <option>URP</option>
    </select><br>
    Nome: <input type="text" name="nome" required><br>
    Cognome: <input type="text" name="cognome" required><br>
    Codice Fiscale: <input type="text" name="codiceFiscale" required><br>
    Email: <input type="email" name="email" required><br>
    <input type="submit" value="Prenota">
</form>
<?php echo htmlspecialchars($message); ?>
<a href="index.php">Home</a>
