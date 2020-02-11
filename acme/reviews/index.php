<?php
//Reviews controller

// Create or access a Session 
session_start();

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

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}


// 1. Add a new review
// 2. Deliver a view to edit a review.
// 3. Handle the review update.
// 4. Deliver a view to confirm deletion of a review.
// 5. Handle the review deletion.
// 6. A default that will deliver the "admin" view if the client is logged in or the
// acme home view if not


switch ($action){
        
// 1. Add a new review
    case 'addReview':
            // Filter and store the data
            $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
            $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
            $clientId = $_SESSION['clientData']['clientId'];
            $prodDetail = getProductInfo($invId);
            if (empty($prodDetail)) {
                    $message = "<p>Sorry, no product was found.</p>";
                    include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/home.php');
                    exit;
            }
            if(empty($reviewText)){
                    $_SESSION['message'] = '<p>The review cannot be empty.</p>';
                    header("location: /acme/products/");
                    exit;
            }
          
            $addReviewResult = newReview($invId, $clientId, $reviewText);
                    
            if ($addReviewResult < 1) {
                    $_SESSION['message'] = "<p>Sorry, but your review wasn't added. Please try again.</p>";
                    header("location: /acme/products/");
                    exit;
            } else{
                    $_SESSION['message'] = "<p>Thanks for your review, it is shown below.</p>";
                    header("location: /acme/products/");
                    exit;
            }
    break;

    // 2. Deliver a view to edit a review.
    case 'update-review':
            $reviewId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            if (empty($reviewId)) {
                    $_SESSION['message'] = "Sorry, review could not be found";
                //     header('location: /acme/accounts/');
                include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/review-update.php');
                    exit;
            }
            $review = getReviewById($reviewId);
            if (empty($review)) {
                    $_SESSION['message'] = "Sorry, review could not be found";
                //     header('location: /acme/accounts/');
                include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/review-update.php');
                    exit;
            }
            
            include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/review-update.php');
    break;

    // 3. Handle the review update.
    case 'update-review-submit':
            // Filter and store the data
            $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
            $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
            $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
            $review = getReviewById($reviewId);
            if (empty($review)) {
                    $_SESSION['message'] = "Sorry, review could not be found";
                    include ($_SERVER['DOCUMENT_ROOT'].'/acme/accounts/');
                    exit;
            }
            // Check for missing data
            if(empty($reviewText)){
                    $message = '<p>The review cannot be empty.</p>';
                    include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/review-update.php');
                    exit;
            }

            $updateReviewResult = updateReview($reviewText, $reviewId);
                    
            if ($updateReviewResult < 1) {
                    $message = "<p>Sorry, but your review wasn't updated. Please try again.</p>";
                    include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/review-update.php');
                    exit;
            } else{
                    $_SESSION['message'] = "<p>your review was updated successfully.</p>";
                    include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/admin.php');
                    exit;
            }
    break;

    // 4. Deliver a view to confirm deletion of a review.
    case 'delete-review':
            $reviewId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            if (empty($reviewId)) {
                    $_SESSION['message'] = "Sorry, review could not be found";
                    header('location: /acme/accounts/');
                    exit;
            }
            $review = getReviewById($reviewId);
            if (empty($review)) {
                    $_SESSION['message'] = "Sorry, review could not be found";
                    header('location: /acme/accounts/');
                    exit;
            }
            
            include ($_SERVER['DOCUMENT_ROOT'].'/acme/view/review-delete.php');
    break;

    // 5. Handle the review deletion.
    case 'delete-review-submit':
            $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
            $review = getReviewById($reviewId);
            if (empty($review)) {
                    $_SESSION['message'] = "Sorry, review could not be found";
                    header('location: /acme/accounts/');
                    exit;
            }
            
            $deleteReviewResult = deleteReview($reviewId);
                    
            if ($deleteReviewResult < 1) {
                    $message = "<p>Sorry, but your review wasn't deleted. Please try again.</p>";
                    include ($_SERVER['DOCUMENT_ROOT'].'/view/review-delete.php');
                    exit;
            } else{
                    $_SESSION['message'] = "<p>your review was deleted successfully.</p>";
                    header('location: /acme/accounts/');
                    header('location: /acme/accounts/');
                    exit;
            }
    break;
// 6. A default that will deliver the "admin" view if the client is logged in or the
// acme home view if not

default:
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']){
 
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/admin.php';
} 
else {
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/home.php';
}

}