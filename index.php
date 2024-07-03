<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

// Check if the table should be reset
if (isset($_GET['reset'])) {
    $_SESSION['transactions'] = [];
    $_SESSION['startingPettyCash'] = isset($_SESSION['initialPettyCash']) ? $_SESSION['initialPettyCash'] : 8000.00;
    $_SESSION['startingRevolvingFund'] = isset($_SESSION['initialRevolvingFund']) ? $_SESSION['initialRevolvingFund'] : 2000.00;
    
    $sql = "SELECT * FROM transactions ORDER BY date ASC";
// Perform the reset operation
$sql = "DELETE FROM transactions"; // This will delete all records from the table


// Reset the auto-increment value
$sql = "ALTER TABLE transactions AUTO_INCREMENT = 1";

mysqli_select_db($conn, 'test');
// Perform the reset operation
$sql = "DELETE FROM transactions"; // This will delete all records from the table
mysqli_query($conn, $sql);

// Reset the auto-increment value
$sql = "ALTER TABLE transactions AUTO_INCREMENT = 1";
mysqli_query($conn, $sql);

}

// Retrieve starting balance values from URL parameters if available
if (isset($_GET['Petty Cash'])) {
    $_SESSION['startingPettyCash'] = floatval($_GET['pettycash']);
    $_SESSION['initialPettyCash'] = $_SESSION['startingPettyCash'];
}

if (isset($_GET['Revolving Funds'])) {
    $_SESSION['startingRevolvingFund'] = floatval($_GET['revolvingfund']);
    $_SESSION['initialRevolvingFund'] = $_SESSION['startingRevolvingFund'];
}

// Set default values for starting balances if not set in session
if (!isset($_SESSION['startingPettyCash'])) {
    $_SESSION['startingPettyCash'] = 8000.00;
    $_SESSION['initialPettyCash'] = $_SESSION['startingPettyCash'];
}

if (!isset($_SESSION['startingRevolvingFund'])) {
    $_SESSION['startingRevolvingFund'] = 2000.00;
    $_SESSION['initialRevolvingFund'] = $_SESSION['startingRevolvingFund'];
}

$startingPettyCash = $_SESSION['startingPettyCash'];
$startingRevolvingFund = $_SESSION['startingRevolvingFund'];

// Store initial starting balances and calculate initial total balance
$initialStartingPettyCash = $_SESSION['initialPettyCash'];
$initialStartingRevolvingFund = $_SESSION['initialRevolvingFund'];
$initialTotalBalance = $initialStartingPettyCash + $initialStartingRevolvingFund;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $transactionAmount = $_POST['transaction_amount'];
    $category = $_POST['category'];
    $fundSource = $_POST['fundsource'];

    

    $entry = [
        'datetime' => date("Y-m-d"), // Store the date and time of the transaction
        'description' => $description,
        'category' => $category,
        'fundsource' => $fundSource,
        'incoming' => 0, // Default initial value for incoming
        'outgoing' => 0, // Default initial value for outgoing
        'total_balance' => 0, // Default initial value for total_balance
        'petty_cash' => 0, // Default initial value for petty_cash
        'revolving_fund' => 0, // Default initial value for revolving_fund
    ];

    // Calculate the new balance based on the selected fund source and transaction amount
    if ($fundSource === 'Petty Cash') {
        if ($_POST['transaction_type'] === 'incoming') {
            $incoming = $transactionAmount;
            $outgoing = 0;

            $startingPettyCash += $incoming;
        } elseif ($_POST['transaction_type'] === 'outgoing') {
            $outgoing = $transactionAmount;
            $incoming = 0;

            $startingPettyCash -= $outgoing;
        }
    } elseif ($fundSource === 'Revolving Funds') {
        if ($_POST['transaction_type'] === 'incoming') {
            $incoming = $transactionAmount;
            $outgoing = 0;

            $startingRevolvingFund += $incoming;
        } elseif ($_POST['transaction_type'] === 'outgoing') {
            $outgoing = $transactionAmount;
            $incoming = 0;

            $startingRevolvingFund -= $outgoing;
        }
    }

    $entry['incoming'] = $incoming;
    $entry['outgoing'] = $outgoing;
    $entry['petty_cash'] = $startingPettyCash;
    $entry['revolving_fund'] = $startingRevolvingFund;
    $entry['total_balance'] = $startingPettyCash + $startingRevolvingFund;
    

    $_SESSION['transactions'][] = $entry;

    // Save the entry to the database
    // (Ensure you have the correct database connection in db_functions.php)
    require_once 'db_functions.php';
    insertTransaction($entry);

    // Update the session starting balances to reflect the new values
    $_SESSION['startingPettyCash'] = $startingPettyCash;
    $_SESSION['startingRevolvingFund'] = $startingRevolvingFund;
    
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Log</title>
   <link rel="stylesheet" href="styleindex.css">
