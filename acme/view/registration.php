<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=6">
    <title>ACME | Register</title>
    <meta name="author" content="Heather Costello">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/acme/css/small.css">
    <link rel="stylesheet" href="/acme/css/large.css">
</head>

<body>
    <div id="content">
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
        </header>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php'; ?>

        <main>
            <h1>Register</h1>
            <p>* indicate required fields</p>
            <hr>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form id="registration" method="post" action="/acme/accounts/index.php">
                <fieldset>
                    <label for="clientFirstname">First name: *</label><br>
                    <input type="text" name="clientFirstname" id="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> required>
                    <br>

                    <label for="clientLastname">Last name: *</label><br>
                    <input type="text" name="clientLastname" id="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> required>
                    <br>

                    <label for="clientEmail">Email: *</label><br>
                    <input type="email" name="clientEmail" id="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required>
                    <br>

                   
                    <label for="clientPassword">Password: *</label><br>
                    <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
                    <input type="password" name="clientPassword" id="clientPassword" required 
                    pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                    <br><br>

                    <input type="submit" value="Register" name="submit">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="register">

                </fieldset>
            </form>
        </main>


        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>