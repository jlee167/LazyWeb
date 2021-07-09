<html>
	<head>
		<meta charset="utf-8">
        @include('includes.imports.csrf')
        @include('includes.imports.styles_common')

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>

        <style>
            .background-createpost{
                background-color:#d6eaf8;
                margin:0;
                overflow-x: hidden;
            }

            .form-container {
                margin:auto;
                width:100vw;
                height:100vh;
                margin-top:100px;
            }

            .forum-select {
                padding-right:10px;
                padding-left:10px;
                margin-top:auto;
                margin-bottom:20px;
                height:30px;
                vertical-align:center;
                border-radius: 5px 5px 5px 5px;
            }

            .create-post-form {
                margin:auto;
                margin-top:100px;
                width:60%;
                height:60%;
            }

            .create-post-input {
                width:100%;
                min-width:300px;
            }

            .create-post-btn {
                float:right;
                margin-top:15px;
                margin-bottom:50px;
                width: 100px;
            }

            .content-label {
                font-family: 'Oswald', sans-serif;
                font-weight: bold;
                font-size:20;
            }
        </style>
	</head>

	<body class="background-createpost">
        @include('includes.layouts.navbar')

		<div class="form-container">
            <form class="create-post-form" action="/forum/general/post" enctype="multipart/form-data" method="POST">
                @csrf
                <label class="content-label w-100">Forum</label><br>
                <select id="forum_name" name="type"  class="forum-select">
                    <option value="general">General</option>
                    <option value="tech">Tech</option>
                </select>
                <input type="hidden" id="post_root" name="post_root" value="0">
                <input type="hidden" id="post_parent" name="post_parent" value="0">

				<label class="content-label w-100" for="title">Title</label><br>
                <input class="create-post-input" type="text" id="title" name="title"><br><br>

				<label class="content-label w-100" for="content">Content</label><br>
                <textarea class="create-post-input" id="summernote" name="content" style="height:60%;"></textarea><br>

				<input class="btn btn-primary create-post-btn" onclick="submitPost();"  value="submit">
			</form>
		</div>


		<script>
			$('#summernote').summernote({
				placeholder: 'content',
				tabsize: 2,
				height: 400,
                lineWrapping: true,
			});

            function submitPost(){
                var postRequest = new XMLHttpRequest();
                var forum_name = document.getElementById('forum_name').value;
                postRequest.open('POST', '/forum/' + forum_name + '/post');
                postRequest.setRequestHeader('Content-Type', 'application/json');
                postRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
                postRequest.onload = function(){
                    window.location.href = "http://www.lazyweb.com/views/dashboard?page=1";
                };

                var sendData = {
                    title: document.getElementById('title').value,
                    forum: 'general',
                    content: $('#summernote').summernote('code')
                };

                postRequest.send(JSON.stringify(sendData));
            }
		</script>


        @include('includes.layouts.footer')
	</body>
<html>