</head>
<script>
function validateForm() {
    // Get form inputs
    var description = document.getElementsByName("description")[0].value;
    var transactionAmount = document.getElementsByName("transaction_amount")[0].value;
    var category = document.getElementsByName("category")[0].value;
    var fundSource = document.getElementsByName("fundsource")[0].value;
    var transactionType = document.getElementsByName("transaction_type")[0].value;

    // Check if any required fields are empty
    if (!description || !transactionAmount || !category || !fundSource || !transactionType) {
        alert("Please fill in all the required fields.");
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}
</script>

<body>
    <!-- Add a button to set starting balance -->
    <div class="container">
        <div class="left-side">
            <h2>Register</h2>

    <form action="starting_balance.php">
        <input type="submit" value="Set Starting Balance">
    </form>

    <!-- Form to submit transactions -->
    <form action="index.php" method="post" onsubmit="return validateForm()">
        <label>Description</label><br>
        <input type="text" name="description"><br><br>

        <label>Transaction Amount</label><br>
        <input type="number" name="transaction_amount"><br><br>

        <label>Category</label><br>
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Office Supplies/Notarial/Courier">Office Supplies/Notarial/Courier</option>
            <option value="Car Repair & Supplies">Car Repair & Supplies</option>
            <option value="Building Repair">Building Repair</option>
            <option value="Bills & Other Payables">Bills & Other Payables</option>
            <option value="Equipment Repair">Equipment Repair</option>
            <option value="Donation">Donation</option>
            <option value="Fuel">Fuel</option>
            <option value="Replenishment">Replenishment</option>
        </select><br>

        <label>Fund Source</label><br>
        <select name="fundsource">
     
            <option value="Petty Cash">Petty Cash</option>
            <option value="Revolving Funds">Revolving Fund</option>
        </select><br><br>

        <label>Transaction Type</label><br>
        <select name="transaction_type">
            <option value="incoming">Incoming</option>
            <option value="outgoing">Outgoing</option>
        </select><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <br>
</div>

        <div class="right-side">
            <h2>Data Table</h2>
    <!-- Table display -->
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
        <th>Date and Time</th> <!-- Added column header for Date and Time -->
            <th>Description</th>
            <th>Incoming</th>
            <th>Outgoing</th>
            <th>Category</th>
            <th>Fund Source</th>
            <th>Total Balance</th>
            <th>Petty Cash</th>
            <th>Revolving Fund</th>
        </tr>
        <tr>
            <td>Starting Balance</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo number_format($initialTotalBalance, 2); ?></td>
            <td><?php echo number_format($initialStartingPettyCash, 2); ?></td>
            <td><?php echo number_format($initialStartingRevolvingFund, 2); ?></td>
        </tr>
        </div>
    </div>
        <?php
        // Loop through transactions in reverse order
        for ($i = 0; $i < count($_SESSION['transactions']); $i++) {
            $entry = $_SESSION['transactions'][$i];
            $pettyCashChange = $entry['fundsource'] === 'Petty Cash' ? $entry['incoming'] - $entry['outgoing'] : 0;
            $revolvingFundChange = $entry['fundsource'] === 'Revolving Funds' ? $entry['incoming'] - $entry['outgoing'] : 0;
            $startingPettyCash += $pettyCashChange;
            $startingRevolvingFund += $revolvingFundChange;
            
            ?>
            <tr>
                <td><?php echo $entry['datetime']; ?></td> <!-- Updated to show Date & Time -->
                <td><?php echo $entry['description']; ?></td>
                <td><?php echo number_format($entry['incoming'], 2); ?></td>
                <td><?php echo number_format($entry['outgoing'], 2); ?></td>
                <td><?php echo $entry['category']; ?></td>
                <td><?php echo $entry['fundsource']; ?></td>
                <td><?php echo number_format($entry['total_balance'], 2); ?></td>
                <td><?php echo number_format($entry['petty_cash'], 2); ?></td>
                <td><?php echo number_format($entry['revolving_fund'], 2); ?></td>
            </tr>
            
        <?php } 
        ?>
    </table>
    <br>
    <form  actionaction="reset_records.php" form="get">
        <input type="hidden" name="reset" value="true">
        <button type="submit" onclick="return confirm('Are you sure you want to reset the records?');">Reset Table</button>
    </form>
    <form action="pdf.php" method="post" target="_blank"> 
    <button type="submit" href="pdf.php" rel="noreferrer noopener">Generate PDF</button>
</form>
    <form action="excel.php" method="post" target="_blank"> 
    <button type="submit" href="excel.php" rel="noreferrer noopener">Generate Excel</button>
</form>
</body>

</html>
