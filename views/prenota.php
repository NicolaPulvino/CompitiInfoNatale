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
<a href="?action=home">Home</a>