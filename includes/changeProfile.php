<?php  if (isset($_POST['submit']))
{

$id = $_SESSION['id'];

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'] ;



//Maak de query:

 $query = "UPDATE users
SET  first_name = '$first_name', last_name = '$last_name' WHERE id = $id";



//Als de odpracht goed wordt uitgevoerd:
 if (mysqli_query($mysqli, $query))
 {
echo true;
}
//Anders:
else{
echo false;
}
}
else
{
echo "<p>Geen gegevens ontvangen...</p>";
}

echo "<p><a href='../index.php'>TERUG</a> naar overzicht</p>"; ?>
<?
