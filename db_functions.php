<?php
// db_functions.php

require_once 'db_config.php';

// Function to insert transaction into the database
function insertTransaction($entry)
{
    global $conn;

    $date = $entry['datetime'];
    $description = $conn->real_escape_string($entry['description']);
    $category = $conn->real_escape_string($entry['category']);
    $fundSource = $conn->real_escape_string($entry['fundsource']);
    $incoming = $entry['incoming'];
    $outgoing = $entry['outgoing'];
    $totalBalance = $entry['total_balance'];
    $pettyCash = $entry['petty_cash'];
    $revolvingFund = $entry['revolving_fund'];

    $sql = "INSERT INTO transactions (date, description, category, fundsource, incoming, outgoing, total_balance, petty_cash, revolving_fund)
            VALUES ('$date', '$description', '$category', '$fundSource', $incoming, $outgoing, $totalBalance, $pettyCash, $revolvingFund)";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}
