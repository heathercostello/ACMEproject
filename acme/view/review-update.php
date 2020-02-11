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
            <form method="post" action="/acme/reviews/index.php">
                <h1><?php echo "Update $review[invName] Review"; ?></h1>
                    <?php if (isset($message)) { echo $message; } ?>
                    <label for="reviewText"><?php echo date('M n, Y', strtotime($review['reviewDate'])); ?></label><br>
                    <textarea name="reviewText" id="reviewText" title="Review Text" required><?php 
                            if (isset($reviewText)) { echo $reviewText; }
                            else { echo $review['reviewText']; } ?></textarea><br>
                
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="update-review-submit" >
                    <input type="hidden" name="reviewId" value="<?php if (isset($reviewId)) { echo $reviewId; } ?>">
                    <input type="hidden" name="invId" value="<?php if (isset($invId)) { echo $invId; } ?>">
                    <input type="submit" value="Update Review"><br>
                    <a href="/acme/accounts/">Return to Profile</a>
            </form>
        </main>


        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>