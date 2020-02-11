<!-- //If not logged in AND has a clientLevel greater than 1-send the user back to the home page
// if((!$_SESSION['loggedin']) && (!$_SESSION['clientData']['clientLevel'] > 1)){
//   header('Location: /acme/index.php');
//   exit;
// } -->
<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /acme/');
 exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
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
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
        </header>
        <nav>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php'; ?>
        </nav>


        <h1>Product Management</h1>
        <h2>Welcome to the product management page. Please choose an option below:</h2>

        <ul>
            <li><a href="/acme/products/index.php?action=newCat" title="Add a new category">Add a new Category</a></li>
      
            <li><a href="/acme/products/index.php?action=newProd" title="Add a new product">Add a new Product</a></li>
        </ul>

        <?php
            if (isset($message)) { 
                echo $message; 
                } 
            if (isset($categoryList)) { 
                echo '<h2>Products By Category</h2>'; 
                echo '<p>Choose a category to see those products</p>'; 
                echo $categoryList; 
                }
        ?>

<noscript>
<p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
</noscript>

<table id="productsDisplay"></table>

        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>

        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
    <script src="/acme/js/products.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>