<?php

include_once('../includes/database.php');

/* Function that returns all reviews from a certain user. */

/*function getUserReviews($username){
    try{

        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Review WHERE username = ?');
        $stmt->execute(array($username));

        return $stmt->fetchAll(); 
    } catch(PDOException $e) {
        return null;
      }
}*/

/* Inserting a film review of a user */

function insertReview($title, $username, $movieid, $reviewdate, $heart, $dislike, $description){
    try{

        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO Review(Title, UserID, MovieID, ReviewDate, Heart, Dislike, Description) VALUES(:Title, :UserID, :MovieID, :ReviewDate, :Heart, :Dislike, :Description)');
        $stmt->bindParam(':Title', $title);
        /*usar o id ou o username?*/
        $stmt->bindParam(':UserID', $username);
        $stmt->bindParam(':MovieID', $movieid);
        $stmt->bindParam(':ReviewDate', $reviewdate);
        $stmt->bindParam(':Heart', $heart);
        $stmt->bindParam(':Dislike', $dislike);
        $stmt->bindParam(':Description', $description);
      
        if($stmt->execute()){
            $id = getID($username);
            return $id;
        }else return -1;
        } catch(PDOException $e) {
            return null;
        }
}

/* Get all items of a certain review */

function getReviewItems($reviewId){
    try{
   
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Review WHERE ID = ?');
        $stmt->execute(array($reviewId));
        
        return $stmt->fetchAll(); 

    } catch(PDOException $e) {
        return null;
      }
}

/* Deletes a review */

function deleteReview($reviewId){
    try{
    
        $db = Database::instance()->db();
        $stmt = $db->prepare('DELETE FROM Review WHERE ID = ?');
        $stmt->execute(array($username));
        return true;
    }catch(PDOException $e) {
        return false;
    }
}

function getMovieName($movieId){
    try{
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT Name FROM Movie WHERE ID = ?');
        $stmt->execute(array($movieId));
        $row= $stmt->fetch();
        $movieName=$row['Name'];
        return $movieName;

    }catch(PDOException $e) {
        return -1;
    }
}

function getReviewsComments($reviewId,$userId){
    try{
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ID FROM Comment WHERE ReviewID = ? AND UserID = ?');
        $stmt->execute(array($reviewId,$userId));
        $row= $stmt->fetch();
       
        $numberComments= count($row);
        return $numberComments;

    }catch(PDOException $e) {
        return -1;
    }
}

function getAllReviews(){
    try{
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Review ORDER BY ReviewDate DESC');
        $stmt->execute();
        $allReviews= $stmt->fetchAll();
        return $allReviews;

    }catch(PDOException $e) {
        return -1;
    }
}

function getAllReviewsMovie($movieId){
    try{
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM Review WHERE MovieID = ?');
        $stmt->execute(array($movieId));
        $allReviews= $stmt->fetchAll();
        return $allReviews;

    }catch(PDOException $e) {
        return -1;
    }
}

function getLikesReview($reviewId){

    try{
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT UserID FROM LikeReview  WHERE ReviewID = ?');
        $stmt->execute(array($reviewId));
        $allLikes= $stmt->fetch();
        return count($allLikes);

    }catch(PDOException $e) {
        return -1;
    }

}

function getDisLikesReview($reviewId){

    try{
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT UserID FROM LikeReview  WHERE ReviewID = ?');
        $stmt->execute(array($reviewId));
        $allDisLikes= $stmt->fetch();
        return count($allDisLikes);

    }catch(PDOException $e) {
        return -1;
    }

}
























?>