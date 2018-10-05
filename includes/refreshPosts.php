
<?php
    require 'config.php';

    //$sortBy = $_POST['sortBy']; // de waarde van de dropdown menu via ajax binnen gekregen

    $query = 'SELECT * FROM posts ORDER BY post_time DESC';

    $result = mysqli_query($mysqli, $query);




    while ($row = mysqli_fetch_array($result))
    {
      $username = $row['username'];
      $query2 = "SELECT profile_pic, username FROM users WHERE username = '$username'";
      $result2 = mysqli_query($mysqli, $query2);
      if ($row2 = mysqli_fetch_array($result2)) {
        $name = $row2['username'];
        $likes = "";
        if ($row['likes'] == 1) {
            $likes = $row['likes'] . " like";
        } else {
            $likes = $row['likes'] . " likes";
        }
             echo "<div style='background-color:". $row['color'] . " 'class='postDiv'><div class='postHeader'><img src=".'profile_pics/' . $row2['profile_pic'] . " /><strong><p><xmp>".$name."</xmp></p></strong></div> <p><xmp>" . $row['post'] . "</xmp></p><div class='like-container'><a onclick='LikePost(this.id)'class='like-button' id='" . $row['post_id'] . "'><span></span><p><strong>❤️ <span id='likes" . $row['post_id'] . "'>" . $likes . "</span></strong></p></a></div><p>Posted on " . $row['post_time'] . "</p></div>";
      } else {
        echo "rip query";
      }

    }



?>
