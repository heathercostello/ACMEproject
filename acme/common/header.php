<div id="top">
  
    <a href="/acme/"><img id="logo" src="/acme/images/site/logo.gif" alt="logo"></a>

    <a href="/acme/accounts/index.php?action="><?php
     if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']){
        echo "Welcome " . $_SESSION['clientData']['clientFirstname'] . "<br>";
     }
     ?></a>

    <?php 
        // session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']){
            // if logged in then show logout link
            echo '<a href="/acme/accounts/?action=logout">Logout</a>';
        } 
        else {
            echo '<a href="/acme/accounts/index.php?action=login"><p id="folder"> <img src="/acme/images/site/account.gif" alt="folder">
            My Account</p></a>';
        }
    ?>

    </div>
     <!-- if logged in then show logout link -->
     <!-- <a href="/acme/accounts/?action=logout">Logout</a>
     
     <a href="/acme/accounts/index.php?action=login"><p id="folder"> <img src="/acme/images/site/account.gif" alt="folder">
        My Account</p></a> -->
    