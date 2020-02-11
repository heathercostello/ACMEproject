<?php
//Reviews Model

//Function to get reviews for a specific inventory item
function getReviewsByInvId($invId) {
    $db = acmeConnect();
    $sql = 'SELECT * FROM reviews AS r INNER JOIN clients AS c ON r.clientId = c.clientId WHERE r.invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}

//Function to get reviews written by a specific client
function getReviewsByClientId($clientId) {
    $db = acmeConnect();
    $sql = 'SELECT * FROM reviews AS r INNER JOIN inventory AS i ON r.invId = i.invId WHERE r.clientId = :clientId';
    // ORDER BY reviewUpdateDate DESC'
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}


//Function to get a specific review
function getReviewById($reviewId) {
    $db = acmeConnect();
    $sql = 'SELECT * FROM reviews AS r INNER JOIN inventory AS i ON r.invId = i.invId WHERE r.reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $review;
}

//Insert a review function
function newReview($invId, $clientId, $reviewText) {
    $db = acmeConnect();
    $sql = 'INSERT INTO reviews (invId, clientId, reviewText) VALUES (:invId, :clientId, :reviewText)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

//Function to update a specific review
function updateReview($reviewText, $reviewId) {
    $db = acmeConnect();
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
  }


//Function to delete a specific review
function deleteReview($reviewId) {
    $db = acmeConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

