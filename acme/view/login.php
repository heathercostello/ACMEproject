<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=6">
    <title>ACME | Log In</title>
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
            <h1 id="login">Log In</h1>
            <p>* indicate required fields</p>
            <hr>
            <?php
            if (isset($message)) {
                echo $message;
            }
            if (isset($_SESSION['message'])){
                echo $_SESSION['message'];
            }
            ?>
            <form id="loginform" action="/acme/accounts/" method="post">
                <fieldset>
                <label for="clientEmail">Email Address *</label><br>
                <input type="email" name="clientEmail" id="clientEmail" placeholder="johndoe@gmail.com" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?>required>
                <br>
                <label for="clientPassword">Password: *</label><br>
                    <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
                    <input type="password" name="clientPassword" id="clientPassword" required 
                    pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                    <br><br>
                <input id="button" type="submit" value="Login" name="submit">
                <input type="hidden" name="action" value="login_user">
            </form>
</fieldset>
            <div id="register">
            <h2>Not a member?</h2>
            <a id="regbutton" href="/acme/accounts/index.php?action=registration">Create an account</a>
            </div>
        </main>


        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>