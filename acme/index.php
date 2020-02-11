<?php

// Create or access a Session 
session_start();

 // Get the database connection file
require_once 'library/connection.php';
// Get the acme model for use as needed
require_once 'model/acme-model.php';
// Get the acme model for use as needed
require_once 'library/functions.php';

// Get the array of categories
$categories = getCategories();

$navList = buildNavigation($categories);

// echo $_SESSION['clientData'];

// // Check if the firstname cookie exists, get its value
// if(isset($_COOKIE['firstname'])){
//   $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
//  }

$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }
 
switch ($action){
  case 'something':
   
   break;

   case 'home':
   include $_SERVER['DOCUMENT_ROOT'] . '/acme/view/home.php';
  break;

  case 'login':
   include $_SERVER['DOCUMENT_ROOT'] . '/acme/view/login.php';
  break;

  default:
   include 'view/home.php';
 }









