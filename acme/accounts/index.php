<?php
//Accounts controller

// Create or access a Session 
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/library/connection.php';
// Get the acme model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/acme-model.php';
// Get the accounts model
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/accounts-model.php';
// Get the reviews model
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/model/reviews-model.php';
// Get the functions library
require_once $_SERVER['DOCUMENT_ROOT'].'/acme/library/functions.php';


// Get the array of categories
$categories = getCategories();

$navList = buildNavigation($categories);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
  // case 'login_user':
  //   include $_SERVER['DOCUMENT_ROOT'].'/acme/view/admin.php';
  //   break;

  case 'login':
  include $_SERVER['DOCUMENT_ROOT'].'/acme/view/login.php';
  break;

  case 'login_user':
  include $_SERVER['DOCUMENT_ROOT'].'/acme/view/login.php';
  $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
  $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING );

  //Validate email
  $clientEmail = checkEmail($clientEmail);
  //Validate password
  $checkPassword = checkPassword($clientPassword);

  // Check for missing data
  if (empty($clientEmail) || empty($checkPassword)) {
    $message = '<p>Please provide information for all empty form fields.</p>';
    // include $_SERVER['DOCUMENT_ROOT'].'/acme/view/login.php';
    exit;
  }
  // echo "THREE";
  // A valid password exists, proceed with the login process
  // Query the client data based on the email address
  $clientData = getClient($clientEmail);
  // Compare the password just submitted against
  // the hashed password for the matching client
  $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
  // If the hashes don't match create an error
  // and return to the login view
  if (!$hashCheck) {
    $message = '<p class="notice">Please check your password and try again.</p>';
    // include $_SERVER['DOCUMENT_ROOT'].'/acme/view/login.php';
    exit; 
  }

  // A valid user exists, log them in
  $_SESSION['loggedin'] = TRUE;
  // Remove the password from the array
  // the array_pop function removes the last
  // element from an array
  array_pop($clientData);
  //incase that doesn't work set this null
  // $clientData['clientPassword']
  // Store the array into the session
  $_SESSION['clientData'] = $clientData;
  // Send them to the admin view

  $reviews = getReviewsByClientId($_SESSION['clientData']['clientId']);
  if (!empty($reviews)) {
      $revDisplay = buildClientRevDisplay($reviews);
  }

  // include '/acme/view/admin.php';
  // include $_SERVER['DOCUMENT_ROOT'].'/acme/view/admin.php';
  header('Location: /acme/view/admin.php');
  exit;

  break;

  case 'registration':
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/registration.php';
    break;

  case 'register':
    // Filter and store the data
    $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING );
    $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING );
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING );
    
    //Validate email
    $clientEmail = checkEmail($clientEmail);
    //Validate password
    $checkPassword = checkPassword($clientPassword);

// Check for existing email address in the table
$existingEmail = checkExistingEmail($clientEmail);

if($existingEmail){
 $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
 include $_SERVER['DOCUMENT_ROOT'].'/acme/view/login.php';
 exit;
}

    //Send the data to the model
    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword);

    // Check for missing data
    if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
      $message = '<p>Please provide information for all empty form fields.</p>';
      include $_SERVER['DOCUMENT_ROOT'].'/acme/view/client-update.php';
      exit;
    }

    // Check and report the result
    if ($regOutcome === 1) {
      setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
      $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
      include $_SERVER['DOCUMENT_ROOT'].'/acme/view/login.php';
      exit;
    } else {
      $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
      include $_SERVER['DOCUMENT_ROOT'].'/acme/view/registration.php';
      exit;
    }
    break;

    

//a case statement that will deliver the client-update.php view
case 'clientUpdate':
  include $_SERVER['DOCUMENT_ROOT'].'/acme/view/client-update.php';
  break;

case 'updateAccount': 
  // Filter and store the data
  $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING );
  $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING );
  $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
  $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_EMAIL);

  //Validate email
  $clientEmailVerified = checkEmail($clientEmail);

  // CHeck if the email address submitted is different than the one in the session
  if ($clientEmail != $_SESSION['clientData']['clientEmail']) {
    // CHeck for existing email address in the table
    $existingEmail = checkEmail($clientEmail);
    if($existingEmail) {
      $_SESSION['message'] = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
      include $_SERVER['DOCUMENT_ROOT'].'/acme/view/client-update.php'; 
      exit;
  }
  }

  // Check for missing data
  if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
    $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/client-update.php'; 
    exit;
  }
 
  //Send the data to the model
  $updateOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

  // Check and report the result
  if($updateOutcome === 1) {
      $clientInfo = getClientById($clientId);
      array_pop($clientData);
      $_SESSION['clientData'] = $clientInfo;
      $_SESSION['message'] = "Successfully updated client information";
      header('location: /acme/accounts/');
      exit;
  } else {
      $_SESSION['message'] = "<p>Sorry $clientFirstname, but the update failed. Please try again.</p>";
      include $_SERVER['DOCUMENT_ROOT'].'/acme/view/client-update.php';
      exit; 
  }
  break;

// /=me = issentFirstname) && $clientFirstname != "" ? $clientFirstname : $clientData['clientFirstname'];


case 'updatePassword':
 // Filter and store the data
 $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING );
 $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_STRING );

 //Check password
 $checkPassword = checkPassword($clientPassword);

 // Hash the checked password
 $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

 if (empty($checkPassword)) {
  $_SESSION['message'] = '<p>Please check the password requirements.</p>';
  include $_SERVER['DOCUMENT_ROOT'].'/acme/view/client-update.php';
  exit;
}

 // Send data back to the model
 $updateOutcome = updatePassword($hashedPassword, $clientId);

 //Check and report the result
 if ($updateOutcome === 1) {
    $_SESSION['message'] = "Thanks for updating your password.";
    header('Location: /acme/accounts/');
    exit;
} else {
    $_SESSION['message'] = "<p>Sorry but the update of your password failed. Please try again.</p>";
    include $_SERVER['DOCUMENT_ROOT'].'/acme/view/client-update.php';
    exit;
}

 $clientData = getClient($clientPassword);
 // Compare the password just submitted against
 // the hashed password for the matching client
 $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
 // If the hashes don't match create an error
 // and return to the login view
 if (!$hashCheck) {
   $message = '<p class="notice">Please check your password and try again.</p>';
   include $_SERVER['DOCUMENT_ROOT'].'/acme/view/client-update.php';
   exit; 
 }

 break;

break;

case 'logout':
    session_destroy();
    include $_SERVER['DOCUMENT_ROOT'].'/acme/index.php';
    break;
   

  default:
  // include $_SERVER['DOCUMENT_ROOT'].'/acme/view/admin.php';

  if (isset($_SESSION['clientData'])){
    $reviews = getReviewsByClientId($_SESSION['clientData']['clientId']);
    if (!empty($reviews)) {
        $revDisplay = buildClientRevDisplay($reviews);
    }
}
include $_SERVER['DOCUMENT_ROOT'].'/acme/view/admin.php';
}
 


