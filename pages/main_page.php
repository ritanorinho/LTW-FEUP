<?php

    include_once('../includes/session.php');
    include_once('../templates/common/tpl_footer.php');
    include_once('../templates/tpl_profile.php');
    include_once('../database/db_reviews.php');
    include_once('../database/db_user.php');
  
    // Verify if user is logged in
    if (!isset($_SESSION['username']))
    die(header('Location: login.php')); 


    $all_reviews=getAllReviews();
    foreach ($all_reviews as $k => $review){
        $all_reviews[$k]['MovieName'] = getMovieName($review['MovieID']);
        $all_reviews[$k]['UserName'] = getUsername($review['UserID']);
        $all_reviews[$k]['NumberComments']=getReviewsComments($review['ID'],$review['UserID']);
        
    }
    draw_reviews($all_reviews);
    draw_footer();
?>