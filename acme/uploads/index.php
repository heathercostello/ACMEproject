<?php
//Image Uploads Controller

// Create or access a Session 
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/library/connection.php';
// Get the acme model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/acme-model.php';
// Get the accounts model
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/accounts-model.php';
// Get the products model
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/products-model.php';
// Get the uploads model
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/uploads-model.php';
// Get the functions library
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/library/functions.php';


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
 $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}


// Get the array of categories
$categories = getCategories();

$navList = buildNavigation($categories);


/* * ****************************************************
* Variables for use with the Image Upload Functionality
* **************************************************** */
// directory name where uploaded images are stored
$image_dir = '/acme//images/products';
// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;


switch ($action) {
    case 'upload':
        // Store the incoming product id
        $invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT);
        // Store the name of the uploaded image
        $imgName = $_FILES['file1']['name'];
            
        $imageCheck = checkExistingImage($imgName);
            
        if($imageCheck){
            $_SESSION['message'] = '<p class="notice">An image by that name already exists.</p>';
        } elseif (empty($invId) || empty($imgName)) {
            $_SESSION['message'] = '<p class="notice">You must select a product and image file for the product.</p>';
        } else {
        // Upload the image, store the returned path to the file
        $imgPath = uploadFile('file1');
            
        // Insert the image information to the database, get the result
        $result = storeImages($imgPath, $invId, $imgName);
            
        // Set a message based on the insert result
        if ($result) {
        $_SESSION['message'] = '<p class="notice">The upload succeeded.</p>';
        } else {
        $_SESSION['message'] = '<p class="notice">Sorry, the upload failed.</p>';
        }
        }
            
        // Store message to session
        $_SESSION['message'] = $message;
            
        // Redirect to this controller for default action
        header('location: .');
    break;

    case 'delete':
        // Get the image name and id
        $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
        $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);
            
        // Build the full path to the image to be deleted
        $target = $image_dir_path . '/' . $filename;
            
        // Check that the file exists in that location
        if (file_exists($target)) {
        // Deletes the file in the folder
        $result = unlink($target); 
        }
            
        // Remove from database only if physical file deleted
        if ($result) {
        $remove = deleteImage($imgId);
        }
            
        // Set a message based on the delete result
        if ($remove) {
            $_SESSION['message'] = "<p class='notice'>$filename was successfully deleted.</p>";
        } else {
            $_SESSION['message'] = "<p class='notice'>$filename was NOT deleted.</p>";
        }
            
        // Store message to session
        $_SESSION['message'] = $message;
            
        // Redirect to this controller for default action
        header('location: .');
    break;
    default:
        // Call function to return image info from database
        $imageArray = getImages();
            
        // Build the image information into HTML for display
        if (count($imageArray)) {
        $imageDisplay = buildImageDisplay($imageArray);
        } else {
        $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
        }
            
        // Get inventory information from database
        $products = getProductBasics();
        // Build a select list of product information for the view
        $prodSelect = buildProductsSelect($products);
            
        include '../view/image-admin.php';
exit;
    break;
   }