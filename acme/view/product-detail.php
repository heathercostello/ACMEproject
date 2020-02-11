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

<?php
        if (!file_exists ($_SERVER['DOCUMENT_ROOT'] . $product['invImage'])) {
            $image = '/acme/images/no-img.png';
        } else {
            $image = $product['invImage'];
        }
    ?>
<h1><?php echo $product['invName'] ?></h1>
    <p>Product reviews appear at the <a href='#bottom'>bottom of the page</a></p>
<hr>
        <div id="detail-display">
       
            <div id="detail-desc">
            <img src='<?php echo $image?>' alt='Image of our <?php echo $product['invName']?> product on Acme.com'>
                    <p id='dtlDesc'><?php echo $product['invDescription']?></p>
                    <p id='dtlVendor'>A <?php echo $product['invVendor']?> product</p>
                    <p id='dtlStyle'>Primary Material: <?php echo $product['invStyle']?></p>
                    <p id='dtlWeight'>Product Weight: <?php echo $product['invWeight']?> lbs.</p>
                    <p id='dtlSize'>Shipping Size: <?php echo $product['invSize']?> inches (w x l x h)</p>
                    <p id='dtllocation'>Ships From <?php echo $product['invLocation']?></p>
                    <p id='dtlStock'>Number in stock: <?php echo $product['invStock']?></p>
                    <p id='dtlPrice'>$<?php echo $product['invPrice']?></p> 
    </div>
    </div>
    <hr>
    <h1>Product Thumbnails</h1>
        <ul id="thumb-display">
            <?php foreach ($prodThumbs as $thumb) { ?>
                <li>
                    <img src='<?php echo $thumb['imgPath'];?>' alt='Image of our <?php echo $thumb['imgName'];?> product on Acme.com'>
                </li>
                <?php  } ?>
        </ul>

<hr>
<a id="bottom"></a>
<h1>Customer Reviews</h1>
    <h2>Review the <?php echo $product['invName'] ?></h2>
    <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];

            unset($_SESSION['message']);
        }
        ?>
    




        <?php if (!isset($_SESSION['clientData'])){
                echo "<p>To add you own review please <a href='/acme/accounts?action=login_user'>Login</a></p>";
        } else {
                echo "<div id ='login'>";
                echo "<form method='post' action='/acme/reviews/index.php'>";
                echo "<label for='reviewText'>Screen Name: ";
                echo substr($_SESSION['clientData']['clientFirstname'],0,1). $_SESSION['clientData']['clientLastname']."</label><br>";
                echo "<textarea name='reviewText' id='reviewText' placeholder='Provide Your Review Here' required></textarea>";
                echo "<input type='hidden' name='invId' value='$product[invId]'><br>";
                echo "<input type='hidden' name='action' value='addReview'>";
                echo "<input type='submit' value='Submit Review'>";
                echo "</form>";
                echo "</div>";
        }
        if (!isset($revDisplay)) { echo "<h3>There are no Reviews for this product</h3>"; }?>
            
           <h2>Past Customer Reviews</h2>
     
           <?php 
            $clientId = $_SESSION['clientData']['clientId'];
            $reviews = getReviewsByClientId($clientId);
            ?>
            <?php foreach ($reviews as $review) {
                if ($review['invId'] == $invId) {
                    ?>
                    <p><?php echo $_SESSION['clientData']['clientFirstname'][0]; echo $_SESSION['clientData']['clientLastname']?> wrote on 
                    <?php echo strftime("%d %B, %Y ", strtotime($review['reviewDate']));?></p>
                    <?php echo $review['reviewText'];?>
                <?php } ?>
            <?php }?>

        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php';?>
        </footer>
    </div>
</body>

</html>