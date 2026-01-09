<?php
session_start();
require 'functions.php';
requireLogin();
$prenotazioni = readCsv(PRENOTAZIONI_CSV);
$filterData = $_GET['data'] ?? '';
$filterUfficio = $_GET['ufficio'] ?? '';
$filtered = array_filter($prenotazioni, function($p) use ($filterData, $filterUfficio) {
    return (!$filterData || $p[1] == $filterData) &&
           (!$filterUfficio || $p[3] == $filterUfficio);
});
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="export.csv"');
$output = fopen('php://output', 'w');
foreach ($filtered as $row) {
    fputcsv($output, $row, ';');
}
fclose($output);
?>
