<?php
if (!$_SESSION['loggedin']){
    header('Location: /acme/index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=6">
    <title>ACME | Template</title>
    <meta name="author" content="Heather Costello">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/acme/css/small.css">
    <link rel="stylesheet" href="/acme/css/large.css">
</head>

<body>
    <div id="content">
        <header>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/header.php'; ?> 
        </header>
        <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/navigation.php'; ?>
        </nav>

        <main>

        <?php
            if (isset($_SESSION['message'])){
                echo $_SESSION['message'];

                unset($_SESSION['message']);
            }
            ?>
        <form id="clientUpdate" method="post" action="/acme/accounts/index.php">
                <fieldset>
                <legend>Account Update Form</legend>
                    <label for="clientFirstname">First name: *</label><br>
                    <input type="text" name="clientFirstname" id="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} elseif(isset($_SESSION['
                    clientData']['clientFirstname'])) {echo "value'" . $_SESSION['clientData']['clientFirstname'] . "'";}?> required>
                    <br>

                    <label for="clientLastname">Last name: *</label><br>
                    <input type="text" name="clientLastname" id="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} elseif(isset($_SESSION['
                    clientData']['clientLastname'])) {echo "value'" . $_SESSION['clientData']['clientLastname'] . "'";}?> required>
                    <br>

                    <label for="clientEmail">Email: *</label><br>
                    <input type="email" name="clientEmail" id="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} elseif(isset($_SESSION['
                    clientData']['clientEmail'])) {echo "value'" . $_SESSION['clientData']['clientEmail'] . "'";}?> required>
                    <br>

                    <input type="submit" value="Update Account" name="submit">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="updateAccount">
                    <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId'];?>">

                </fieldset>
            </form>

            <?php
            if (isset($message)) {
                echo $message;
            }
            if (isset($_SESSION['message'])){
                echo $_SESSION['message'];
            }
            ?>
            <form id="updateAccountPassword" method="post" action="/acme/accounts/index.php">
                <fieldset>
                <legend>Change Password Form</legend>
                   
                    <label for="clientPassword">Password: *</label><br>
                    <span>By entering a password, it will change the current password.<br>
                        Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character. 
                    </span><br>
                    <input type="password" name="clientPassword" id="clientPassword" required 
                    pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                    <br><br>

                    <input type="submit" value="Update Password" name="submit">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="updatePassword">
                    <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId'];?>">

                </fieldset>
            </form>
        </main>


        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>