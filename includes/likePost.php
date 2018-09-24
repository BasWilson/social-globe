<?php

  include 'log.php';  

  $post_id = $_POST['likeId'];
  $email = $_SESSION['email'];
  $name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];

if(isset($post_id) || isset($email) || isset($name)) {
  //Alle data is er
  AddLike($post_id, $email, $name);
} else {
  echo "not set";
}

function AddLike($post_id, $email, $name) {

  require 'config.php';

  $query = "UPDATE posts SET likes = likes + 1 WHERE post_id = $post_id";

  if (mysqli_query($mysqli, $query)) {
    
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
