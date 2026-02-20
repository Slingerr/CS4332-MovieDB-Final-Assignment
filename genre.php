<?php require "templates/header.php"; 
      require "../config.php";
      require "../common.php";
?>
        



<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Genre Information</h1>
    </div>

    <br><br>

    <form action="./movieInfo.php" id="addform" method="post">

        <table class="w3-table-all" style="width:100%">
        <tr>
        <th>Genre</th> <th> Movies </th> <th>Description</th> 
        </tr>
        

        <?php    
            $pdo = new PDO($dsn, $username, $password, $options);
            $sql = "SELECT genre.genreName, genre.genreDescription, COUNT(moviegenre.movieID) AS numMovies 
			FROM genre LEFT JOIN moviegenre ON moviegenre.genreID = genre.genreID 
			GROUP BY genre.genreID ORDER BY genreName ASC;";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$genres = $stmt->fetchAll();

			foreach($genres as $genre):
				echo "<tr>";
				echo "<td>$genre[genreName]</td>";
				echo "<td>$genre[numMovies]</td>";
				echo "<td>$genre[genreDescription]</td>";
				echo "</tr>";
			endforeach;

        ?>
        </table>
    </form>
</div>
</body>
</html>