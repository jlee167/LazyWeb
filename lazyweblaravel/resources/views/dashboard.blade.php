<?php
	use Illuminate\Support\Facades\Log;

	// TODO: Credentials moved out of php file
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LazyboyServer";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if (mysqli_connect_error()) {
		die("Database connection failed: " . mysqli_connect_error());
		$dbg_msg="Connection Failed";
	}
	else if ($conn){
		$dbg_msg="Connected successfully";
	}
?>


<html>
	<head>
        @include('includes.imports.styles_common')
	</head>

	<body>
        @include('includes.layouts.navbar')

		<script src="/js/cookie_handler.js"></script>
		<script src="/js/login_handler.js"></script>
		<script>
			var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>

		<div class="container-fluid" style="width:70%; padding-top:100px;">
			<h1 style="text-align:center; margin-top:30px;">Shitposting Time</h1>
			<div style="margin-bottom:10px;">
				<table style="width:100%;">
					<tr>
						<td style="width:33%;"> <p></p></td>
						<td style="width:33%; text-align:center;"></td>
						<td style="width:33%;"><a id="postBtn"class="btn btn-primary" href="createpost" role="button" style="text-align:center; width:70px; height:40px; float:right; margin:0 auto; margin-bottom:10px;" > Write	</a></td>
					</tr>
				</table>
			</div>

			<script src="js/cookie_handler.js"></script>
			<script>
					var authProvider = getCookie('Authenticator');
					if (!authProvider) {
						document.getElementById('postBtn').href = 'login';
					}
			</script>

			<table class="table table-striped" style="margin:auto; text-align:center;">
				<thead>
					<tr>
						<th style="width:10%;">No#</th>
						<th style="width:50%;">Title</th>
						<th style="width:20%;">Author</th>
						<th style="width:20%;">Date</th>
						<th style="width:10%;">Views</th>
					</tr>
				</thead>

				<tbody id= "table_obj">

				<?php
					$sql = "use LazyboyServer";
					$result0 = mysqli_query($conn, $sql);

					$num_rows_query = "SELECT COUNT(*) as post_count FROM mainboard";
					$result = mysqli_query($conn, $num_rows_query);
					$result = mysqli_fetch_assoc($result);
					$num_rows = $result["post_count"];
					$num_pages = intval($num_rows/10) + 1;


					$query = $_SERVER['QUERY_STRING'];

					if (empty($query)) {
						$curr_page = 1;
					}
					else{
						if ($query > $num_pages)
								$curr_page = $num_pages;
						else if ($query < 1)
								$curr_page = 1;
						else
							$curr_page = $query;
					}
					$lower_limit = strval(($curr_page-1) * 10);
					$upper_limit = strval($curr_page + 9);
					$sql = "SELECT * FROM mainboard ORDER BY no DESC LIMIT " . $lower_limit . ','  . $upper_limit;
					$result = mysqli_query($conn, $sql);

					$table_posts = "";
					if (mysqli_num_rows($result) > 0)
					{
						while($row = mysqli_fetch_assoc($result))
						{
								$table_posts =  $table_posts . "<tr><td style='width:10%;'>" . $row["no"]  .  "</td><td style='width:50%;'>" .  $row["title"]  .  "</td><td style='width:20%;'>" .
																					$row["author"]  .  "</td><td style='width:20%;'>" .  $row["date"]  .  "</td><td style='width:10%;'>" . $row["hit_cnt"]  . "</td></tr>";
						}
					}
					echo $table_posts;
				?>
				</tbody>
			</table>

			<nav aria-label="Page navigation example" style="margin:auto; margin-top:20px;">
				<ul class="pagination justify-content-center">
					<li class="page-item"><a class="page-link" href="dashboard?<?php echo $curr_page-1; ?>">Previous</a></li>
						<?php
							Log::alert($query);
							Log::alert($num_pages);
							if (($query+4) > $num_pages)
								$page_ceiling = $num_pages;
							else
								$page_ceiling = $query+4;

							for ($x = $page_ceiling - 9; $x <= $page_ceiling; $x++) {
								if ($x > 0) {
									echo '<li class="page-item"><a class="page-link" href="dashboard?' . $x .  '"> ';
									echo $x;
									echo '</a></li>';
								}
							}
						?>
					<li class="page-item"><a class="page-link" href="dashboard?<?php echo $curr_page+1?>">Next</a></li>
				</ul>
			</nav>
		</div>

	</body>
</html>
