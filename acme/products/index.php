<?php
//Products controller

// Create or access a Session 
session_start();


// //If not logged in -send the user back to the home page
// if(!$_SESSION['loggedin']){
//   header('Location: /acme/index.php');
//   exit;
// }

// //If user is not logged in-send them back to the home page
// if($_SESSION['clientData']['clientLevel'] < 3){
//   header('Location: /acme/index.php');
//   exit;
// }

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/library/connection.php';
// Get the acme model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/acme-model.php';
// Get the products model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/products-model.php';
// Get the uploads model
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/uploads-model.php';
// Get the reviews model
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/reviews-model.php';
// Get the functions library
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/library/functions.php';

// Get the array of categories
$categories = getCategories();

$pageTitle = 'Products';

$navList = buildNavigation($categories);

// // Build category dropdown list using a select element
// $catList = '<select name="categoryId">';
// $catList .= '<option>Select category</option>';
// foreach ($categories as $category) {
//   $catList .= '<option value="' . $category['categoryId'] . '">' . $category['categoryName'] . '</option>';
// }
// $catList .= '</select>';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
  case 'newCat':
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/new-cat.php';
    break;

  case 'addCat':
  $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);

  //Check for missing data
  if (empty($categoryName))  {
    $message = '<p>Please provide information for all empty form fields.</p>';
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/new-cat.php';
    exit;
  }

  // Send the data to the model
  $regOutcome = newCategory($categoryName);


  // Check and report the result
  if ($regOutcome === 1) {
        header('Location: /acme/products/');

    exit;
  } else {
    $message = "<p>Sorry could not addcategory. Please try again.</p>";
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/new-cat.php';
    exit;
  }

    break;

    case 'newProd':
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/new-prod.php';
    break;

 
    case 'addProd':
      $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
      $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
      $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
      $invImg = filter_input(INPUT_POST, 'invImg', FILTER_SANITIZE_STRING);
      $invThumb = filter_input(INPUT_POST, 'invThumb', FILTER_SANITIZE_STRING);
      $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
      $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_INT);
      $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_INT);
      $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
      $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
      $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);

  //Check for missing data
  if (empty($categoryId) || empty($invName) || empty($invDescription) || empty($invImg) || empty($invThumb) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($invVendor) || empty($invStyle))  {
    $message = '<p>Please provide information for all empty form fields.</p>';
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/new-prod.php';
    exit;
  }

  $insertResult = addProduct($categoryId, $invName, $invDescription, $invImg, $invThumb, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle);

  if ($insertResult) {
    $message = "<p class='notice'>Congratulations, $invName was successfully added.</p>";
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/new-prod.php';
    exit;
  } else {
    $message = "<p class='notice'>Congratulations, $invName was successfully added.</p>";
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/new-prod.php';
  }
  break;

  // Send the data to the model
  $regOutcome = newCategory($categoryName);

  // Check and report the result
  if ($regOutcome === 1) {
        header('Location: /acme/products/');

    exit;
  } else {
    $message = "<p>Sorry could not add a new  . Please try again.</p>";
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/new-prod.php';
    exit;
  }

  break;

/* * ********************************** 
* Get Inventory Items by categoryId 
* Used for starting Update & delete process 
* ********************************** */ 
case 'getInventoryItems': 
 // Get the categoryId 
 $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_SANITIZE_NUMBER_INT); 
 // Fetch the products by categoryId from the DB 
 $productsArray = getProductsByCategory($categoryId); 
 // Convert the array to a JSON object and send it back 
 echo json_encode($productsArray); 
 break;

 case 'mod':
 $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
 $prodInfo = getProductInfo($invId);
 if(count($prodInfo)<1){
  $message = 'Sorry, no product information could be found.';
 }
 include $_SERVER['DOCUMENT_ROOT'].'/acme/view/prod-update.php';
 exit;
break;

