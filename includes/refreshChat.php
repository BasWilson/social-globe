
<?php
    require 'config.php';

    $query = 'SELECT name, message FROM global_chat ORDER BY timestamp';

    $result = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_array($result)) 
    {
            
            echo '<p class="chat-message"><strong>'.$row['name'].': </strong> <xmp>'.$row['message'].'</xmp></p>';
    }
?>