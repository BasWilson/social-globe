
<?php
    require 'config.php';

    $sortBy = $_POST['sortBy']; // de waarde van de dropdown menu via ajax binnen gekregen

    $query = 'SELECT * FROM mphp4_leden ORDER BY ' . $sortBy . ''; // haal de nieuwe lijst binnen maar gesoorteerd zoals aangebraagd

    $result = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_array($result)) 
    {
        // laat de nieuwe lijst zien door naar ajax te sturen zodat we zonder de pagina te hoeven verversen het kunnen laten zien
        echo "<tr><td>" . $row['id'] . "</td><td class='first-name'>" . $row['first_name'] . "</td><td class='last-name'>" . $row['last_name'] . "</td><td class='birth-date'>" . $row['birth_date'] . "</td><td class='gender'>" . $row['gender'] . "</td><td class='member-since'>" . $row['member_since'] . '</td> <td><button onclick="EditUser(this.id)" id='.$row['id'].' class="btn btn-primary" type="button">Edit</button></td> <td><button onclick="DeleteUser(this.id)" id='.$row['id'].' style="background-color: red; border-color: red" class="btn btn-primary" type="button">Delete</button>  </td><td><span style="cursor: pointer" id='.$row['id'].' onclick="OpenImageUpload(this.id)"><img id='.$row['id']. "img" . ' src="profile_pics/'.$row['image_url'].'" style="width: 45px; height: 45px; border-radius: 6px" /></span></td> <tr>';
    }
?>