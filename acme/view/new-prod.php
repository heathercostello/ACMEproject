<!-- <php
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
<?php
// Build category dropdown list using a select element
$catList = '<select name="categoryId">';
$catList .= '<option>Select category</option>';
foreach ($categories as $category) {
    $catList .= "<option value='$category[categoryId]'";
    if (isset($categoryId)) {

        if ($category['categoryId'] === $categoryId) {
            $catList .= ' selected ';
        }
    }

    $catList .=  ">$category[categoryName]</option>";
}
$catList .= '</select>';
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

        <main>
            <h1>Add Product</h1>
            <h2>Add a new product below. All fields are required!</h2>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>

            <form action="/acme/products/" method="post">
                <fieldset>

                    <label class="form-label" for="catType">Category</label>
                    <br>
                    <?php echo $catList; ?>

                    <br>
                    <label class="form-label" for="invName">Product Name</label><br>
                    <input id="invName" type="text" placeholder="name" name="invName"  maxlength="50" <?php if (isset($invName)) {
                                                                                                        echo "value='$invName'";
                                                                                                    } ?> required>
                    <br>

                    <label class="form-label" for="invDesc">Product Description</label><br>
                    <textarea name="invDescription" id="invDescription" rows="7" cols="103" placeholder="Enter the product description" required><?php if (isset($invDescription)) {
                                                                                                                                                        echo $invDescription;
                                                                                                                                                    } ?></textarea>
                    <br>

                    <label class="form-label" for="invImg">Product Image (path to Image)</label><br>
                    <input id="invImg" type="text" name="invImg"  maxlength="50" value="/acme/images/no-img.png" <?php if (isset($invImg)) {
                                                                                                                                    echo "value='$invImg'";
                                                                                                                                } ?> required>
                    <br>

                    <label class="form-label" for="invThumb">Product Thumbnail (path to thumbnail)</label><br>
                    <input id="invThumb" type="text" name="invThumb"  value="/acme/images/no-img.png" <?php if (isset($invThumb)) {
                                                                                                                        echo "value='$invThumb'";
                                                                                                                    } ?> required>
                    <br>

                    <label class="form-label" for="invPrice">Product Price</label><br>
                    <input id="invPrice" type="number" placeholder="ex: 22.22" name="invPrice" step=".05" <?php if (isset($invPrice)) {
                                                                                        echo "value='$invPrice'";
                                                                                    } ?> required>
                    <br>

                    <label class="form-label" for="invStock"># in Stock</label><br>
                    <input id="invStock" type="number" placeholder="ex: 22" name="invStock" <?php if (isset($invStock)) {
                                                                                            echo "value='$invStock'";
                                                                                        } ?> required>
                    <br>

                    <label class="form-label" for="invSize">Shipping Size (W x H x L in inches)</label><br>
                    <input id="invSize" type="number" placeholder="ex: 44" name="invSize"  <?php if (isset($invSize)) {
                                                                                        echo "value='$invSize'";
                                                                                    } ?> required>
                    <br>

                    <label class="form-label" for="invWeight">Weight (lbs.)</label><br>
                    <input id="invWeight" type="number" placeholder="ex: 33" name="invWeight" <?php if (isset($invWeight)) {
                                                                                            echo "value='$invWeight'";
                                                                                        } ?> required>
                    <br>

                    <label class="form-label" for="invLocation">Location (city name)</label><br>
                    <input id="invLocation" type="text" placeholder="ex: Mesa" name="invLocation" maxlength="50" <?php if (isset($invLocation)) {
                                                                                                                echo "value='$invLocation'";
                                                                                                            } ?> required>
                    <br>

                    <label class="form-label" for="invVendor">Vendor Name</label><br>
                    <input id="invVendor" type="text" name="invVendor" placeholder="ex: Local Motion" maxlength="50" <?php if (isset($invVendor)) {
                                                                                                            echo "value='$invVendor'";
                                                                                                        } ?> required>
                    <br>

                    <label class="form-label" for="invStyle">Primary Material</label><br>
                    <input id="invStyle" type="text" placeholder="ex: Metal" name="invStyle" maxlength="50" <?php if (isset($invStyle)) {
                                                                                                        echo "value='$invStyle'";
                                                                                                    } ?> required>
                    <br>

                    <!-- <label>&nbsp;</label> -->

                    <input type="submit" value="Add Product" name="submit">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="addProd">

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