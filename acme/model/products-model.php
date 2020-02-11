<?php
//Products Model

function newCategory($categoryName){
    // Create a connection object using the acme connection function
    $db = acmeConnect();
    // The SQL statement
    $sql = 'INSERT INTO categories (categoryName)
        VALUES (:categoryName)';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   }

//Insert inventory item to database
function addProduct($categoryId, $invName, $invDescription, $invImg, $invThumb, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $invVendor, $invStyle) {
//Create a connection
$db = acmeConnect();
//The SQL statement to be used with the database
$sql = 'INSERT INTO inventory (invName, invDescription, invImage, invThumbnail, invPrice, invStock, invSize, invWeight, invLocation, categoryId, invVendor, invStyle)'
        . 'VALUES (:invName, :invDescription, :invImg, :invThumb, :invPrice, :invStock, :invSize, :invWeight, :invLocation, :categoryId, :invVendor, :invStyle)';
// Create the prepared statement using the acme connection
$stmt = $db->prepare($sql);
// The next lines replace the placeholders in the SQL
// statement with the actual values in the variables
// and tells the database the type of data it is
$stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
$stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
$stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
$stmt->bindValue(':invImg', $invImg, PDO::PARAM_STR);
$stmt->bindValue(':invThumb', $invThumb, PDO::PARAM_STR);
$stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
$stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
$stmt->bindValue(':invSize', $invSize, PDO::PARAM_INT);
$stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
$stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
$stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
$stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
// Insert the data
$stmt->execute();
// Ask how many rows changed as a result of our insert
$rowsChanged = $stmt->rowCount();
// Close the database interaction
$stmt->closeCursor();
// Return the indication of success (rows changed)
return $rowsChanged;
}

// Get products by categoryId 
function getProductsByCategory($categoryId){ 
    $db = acmeConnect(); 
    $sql = ' SELECT * FROM inventory WHERE categoryId = :categoryId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $products; 
   }

   // Get product information by invId<>
function getProductInfo($invId){
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
   }

   // Update a product
function updateProduct($catType, $invName, $invDescription, 
$invImg, $invThumb, $invPrice, $invStock, $invSize, $invWeight,
 $invLocation, $invVendor, $invStyle, $invId) {
 // Create a connection
 $db = acmeConnect();
 // The SQL statement to be used with the database
 $sql = 'UPDATE inventory SET invName = :invName, 
  invDescription = :invDescription, invImage = :invImg, 
  invThumbnail = :invThumb, invPrice = :invPrice, 
  invStock = :invStock, invSize = :invSize, 
  invWeight = :invWeight, invLocation = :invLocation, 
  categoryId = :catType, invVendor = :invVendor, 
  invStyle = :invStyle WHERE invId = :invId';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':catType', $catType, PDO::PARAM_INT);
 $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
 $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
 $stmt->bindValue(':invImg', $invImg, PDO::PARAM_STR);
 $stmt->bindValue(':invThumb', $invThumb, PDO::PARAM_STR);
 $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
 $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
 $stmt->bindValue(':invSize', $invSize, PDO::PARAM_INT);
 $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
 $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
 $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
 $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
 $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
 $stmt->execute();
 $rowsChanged = $stmt->rowCount();
 $stmt->closeCursor();
 return $rowsChanged;
}

function deleteProduct($invId) {
    $db = acmeConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }

   //get a list of products based on the category
function getProductsByCategoryName($categoryName){
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :categoryName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
   }

   function getProductBasics() {
    $db = acmeConnect();
    $sql = 'SELECT invName, invId FROM inventory ORDER BY invName ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}



