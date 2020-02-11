<?php

// This is my helper functions file. Do not confuse with themodel functions.

function checkEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

function buildNavigation($categories) { 
    // Build a navigation bar using the $categories array
    $navList = '<ul>';
    $navList .= "<li><a href='/acme/' title='View the Acme home page'>Home</a></li>";
    foreach ($categories as $category) {
    $navList .= "<li><a href='/acme/products/?action=category&categoryName=".urlencode($category['categoryName'])."' title='View our $category[categoryName] product line'> $category[categoryName] </a></li>";}
    $navList .= '</ul>';
    return $navList;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword) {
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

// Build the categories select list 
function buildCategoryList($categories){ 
    $catList = '<select name="categoryId" id="categoryList">'; 
    $catList .= "<option>Choose a Category</option>"; 
    foreach ($categories as $category) { 
     $catList .= "<option value='$category[categoryId]'>$category[categoryName]</option>"; 
    } 
    $catList .= '</select>'; 
    return $catList; 
   }

//    //original
// //will build a display of products within an unordered list
// function buildProductsDisplay($products){
//     $pd = '<ul id="prod-display">';
//     foreach ($products as $product) {
//      $pd .= '<li>';
//      $pd .= "<img src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'>";
//      $pd .= '<hr>';
//      $pd .= "<h2>$product[invName]</h2>";
//      $pd .= "<span>$product[invPrice]</span>";
//      $pd .= '</li>';
//     }
//     $pd .= '</ul>';
//     return $pd;
//    }

   //Altered for enhancement 8 #1
   //will build a display of products within an unordered list
//    Alter the buildProductsDisplay() function in the functions.php 
//    file to add a link(s) that, when clicked, sends two name-value pairs to the products controller.
function buildProductDisplay($productInfo){
    $pi = $productInfo;
    $dd = '<ul id="detail-display">';
     $dd .= '<li>';
     $dd .= '<img src="$pi[invImage]" alt="Image of our $pi[invName] product on Acme.com">';
     $dd .= '</li>';
     $dd .= '<li id="detail-desc">';
     $dd .= '<ul>';
     $dd .= '<li id="dtlDesc">$pi[invDescription]</li>';
     $dd .= '<li id="dtlVendor"> A $pi[invVendor] product</li>';
     $dd .= '<li id="dtlStyle"> Primary Material: $pi[invStyle]</li>';
     $dd .= '<li id="dtlWeight"> Product Weight: $pi[invWeight] lbs.</li>';
     $dd .= '<li id="dtlSize"> Shipping size: $pi[invSize] inches (w x l x h)</li>';
     $dd .= '<li id="dtlLocation"> Ships From: $pi[invLocation]</li>';
     $dd .= '<li id="dtlStock"> Number in Stock: $pi[invStock]</li>';
     $dd .= '<li id="dtlprice">$$pi[invPrice]</li>';
     $dd .= '</ul>';
     $dd .= '</li>';
     $dd .= '</ul>';
     return $dd;
   }

   function buildProdDetail($productInfo, $imageArray, $mainImg) {
    $prodDetail = "<div id='prod-img'><img src='";
    if (empty($mainImg)) { $prodDetail .= '$productInfo[imgPath]'; }
    else { $prodDetail .= '$mainImg[imgPath]'; }
    $prodDetail .= "'alt='Image of $productInfo[invName] on Acme.com' title='Image of $productInfo[invName]'><br><span id='thumbnails'>";
    foreach($imageArray as $image) {
            $prodDetail .= "<a href='/products?action=view-product&id=$productInfo[invId]&img=$image[imgId]'><img src='".makeThumbnailName($image['imgPath'])."' alt='$image[imgName]' title='$image[imgName]'></a>";
    }
    $prodDetail .= "</span></div>";
    $prodDetail .= "<div><h2>$productInfo[invName]</h2>";
    $prodDetail .= "<h3>By $productInfo[invVendor]</h3>";
    $prodDetail .= "<h2 class='highlight'>$productInfo[invStock] left in stock.</h2>";
    $prodDetail .= "<p>$productInfo[invDescription]</p>";
    $prodDetail .= "<ul><li>Size: $productInfo[invSize] in&sup3;</li>";
    $prodDetail .= "<li>Weight: $productInfo[invWeight] lbs</li>";
    $prodDetail .= "<li>Material: $productInfo[invStyle]</li></ul>";
    $prodDetail .= "<h2 class='highlight'>$$productInfo[invPrice]</h2>";
    $prodDetail .= "<h3>Ships from $productInfo[invLocation]</h3>";
    //$prodDetail .= "<input type='hidden' name='id' value='$product[invId]'>";
    //$prodDetail .= "<input type='submit' value='Add to Cart'>";
    $prodDetail .= "</div>";
    return $prodDetail;
}


   function buildProdRevDisplay($reviews) {
    $revDisplay = "<div><ul>";
    foreach($reviews as $review) {
            $revDisplay .= "<li><span class='review-name'>".substr($review['clientFirstname'],0,1).$review['clientLastname']."</span>";
            $revDisplay .= " - <span class='review-date'>".date('M n, Y', strtotime($review['reviewDate']))."</span>";
            $revDisplay .= "<p>\"$review[reviewText]\"</p></li>";
    }
    $revDisplay .= "</ul></div>";
    return $revDisplay;
}
function buildClientRevDisplay($reviews) {
    $revDisplay = "<div><ul>";
    foreach($reviews as $review) {
            $revDisplay .= "<li><span class='review-name'>".$review['invName']."</span>";
            $revDisplay .= " - <span class='review-date'>".date('M n, Y', strtotime($review['reviewDate']))."</span> ";
            $revDisplay .= "<a href='/acme/reviews?action=update-review&id=$review[reviewId]' title='Update your $review[invName] review'>Update</a> <a href='/acme/reviews?action=delete-review&id=$review[reviewId]' title='Delete your $review[invName] review'>Delete</a>";
            $revDisplay .= "<br>\"".substr($review['reviewText'],0,40);
            if (strlen($review['reviewText']) > 40) { $revDisplay .= " ..."; }
            $revDisplay .= "\"";
            $revDisplay .= "</li>";
    }
    $revDisplay .= "</ul></div>";
    return $revDisplay;
}


//Functions for working with images

function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
   }

 // Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img src='$image[imgPath]' title='$image[invName] image on Acme.com' alt='$image[invName] image on Acme.com'>";
     $id .= "<p><a href='/acme/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
     $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
   }

