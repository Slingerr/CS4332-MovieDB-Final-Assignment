<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
	require "../config.php";
    require "../common.php";
	
	$pdo = new PDO($dsn, $username, $password, $options);
	
	$sql = "SELECT genreID, genreName FROM genre";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$genres = $stmt->fetchAll();
?>

<?php require "templates/header.php"; ?>


<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Add New Movie</h1>
    </div>

    <br><br>

    <form action="./addMovie.php" id="addform" method="post">
        <label>Title</label>
        <input class="w3-input w3-border w3-round" type="text" name="title" form="addform">

        <br>


        <label>Release Date</label>
        <input class="w3-input w3-border w3-round" type="date" name="releastDate" form="addform">

        <br>
		
		<label>Runtime (Minutes)</label>
        <input class="w3-input w3-border w3-round" type="text" name="runtime" form="addform">

        <br>

        <label>MPAA Rating</label>
        <select class="w3-select w3-border" name="rating">
            <option value="" disabled selected>Choose Rating</option>
            <option value="G">G</option>
            <option value="PG">PG</option>
            <option value="PG-13">PG-13</option>
            <option value="PG13">PG-13</option>
            <option value="R">R</option>
            <option value="NC-17">NC-17</option>
        </select>


        <br><br>

        <label>Genre</label>
        <select class="w3-select w3-border" name="genre">
		    <option value="" disabled selected>Choose Genre</option>
			<?php foreach($genres as $genre): ?>
				<option value="<?= $genre['genreID']; ?>"><?= $genre['genreName']; ?></option>
			<?php endforeach; ?>
		</select>
		
		        <br><br>

        <label>Language</label>
        <select class="w3-select w3-border" name="lang">
            <option value="" disabled selected>Choose Language</option>
            <option value="English">English</option>
            <option value="French">French</option>
            <option value="Spanish">Spanish</option>
            <option value="German">German</option>
            <option value="Hindi">Hindi</option>
            <option value="Mandarin">Mandarin</option>
            <option value="Japanese">Japanese</option>
            <option value="Italian">Italian</option>
            <option value="Russian">Russian</option>
            <option value="Korean">Korean</option>
        </select>

	<input type="hidden" name="hide" value="1">

        <br><br>
        <input class="w3-btn w3-green" type="submit">
        <br><br>

    </form>
	
<?php
	if (isset($_POST['hide'])) {
		
	$local_title=$_POST['title'];
	$local_runtime=$_POST['runtime'];
	$local_releaseDate=$_POST['releastDate'];
	$local_rating=$_POST['rating'];
	$local_genre=$_POST['genre'];
	$local_language=$_POST['lang'];

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "title" => $local_title,
            "mppaRating"  => $local_rating,
            "runtime"     => $local_runtime,
            "releastDate"       => $local_releaseDate,
            "language"  => $local_language
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "movie",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
		
		$last_id = $connection->lastInsertID();
		$new_genre = [
			"movieID" => $last_id,
			"genreID" => $_POST['genre']
		];
		
		$sql = "INSERT INTO moviegenre (movieID, genreID) VALUES (:movieID, :genreID)";
        $stmt= $pdo->prepare($sql);
		$stmt->execute($new_genre);
		
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
	
	   echo $local_title . " was successfully added!";
}
?>
</div>
</body>
</html>