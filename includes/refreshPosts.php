
<?php
    require 'config.php';

    //$sortBy = $_POST['sortBy']; // de waarde van de dropdown menu via ajax binnen gekregen

    $query = 'SELECT * FROM posts ORDER BY post_time DESC'; // haal de nieuwe lijst binnen maar gesoorteerd zoals aangebraagd

    $result = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_array($result)) 
    {
             echo "<div style='background-color:". $row['color'] . " 'class='postDiv'><div class='postHeader'><img src=".'profile_pics/' . $row['profile_pic'] . " /><strong><p><xmp>".$row['name']."</xmp></p></strong></div> <p><xmp>" . $row['post'] . "</xmp></p><div class='like-container'><a onclick='likePost(this.id)'class='like-button' id'" . $row['post_id'] . "'><span>Liked by 10 other people</span></a></div><p></p><p>Posted on " . $row['post_time'] . "</p></div>";
    }
?>