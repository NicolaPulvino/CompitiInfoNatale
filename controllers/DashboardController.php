<?php
require_once 'models/PrenotazioneModel.php';

class DashboardController {
    public static function dashboard() {
        requireLogin();
        $filterData = $_GET['data'] ?? '';
        $filterUfficio = $_GET['ufficio'] ?? '';
        $filterStato = $_GET['stato'] ?? '';
        $filtered = PrenotazioneModel::filter($filterData, $filterUfficio, $filterStato);
        usort($filtered, function($a, $b) {
            return strtotime($a[1] . ' ' . $a[2]) <=> strtotime($b[1] . ' ' . $b[2]);
        });
        include 'views/dashboard.php';
    }

    public static function export() {
        requireLogin();
        $filterData = $_GET['data'] ?? '';
        $filterUfficio = $_GET['ufficio'] ?? '';
        $filtered = PrenotazioneModel::filter($filterData, $filterUfficio);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv"');
        $output = fopen('php://output', 'w');
        foreach ($filtered as $row) {
            fputcsv($output, $row, ';');
        }
        fclose($output);
        exit;
    }
}
?>