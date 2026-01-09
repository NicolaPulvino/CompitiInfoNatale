<form method="post">
    ID Prenotazione: <input type="text" name="id" required><br>
    Codice Fiscale: <input type="text" name="codiceFiscale" required><br>
    <input type="submit" value="Verifica">
</form>
<?php echo htmlspecialchars($message); ?>
<a href="?action=home">Home</a>