<?php
session_start();
require 'functions.php';
requireLogin();
$prenotazioni = readCsv(PRENOTAZIONI_CSV);
$filterData = $_GET['data'] ?? '';
$filterUfficio = $_GET['ufficio'] ?? '';
$filterStato = $_GET['stato'] ?? '';
$filtered = array_filter($prenotazioni, function($p) use ($filterData, $filterUfficio, $filterStato) {
    return (!$filterData || $p[1] == $filterData) &&
           (!$filterUfficio || $p[3] == $filterUfficio) &&
           (!$filterStato || $p[8] == $filterStato);
});
usort($filtered, function($a, $b) {
    return strtotime($a[1] . ' ' . $a[2]) <=> strtotime($b[1] . ' ' . $b[2]);
});
?>
<form method="get">
    Data: <input type="date" name="data" value="<?php echo htmlspecialchars($filterData); ?>"><br>
    Ufficio: <select name="ufficio">
        <option></option>
        <option>Anagrafe</option>
        <option>Tributi</option>
        <option>URP</option>
    </select><br>
    Stato: <select name="stato">
        <option></option>
        <option>INSERITA</option>
        <option>CONFERMATA</option>
        <option>ANNULATA</option>
    </select><br>
    <input type="submit" value="Filtra">
</form>
<table border="1">
    <tr><th>ID</th><th>Data</th><th>Ora</th><th>Ufficio</th><th>Nome</th><th>Cognome</th><th>Email</th><th>Stato</th><th>Azione</th></tr>
    <?php foreach ($filtered as $p): ?>
    <tr>
        <td><?php echo htmlspecialchars($p[0]); ?></td>
        <td><?php echo htmlspecialchars($p[1]); ?></td>
        <td><?php echo htmlspecialchars($p[2]); ?></td>
        <td><?php echo htmlspecialchars($p[3]); ?></td>
        <td><?php echo htmlspecialchars($p[4]); ?></td>
        <td><?php echo htmlspecialchars($p[5]); ?></td>
        <td><?php echo htmlspecialchars($p[7]); ?></td>
        <td><?php echo htmlspecialchars($p[8]); ?></td>
        <td>
            <?php if ($p[8] == 'INSERITA'): ?>
            <form method="post" action="azione.php" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $p[0]; ?>">
                <input type="hidden" name="azione" value="conferma">
                <input type="submit" value="Conferma">
            </form>
            <form method="post" action="azione.php" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $p[0]; ?>">
                <input type="hidden" name="azione" value="annulla">
                <input type="submit" value="Annulla">
            </form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="export.php">Esporta</a> | <a href="logout.php">Logout</a>
