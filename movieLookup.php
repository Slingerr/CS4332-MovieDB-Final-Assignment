<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */
	require "../config.php";
    require "../common.php";

    $pdo = new PDO($dsn, $username, $password, $options);



	$sql = "SELECT movieID, title FROM movie";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$movies = $stmt->fetchAll();
?>

<?php require "templates/header.php"; ?>

<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Find Movie based on title</h1>
    </div>
	
	<br><br>

    <form action="./movieLookup.php" id="addform" method="post">
	
	<label for="title"> Movie </label>
	<select class="w3-select w3-border" name="title">
	 <?php foreach($movies as $movie): ?>
			<option value="<?= $movie['title']; ?>"><?= $movie['title']; ?></option>
	 <?php endforeach; ?>
	 </select>
	 
    <input type="hidden" name="hide" value="1">

        <br><br>
        <input class="w3-btn w3-green" type="submit">
        <br><br>

    </form>
	
<?php
if (isset($_POST['hide'])) {
    try  {
        
		

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT movie.title, movie.mppaRating, movie.runtime, movie.releastDate, movie.language,  genre.genreName, CONCAT(director.directFN, ' ', director.directLN) AS directName
                        FROM movie LEFT JOIN moviegenre ON moviegenre.movieID = movie.movieID LEFT JOIN genre ON moviegenre.genreID = genre.genreID LEFT JOIN moviedirection ON moviedirection.movieID = movie.movieID LEFT JOIN director ON moviedirection.directorID = director.directorID
                        WHERE title = :title";

        $title = $_POST['title'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
	
<?php  
if (isset($_POST['hide'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table class="w3-table-all" style="width:100%">
            <thead>
                <tr>
                    <th>Title</th>
					<th>Director</th>
					<th>Genre</th>
                    <th>Rating</th>
                    <th>Runtime</th>
                    <th>Release Date</th>
                    <th>Language</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["title"]); ?></td>
				<td><?php echo escape($row["directName"]); ?></td>
				<td><?php echo escape($row["genreName"]); ?></td>
                <td><?php echo escape($row["mppaRating"]); ?></td>
                <td><?php echo escape($row["runtime"]); ?></td>
                <td><?php echo escape($row["releastDate"]); ?></td>
                <td><?php echo escape($row["language"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
	<br>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['title']); ?>.</blockquote>
    <?php } 
} ?> 
</div>
</body>
