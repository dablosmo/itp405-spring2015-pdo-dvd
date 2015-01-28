<link rel="stylesheet" type="text/css" href="bootstrap.css">

<?php 

if (!isset($_GET['title'])) { 
	header("Location: search.php");
}

$title = $_GET['title'];

?> 

<h3> 
You searched for '<?php echo $title ?>'
</h3>

<?php
$host = 'itp460.usc.edu'; 
$dbname = 'dvd'; 
$user = 'student'; 
$password = 'ttrojan'; 

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password); 

$sql = " 
	SELECT title, genre_name, format_name, rating_name 
	FROM dvds 
	INNER JOIN genres 
	ON dvds.genre_id = genres.id 
	INNER JOIN formats 
	ON formats.id = dvds.format_id 
	INNER JOIN ratings 
	ON ratings.id = dvds.rating_id
	WHERE title LIKE ?
";

$statement = $pdo->prepare($sql);
$like = '%' . $title . '%'; 
$statement->bindParam(1, $like);
$statement->execute(); 
$dvds = $statement->fetchAll(PDO::FETCH_OBJ); 
// var_dump($dvds); 

// foreach($songs as $song) { 
// 	echo "<div>" . $song['title'] . "</div>"; 
// 	echo "<br>"; 
// }

?> 

<?php 
	if(empty($dvds)) { 
		echo "No Results Found.";
?> 
		<form><input type = "button" value = "Back" 
		onclick ="history.go(-1);return true;"></form>

<?php 

	} 

foreach($dvds as $dvd) : ?> 
	<h3> 
		<?php echo $dvd->title ?> 
	</h3>
	<p> Genre: <?php echo $dvd->genre_name ?> </p>
	<p> Format:	<?php echo $dvd->format_name ?> </p>
	<p>	Rating: <a href="ratings.php?rating=<?php echo $dvd->rating_name ?>">
			<?php echo $dvd->rating_name ?></a> </p>
<?php endforeach ?> 