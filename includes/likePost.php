<?php

  include 'log.php';  
  session_start();
  $post_id = $_POST['likeId'];
  $user_id = $_SESSION['id'];
  $username = $_SESSION['username'];
  $name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
  $query = "";
if(isset($post_id) || isset($username) || isset($name) || isset($user_id)) {
  //Alle data is er
  AddLike($post_id, $username, $name, $user_id);
} else {
  echo "not set";
}

function AddLike($post_id, $username, $name, $user_id) {

  require 'config.php';

  $query4 = "SELECT * FROM posts_likes WHERE post_id = $post_id AND user_id = $user_id";

  $result4 = mysqli_query($mysqli, $query4);

  if ($row4 = mysqli_fetch_array($result4)) {
    //Dont allow the like
    echo 2;
  } else {
    //Allow like
    $query = "UPDATE posts SET likes = likes + 1 WHERE post_id = $post_id";

    $query3 = "INSERT INTO posts_likes VALUES ($post_id, $user_id)";
  
    if (mysqli_query($mysqli, $query) && mysqli_query($mysqli, $query3)) {
      
      $query2 = "SELECT likes FROM posts WHERE post_id = $post_id";
  
      $result = mysqli_query($mysqli, $query2);
  
      if ($row = mysqli_fetch_array($result)) {
        echo $row['likes'];
      } else {
        echo false;
      }
    } else {
      echo "Could not find this post.";
  
        echo false;
      }
  }


}