case 'updateProd':
$categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
 $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
 $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
 $invImg = filter_input(INPUT_POST, 'invImg', FILTER_SANITIZE_STRING);
 $invThumb = filter_input(INPUT_POST, 'invThumb', FILTER_SANITIZE_STRING);
 $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
 $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
 $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_INT);
 $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_INT);
 $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
 $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
 $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
 $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

 if (empty($categoryId) || empty($invName) || empty($invDescription) 
 || empty($invImg) || empty($invThumb) || empty($invPrice) 
 || empty($invStock) || empty($invSize) || empty($invWeight) 
 || empty($invLocation) || empty($invVendor) || empty($invStyle)) {
  $message = '<p>Please complete all information for the updated item! Double check the category of the item.</p>';
  include $_SERVER['DOCUMENT_ROOT'].'/acme/view/prod-update.php';
  exit;
 }
 $updateResult = updateProduct($categoryId, $invName, $invDescription, 
  $invImg, $invThumb, $invPrice, $invStock, $invSize, $invWeight, 
  $invLocation, $invVendor, $invStyle, $invId);
 if ($updateResult) {
  $message = "<p class='notify'>Congratulations, $invName was successfully updated.</p>";
  $_SESSION['message'] = $message;
  header('location: /acme/products/');
  exit;
  } else {
   $message = "<p>Error. The updated product was not updated.</p>";
   include '/acme/view/prod-update.php';
   exit;
 }
 break;

 case 'del':
    $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $prodInfo = getProductInfo($invId);
    if (count($prodInfo) < 1) {
      $message = 'Sorry, no product information could be found.';
    }
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/prod-delete.php';
    exit;
 break; 

 case 'deleteProd':
    $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
          
    $deleteResult = deleteProduct($invId);
    if ($deleteResult) {
      $message = "<p class='notice'>Congratulations, $invName was successfully deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /acme/products/');
      exit;
    } else {
      $message = "<p class='notice'>Error: $invName was not deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /acme/products/');
      exit;
    }
  
    case 'category':
    $categoryName = filter_input(INPUT_GET, 'categoryName', FILTER_SANITIZE_STRING);
    $products = getProductsByCategoryName($categoryName);
    if(!count($products)){
     $_SESSION['message'] = "<p class='notice'>Sorry, no $categoryName products could be found.</p>";
    } else {
     $prodDisplay = buildProductDisplay($products);
    }  

 include $_SERVER['DOCUMENT_ROOT'].'/acme/view/category.php';
 break;

 //enhancement 8 #2 new control structure to handle the process of getting a specific product's info
case 'detail';
      $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
      $product = getProductInfo($invId);

      if(empty($product)){
        $_SESSION['message'] = "Sorry no product information could be found.";
      } else {
        $prodThumbs = getProductImages($invId);
      // $productDisplay = buildProductsDisplay($product);
      }  
      
      $reviews = getReviewsByInvId($invId);
				if (!empty($reviews)) { $revDisplay = buildProdRevDisplay($reviews); }
				$category = getProductsByCategory($product['categoryId']);
				$imageArray = getProductImages($invId);
				$mainImg = NULL;
				if (isset($_GET['img'])){
						$imgId = filter_input(INPUT_GET, 'img', FILTER_SANITIZE_NUMBER_INT);
						$mainImg = getProductImages($imgId);
				}
				$prodDetail = buildProdDetail($product, $imageArray, $mainImg);
				include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/product-detail.php');
				break;

  default:

  //  $categoryList = buildCategoryList($categories);
  //   include $_SERVER['DOCUMENT_ROOT'].'/acme/view/prod-mgmt.php';
  $products = getProductBasics();
  if(count($products) > 0){
      $prodList = '<h2>Update a Product:</h2><table>';
      $prodList .= '<tbody>';
      $count = 1;
      foreach ($products as $product) {
          $prodList .= "<tr class='tableRow";
          if ($count%2 == 0){ $prodList .= " rowEven"; }
          $prodList .= "'><td title='Update $product[invName]'><a href='/acme/products?action=update-product&id=$product[invId]' title='Update $product[invName]'>$product[invName]</a></td>";
          $prodList .= "<td title='Delete $product[invName]'><form method='post' action='/acme/products/index.php'>";
          $prodList .= "<input type='hidden' name='action' value='delete-product'>";
          $prodList .= "<input type='hidden' name='id' value='$product[invId]'>";
          $prodList .= "<input type='submit' value='Delete'></form></td>";
          $prodList .= "</tr>";
          $count++;
      }
          $prodList .= '</tbody></table>';
  } else {
          $message = '<p>Sorry, no products were found.</p>';
  }
  $action = 'admin';
  include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/admin.php');
  exit;
  
}
    

// echo '<pre>'  . print_r($categories, true) . '</pre>':
// exit;

