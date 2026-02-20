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

if (isset($_POST['hide'])) {
    try  {
        


        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT CONCAT(a.actFN, ' ', a.actLN) AS actName, b.title, c.role 
                        FROM actor a, movie b, moviecast c 
                        WHERE c.movieID = :movieID AND c.actorID = a.actorID AND c.movieID = b.movieID";

        $movieID = $_POST['movieID'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':movieID', $movieID, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>


<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Select a movie to look up a cast</h1>
    </div>
	
	<br><br>

    <form action="./cast.php" id="addform" method="post">
	
	<label for="movieID"> Movie </label>
	<select class="w3-select w3-border" name="movieID">
    <option value="" disabled selected>Choose Movie</option>
	 <?php foreach($movies as $movie): ?>
			<option value="<?= $movie['movieID']; ?>"><?= $movie['title']; ?></option>
	 <?php endforeach; ?>
	 </select>
	 
    <input type="hidden" name="hide" value="1">

        <br><br>
        <input class="w3-btn w3-green" type="submit">
        <br><br>

    </form>
        
<?php  
if (isset($_POST['hide'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table class="w3-table-all" style="width:100%">
            <thead>
                <tr>
                    <th>Actor</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["actName"]); ?></td>
                <td><?php echo escape($row["role"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
	<br>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['movieID']); ?>.</blockquote>
    <?php } 
} ?> 