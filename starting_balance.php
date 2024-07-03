<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    // Get the inputted starting petty cash and revolving fund values
    $startingPettyCash = floatval($_POST['starting_pettycash']);
    $startingRevolvingFund = floatval($_POST['starting_revolvingfund']);

    // Save the starting balance values to session variables
    $_SESSION['startingPettyCash'] = $startingPettyCash;
    $_SESSION['startingRevolvingFund'] = $startingRevolvingFund;

    unset($_SESSION['transactions']);

    // Redirect to the index page with the starting balance values as parameters
    header("Location: index.php?pettycash=$startingPettyCash&revolvingfund=$startingRevolvingFund");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Starting Balance</title>
    <link rel="stylesheet" href="stylesb.css">
</head>
<body>
    
    <h2>Set Starting Balance</h2>
    <form action="starting_balance.php" method="post" onsubmit=>
        <label>Starting Petty Cash:</label>
        <input type="number" name="starting_pettycash" step="0.01" required><br><br>

        <label>Starting Revolving Fund:</label>
        <input type="number" name="starting_revolvingfund" step="0.01" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <script>
        function validateForm() {
            var startingPettyCashInput = document.getElementsByName("starting_pettycash")[0];
            var startingRevolvingFundInput = document.getElementsByName("starting_revolvingfund")[0];

            // Check if input values are non-negative numbers
            if (startingPettyCashInput.value < 0 || startingRevolvingFundInput.value < 0) {
                alert("Please enter non-negative values for the starting balance.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</body>
</html>
