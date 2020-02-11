<!-- ?php
//If not logged in AND has a clientLevel greater than 1-send the user back to the home page
if((!$_SESSION['loggedin']) && (!$_SESSION['clientData']['clientLevel'] > 1)){
  header('Location: /acme/index.php');
  exit;
}?> -->
<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /acme/');
 exit;
}?>
<!DOCTYPE html>
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
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
        </header>
        <nav>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php'; ?>
        </nav>

        <main>
            <h1>Add Category</h1>
            <h2>Add a new category of products below.</h2>
            <?php
            if(isset($message)){
                echo $message;
            }
            ?>
            <form action="/acme/products/index.php" method="post">
                <fieldset>
                    <label class="form-label" for="categoryName">New Category Name</label><br>
                    <input id="categoryName" type="text" name="categoryName" placeholder="" maxlength="50" required value="<?php if (isset($_POST['categoryName'])){echo $_POST['categoryName'];} ?>"/>
                    <label>&nbsp;</label>
                    <input type="submit" value="Add Category" name="submit">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="addCat">
                    <br>
                </fieldset>
            </form>
        </main>

        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>

