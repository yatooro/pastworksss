<?php
session_start();
require('fpdf/fpdf.php');

require_once 'db_config.php';


$sql = "SELECT * FROM transactions ORDER BY date ASC";
$result = mysqli_query($conn, $sql);

// Create a new file pointer (output buffer) to store CSV data
$output = fopen('php://output', 'w');

// Write the CSV header row
$header = array(
    "date", "description", "category", "incoming", "outgoing",
    "fundsource", "total_Balance", "petty_Cash", "revolving_fund"
);
fputcsv($output, $header);

while ($row = $result->fetch_object()) {
    $data = array(
        $row->date, $row->description, $row->category,
         $row->incoming, $row->outgoing,
         $row->fundsource, $row->total_balance,
        $row->petty_cash, $row->revolving_fund
    );
    fputcsv($output, $data);
}


header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="pettycash_records.csv"');


fpassthru($output);

fclose($output);
?>