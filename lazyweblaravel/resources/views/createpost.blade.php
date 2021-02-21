<!doctype html>

<?php
    use Illuminate\Support\Facades\Log;
    use App\Models\DB_Forum;
    use App\Models\DB_User;
    use App\Http\Controllers\ForumController;
?>


<html>
	<head>
		<meta charset="utf-8">
        @include('includes.imports.styles_common')

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
	</head>

	<body style="background-color:#d6eaf8; margin:0; overflow:auto;">
        @include('includes.layouts.navbar')

		<script src="js/cookie_handler.js"></script>
		<script src="js/login_handler.js"></script>
		<script>
			var authenticator = getCookie('Authenticator');
			var username = getCookie('Username');
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>


		<div style="margin:auto; width:100vw;height:100vh; margin-top:100px;">
            <form action="/forum/general/post" enctype="multipart/form-data" method="POST" style="margin:auto; margin-top:100px; width:60%;height:60%;">
                @csrf
                <input type="hidden" id="post_root" name="post_root" value="0">
                <input type="hidden" id="post_parent" name="post_parent" value="0">

				<label for="title" style="width:100%;">Title</label><br>
                <input type="text" id="title" name="title" style="width:100%; min-width:500px;"><br><br>

				<label for="content" style="width:100%">Content</label><br>
                <textarea id="summernote" name="content" style="width:100%; min-width:500px; height:60%;"></textarea><br>

				<input class="btn btn-primary" type="submit" value="submit" style="float:right; margin-top:15px; width: 100px;">
			</form>
		</div>


		<script>
			$('#summernote').summernote({
				placeholder: 'content',
				tabsize: 2,
				height: 400
			});
		</script>

		<script src="js/cookie_handler.js"></script>
		<script>
			var googleToken = getCookie('AccessToken' );
			document.getElementById('postToken').value=googleToken;
			console.log(googleToken);
		</script>


        @include('includes.layouts.footer')
	</body>
<html>
