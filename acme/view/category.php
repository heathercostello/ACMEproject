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
            <h1><?php echo $categoryName;?>Products</h1>

       <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];

            unset($_SESSION['message']);
        }
        ?>

        <?php if(count($products) > 0) { ?>
            <ul id="prod-display">
                <?php foreach ($products as $product) { ?>

                    <?php
        
                        if (!file_exists ($_SERVER['DOCUMENT_ROOT'] . $product['invImage'])) {
                            $image = '/acme/images/no-img.png';
                        } else {
                            $image = $product['invThumbnail'];
                        }
                    ?>

                    <li>
                        <a href="/acme/products/?action=detail&invId=<?php echo $product['invId'] ?>" title="View <?php echo $product['invName'] ?>"><img
                        src='<?php echo $product['invThumbnail'] ?>' alt='Image of <?php echo $product['invName'] ?> on Acme.com'></a>
                        <hr>
                        <h2><a href="/acme/products/?action=detail&invId=<?php echo $product['invId'] ?>" title="View <?php echo $product['invName'] ?>">
                        <?php echo $product['invName']?></a></h2>

                        <span><?php echo $product['invPrice']?></span>
                </li>
                <?php } ?>
                </ul>
        <?php } ?>

        </main>


        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>