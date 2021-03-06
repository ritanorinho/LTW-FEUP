<?php

    include_once('../includes/session.php');
    include_once('../templates/common/tpl_header.php');
    include_once('../templates/tpl_edit_profile.php');
    include_once('../templates/common/tpl_nav_bar.php');
    include_once('../templates/common/tpl_footer.php');
    include_once('../database/db_user.php');
    include_once('../templates/tpl_countries.php'); 
    include_once('../database/db_movies.php');
    include_once('../database/db_reviews.php');
  
    // Verify if user is logged in
    if (!isset($_SESSION['username']) || !preg_match("/^[A-z0-9_-]{6,15}$/", $_SESSION['username']))
    die(header('Location: login.php')); 

   
    $user_info = getUserInfo($_SESSION['username']);
    $user_reviews=getUserReviews($_SESSION['username']);
    
    $allMovies=getAllMovies();
    $allReviews=getAllReviews();
    $allMoviesAndReviews = array('movies'=> $allMovies,'reviews'=>$allReviews);
  
    draw_edit_profile($user_info,$allMoviesAndReviews);
   

?>