<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=6">
    <title>ACME | Home</title>
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
            <h1>Welcome to Acme!</h1>
            <div class="container">
                <img id="rocket" src="/acme/images/site/rocketfeature.jpg" alt="rocket">
                <div class="text-block">
                    <h2>Acme Rocket</h2>
                    <p>Quick lighting fuse</p>
                    <p>NHTSA approved seat belts</p>
                    <p>Mobile launch stand included</p>
                    <a href="/acme/cart/"><img id="actionbtn" alt="Add to cart button" src="/acme/images/site/iwantit.gif"></a>
                </div>
            </div>


            <!-- four picture grid recipes -->
            <div class="row">
                <div class="column">
                    <h3>Acme Rocket Reviews</h3>
                    <p>"I don't know how I ever caught roadrunners before this." (4/5)</p>
                    <p>"That thing was fast!" (4/5)</p>
                    <p>"Talk about fast delivery." (5/5)</p>
                    <p>"I didn't even have to pull the meat apart." (4.5/5)</p>
                    <p>"I'm on my thirtieth one. I love these things!" (5/5)</p>

                </div>
                <div class="column">
                    <h3>Featured Recipes</h3>
                    <div class="gallery">
                        <figure class="fig">
                            <img src="/acme/images/recipes/bbqsand.jpg" alt="bbq">
                            <figcaption class="desc">Pulled Roadrunner BBQ</figcaption>
                        </figure>

                        <figure class="fig">
                            <img src="/acme/images/recipes/potpie.jpg" alt="potpie">
                            <figcaption class="desc">Roadrunner Pot Pie</figcaption>
                        </figure>

                        <figure class="fig">
                            <img src="/acme/images/recipes/soup.jpg" alt="soup">
                            <figcaption class="desc">Roadrunner Soup</figcaption>
                        </figure>

                        <figure class="fig">
                            <img src="/acme/images/recipes/taco.jpg" alt="tacos">
                            <figcaption class="desc">Roadrunner Tacos</figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <hr>
        </main>


        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>