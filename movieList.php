<?php require "templates/header.php"; 
      require "../config.php";
      require "../common.php";
?>
        



<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Movie List</h1>
    </div>

    <br><br>

    <form action="./movieInfo.php" id="addform" method="post">

        <table class="w3-table-all" style="width:100%">
        <tr>
        <th>Title</th> <th>Rating</th> <th>Runtime</th> <th> Release Date </th> <th> Director </th>
        </tr>
        

        <?php    
            $pdo = new PDO($dsn, $username, $password, $options);
            $sql = "SELECT movie.movieID, movie.title, movie.mppaRating, movie.runtime, movie.releastDate , CONCAT(director.directFN, ' ', director.directLN) AS directName 
					FROM movie LEFT JOIN moviedirection ON moviedirection.movieID = movie.movieID LEFT JOIN director ON moviedirection.directorID = director.directorID 
					ORDER BY title ASC;";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$actors = $stmt->fetchAll();

			foreach($actors as $actor):
				echo "<tr>";
				echo "<td>$actor[title]</td>";
				echo "<td>$actor[mppaRating]</td>";
				echo "<td>$actor[runtime]</td>";
				echo "<td>$actor[releastDate]</td>";
				echo "<td>$actor[directName]</td>";
				echo "</tr>";
			endforeach;

        ?>
        </table>
    </form>
</div>
</body>
</html>