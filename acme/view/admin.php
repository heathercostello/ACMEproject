<?php

if (!$_SESSION['loggedin']){
    header('Location: /acme/index.php');
    exit;
}?>

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
             <?php 
             include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php'; ?>
         </nav>
        
         <main>
             <p>Hello! You are currently logged in.</p>
         <?php
           echo '<h1>' . $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname'] . '</h1>';
           
            if (isset($message)) { 
                echo $message; 
                } 

               echo '<p>' . "First name: " . $_SESSION['clientData']['clientFirstname'] .'</p>';
               echo '<p>' . "Last name: " . $_SESSION['clientData']['clientLastname'] .'</p>';
               echo '<p>' . "Email: " . $_SESSION['clientData']['clientEmail'] .'</p>';
            //    echo '<li>' . "User Level: " . $_SESSION['clientData']['clientLevel'] .'</li>';

           if ($_SESSION['clientData']['clientLevel'] > 1){
               echo "<h2>Administrative Clients</h2>", 
               "<p>Use the link below to administer products.</p>",
                "<p><a id='product_home' href='/acme/products/index.php' 
                title='Click to add a new Product'> Product Home</a></p>";
           }
           ?>
           <?php
            if ($_SESSION['clientData']['clientLevel'] >= 1){
            echo "<p><a id='clientUpdates' href='/acme/accounts/index.php?action=updateAccount' 
            title='Click to update account information'>Click to update account information</a></p>";
             } ?>

    

<h2>Manage Your Product Reviews</h2>
  <?php
    if (isset($revDisplay)) {
      echo $revDisplay;
    } else {echo "You haven't reviewed any products yet.";}
  ?>
         </main>

     
         <footer>
         <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php'; ?>
         </footer>
     </div>
 </body>

 </html>