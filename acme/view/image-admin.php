<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=6">
    <title>ACME | Image Management</title>
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
            <h1>Image Management</h1>
            <hr>
            <h2>Add New Product Image</h2>

            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];

                unset($_SESSION['message']);
                }?>

            <form action="/acme/uploads/" method="post" enctype="multipart/form-data">
            <label for="invItem">Product</label><br>
            <?php echo $prodSelect; ?><br><br>
            <label>Upload Image:</label><br>
            <input type="file" name="file1"><br>
            <input type="submit" class="regbtn" value="Upload">
            <input type="hidden" name="action" value="upload">
            </form>
            <hr>

            <h2>Existing Images</h2>
            <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
            <?php
            if (isset($imageDisplay)) {
            echo $imageDisplay;
            } ?>
                

        </main>


        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>
<?php unset($_SESSION['message']); ?>