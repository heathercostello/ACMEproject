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
            <?php
            header("HTTP/1.0 404 Not Found");?>
        </header>
        <nav>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/navigation.php'; ?>
        </nav>

        <main>
            <h1>Server Error</h1>
            <p>Sorry, the server experienced a problem.</p>
            <hr>
        </main>


        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>