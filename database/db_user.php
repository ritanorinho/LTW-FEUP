<?php
  include_once('../includes/database.php');
  /**
   * Verifies if a certain username, password combination
   * exists in the database. Use the sha1 hashing function.
   */
  function checkUserPassword($username, $password) {
    
    $db = Database::instance()->db();

    $hashed_password = hash('sha256', $password);
    $stmt = $db->prepare('SELECT * FROM User WHERE Username = ? AND Password = ?');
    $stmt->execute(array($username, $hashed_password));
    return $stmt->fetch()?true:false; // return true if a line exists
  }
  function checkEmail($email){
     
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT ID FROM User WHERE Email=?');
     $stmt->execute(array($email));

    $row = $stmt->fetch();
      $id= $row['ID'];
      if ($id==NULL)
        return 0;
      else return -1;
    
  }

  function checkUser($username){
     
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT ID FROM User WHERE Username=?');
     $stmt->execute(array($username));

    $row = $stmt->fetch();
      $id= $row['ID'];
      if ($id==NULL)
        return 0;
      else return -1;
    
  }
  function insertUser($firstName,$lastName,$username, $gender,$birthday,$country,$email, $password){
    checkEmail($email);
    $db = Database::instance()->db();
  
    $stmt = $db->prepare('INSERT INTO User(FirstName,LastName,Username,Gender,Birthday,Country,Email,Password,Photo,Points) VALUES (:FirstName,:LastName,:Username,:Gender,:Birthday,:Country,:Email,:Password,:Photo,:Points)');
    $stmt->bindParam(':FirstName', $firstName);
    $stmt->bindParam(':LastName', $lastName);
    $stmt->bindParam(':Username', $username);
    $stmt->bindParam(':Gender', $gender);
    $stmt->bindParam(':Birthday', $birthday);
    $stmt->bindParam(':Country', $country);
    $stmt->bindParam(':Email', $email);
    $stmt->bindParam(':Password', hash('sha256', $password)); 
    $photo = "../assets/default.jpg";
    $stmt->bindParam(':Photo', $photo);
    $points=0;
    $stmt->bindParam(':Points',$points); 

     
    if($stmt->execute()){
      $id = getID($username);
      return $id;
    }

  
  }

  function getID($username) {
    $db = Database::instance()->db();
    try {
      $stmt = $db->prepare('SELECT ID FROM User WHERE username = ?');
      $stmt->execute(array($username));
      if($row = $stmt->fetch()){
        return $row['ID'];
      }
    
    }catch(PDOException $e) {
      return -1;
    }
  }

  function getUsername($userID) {
    $db = Database::instance()->db();
    try {
      $stmt = $db->prepare('SELECT Username FROM User WHERE ID = ?');
      $stmt->execute(array($userID));
      if($row = $stmt->fetch()){
        return $row['Username'];
      }
    
    }catch(PDOException $e) {
      return -1;
    }
  }



  function getUserInfo($username) {
    
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
      $stmt->execute(array($username));
      return  $stmt->fetch();
  }

  function getUserFirstName($username) {
    
    $db = Database::instance()->db();
    try {
    $stmt = $db->prepare('SELECT FirstName FROM User WHERE username = ?');
    $stmt->execute(array($username));
    if($row = $stmt->fetch()){
      return $row['FirstName'];
    }
  
    }catch(PDOException $e) {
      return -1;
    }
  }

  function getUserBirthday($username) {
    
    $db = Database::instance()->db();
    try {
    $stmt = $db->prepare('SELECT Birthday FROM User WHERE username = ?');
    $stmt->execute(array($username));
    if($row = $stmt->fetch()){
      return $row['Birthday'];
    }
  
    }catch(PDOException $e) {
      return -1;
    }
  }


  function getUserReviews($username){
    

    $id=getID($username);
    $db = Database::instance()->db();
    $allReviews= $db->prepare('SELECT * FROM Review WHERE UserID = ?');
    $allReviews->execute(array($id));
    $reviews= $allReviews->fetchAll();
    return $reviews;

  }

  function deleteAccount($username){
       try {
    $db = Database::instance()->db();
    $stmt = $db->prepare('DELETE FROM User WHERE Username = ?');
    $stmt->execute(array($username));
    return true;
    }catch(PDOException $e) {
    return false;
  }
  }
  function getUserPhoto($username){

 
    $id=getID($username);
    $db = Database::instance()->db();
    $stmt= $db->prepare('SELECT Photo FROM User WHERE UserID = ?');
    $stmt->execute(array($id));
    
    return $stmt->fetch();

  }

  function updateUserInfo($id, $firstName, $lastName, $gender, $username, $country, $birthday, $email, $password){
   
    $db = Database::instance()->db();

    if ($password == NULL) {
      $stmt = $db->prepare('UPDATE User SET FirstName = ?, LastName = ?, Gender = ?, Country = ?, Birthday = ?, Username = ?, Email = ? WHERE ID = ? ');
      $stmt->execute(array($firstName, $lastName, $gender, $country, $birthday, $username, $email, $id));
    }else {
      $hashed_password = hash('sha256',$password);
      $stmt = $db->prepare('UPDATE User SET FirstName = ?, LastName = ?, Gender = ?, Country = ?, Birthday = ?, Username = ?, Email = ?, Password = ? WHERE ID = ? ');
      $stmt->execute(array($firstName, $lastName, $gender, $country, $birthday, $username, $email, $hashed_password, $id));
    }
   
   
    return $stmt->fetchAll();
  }

 
  function setUser($userID,$username){
    

  }

function incrementPoints($id){

  $db = Database::instance()->db();
  $stmt = $db->prepare('UPDATE User SET Points = 1 + Points WHERE ID = ?');
  $stmt->execute(array($id));
}

function decrementPoints($id){
  $db = Database::instance()->db();
  $stmt = $db->prepare('UPDATE User SET Points = Points - 1 WHERE ID = ?');
  $stmt->execute(array($id));
}

function getUserPoints($id){

    $db = Database::instance()->db();
    $stmt= $db->prepare('SELECT Points FROM User WHERE ID = ?');
    $stmt->execute(array($id));
    $row= $stmt->fetch();
    return $row['Points'];


}




?>