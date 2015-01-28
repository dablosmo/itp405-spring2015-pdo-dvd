<link rel="stylesheet" type="text/css" href="bootstrap.css">

<?php 

$rating = $_GET['rating']; 

?>

<h3>
<?php echo "Movies that are rated " . $rating; ?>
</h3>

<?php

$host = 'itp460.usc.edu'; 
$dbname = 'dvd'; 
$user = 'student'; 
$password = 'ttrojan'; 

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password); 

$sql = " 
	SELECT title, rating_name 
	FROM dvds  
	INNER JOIN ratings 
	ON ratings.id = dvds.rating_id
	WHERE ratings.rating_name = ?
";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_OBJ);

foreach($results as $result) : ?> 
	<div> 
		<?php echo $result->title ?> 
	</div>
<?php endforeach ?> 

