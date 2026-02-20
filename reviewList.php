<?php require "templates/header.php"; 
      require "../config.php";
      require "../common.php";
?>
        



<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Top Reviews</h1>
    </div>

    <br><br>

    <form action="./movieInfo.php" id="addform" method="post"> 

        <table class="w3-table-all" style="width:100%">
        <tr>
        <th>Movie</th> <th>Review Score</th> <th>Review Count </th> 
        </tr>
        

        <?php    
            $pdo = new PDO($dsn, $username, $password, $options);
            $sql = "SELECT AVG(ALL rating.score) AS avgScore, COUNT(rating.movieID) AS totalReviews, movie.title FROM rating LEFT JOIN movie ON movie.movieID = rating.movieID GROUP BY movie.movieID ORDER BY movie.title ASC;";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$reviews = $stmt->fetchAll();

			foreach($reviews as $review):
				echo "<tr>";
				echo "<td>$review[title]</td>";
				echo "<td>$review[avgScore]</td>";
				echo "<td>$review[totalReviews]</td>";
				echo "</tr>";
			endforeach;

        ?>
        </table>
    </form>
</div>
</body>
</html>