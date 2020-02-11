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
    elseif(isset($prodInfo['categoryId'])){
        if($category['categoryId'] === $prodInfo['categoryId']){
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
    <title><?php if(isset($prodInfo['invName'])){ echo "Delete $prodInfo[invName]";} ?> | Acme, Inc.</title>

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
        <h1><?php if(isset($prodInfo['invName'])){ echo "Delete $prodInfo[invName]";} ?></h1>
            <h2><p>Confirm Product Deletion. The delete is permanent.</p></h2>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
<form method="post" action="/acme/products/">
 <fieldset>
  <label for="invName">Product Name</label>
  <input type="text" readonly name="invName" id="invName" 
   <?php if(isset($prodInfo['invName'])) {echo "value='$prodInfo[invName]'"; }?>>
  <label for="invDescription">Product Description</label>
  <textarea name="invDescription" readonly id="invDescription">
   <?php if(isset($prodInfo['invDescription'])) {echo $prodInfo['invDescription']; } ?></textarea>
  <label>&nbsp;</label>
  <input type="submit" class="regbtn" name="submit" value="Delete Product">
  <input type="hidden" name="action" value="deleteProd">
  <input type="hidden" name="invId" value="
   <?php if(isset($prodInfo['invId'])){ echo $prodInfo['invId'];} ?>">
 </fieldset>
 </form>
        </main>

        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>