// Build the products select list
function buildProductsSelect($products) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Product</option>";
    foreach ($products as $product) {
     $prodList .= "<option value='$product[invId]'>$product[invName]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
   }

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
     // Gets the actual file name
     $filename = $_FILES[$name]['name'];
     if (empty($filename)) {
      return;
     }
    // Get the file from the temp folder on the server
    $source = $_FILES[$name]['tmp_name'];
    // Sets the new path - images folder in this directory
    $target = $image_dir_path . '/' . $filename;
    // Moves the file to the target folder
    move_uploaded_file($source, $target);
    // Send file for further processing
    processImage($image_dir_path, $filename);
    // Sets the path for the image for Database storage
    $filepath = $image_dir . '/' . $filename;
    // Returns the path where the file is stored
    return $filepath;
    }
   }

 // Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
   
    // Set up the image path
    $image_path = $dir . $filename;
   
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
   }


// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    // Set up the function names
    switch ($image_type) {
    case IMAGETYPE_JPEG:
     $image_from_file = 'imagecreatefromjpeg';
     $image_to_file = 'imagejpeg';
    break;
    case IMAGETYPE_GIF:
     $image_from_file = 'imagecreatefromgif';
     $image_to_file = 'imagegif';
    break;
    case IMAGETYPE_PNG:
     $image_from_file = 'imagecreatefrompng';
     $image_to_file = 'imagepng';
    break;
    default:
     return;
   } // ends the resizeImage function
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
     // Calculate height and width for the new image
     $ratio = max($width_ratio, $height_ratio);
     $new_height = round($old_height / $ratio);
     $new_width = round($old_width / $ratio);
   
     // Create the new image
     $new_image = imagecreatetruecolor($new_width, $new_height);
   
     // Set transparency according to image type
     if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
     }
   
     if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
     }
   
     // Copy old image to new image - this resizes the image
     $new_x = 0;
     $new_y = 0;
     $old_x = 0;
     $old_y = 0;
     imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
   
     // Write the new image to a new file
     $image_to_file($new_image, $new_image_path);
     // Free any memory associated with the new image
     imagedestroy($new_image);
     } else {
     // Write the old image to a new file
     $image_to_file($old_image, $new_image_path);
     }
     // Free any memory associated with the old image
     imagedestroy($old_image);
   } // ends the if - else began on line 36

?>
