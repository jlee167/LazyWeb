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


		<div style="margin:auto; width:100vw;height:100vh; margin-top:100px;">
            <form   action="/forum/general/post" enctype="multipart/form-data" method="POST"
                    style="margin:auto; margin-top:100px; width:60%;height:60%;">
                @csrf
                <select id="forum_name" name="type" style="padding-right:10px;
                    padding-left:10px; margin-left:15px; margin-top:auto;
                    margin-bottom:auto; height:40px; vertical-align:center;
                    border-radius: 5px 5px 5px 5px;
                    ">
                    <option value="general">General</option>
                    <option value="tech">Tech</option>
                </select>
                <input type="hidden" id="post_root" name="post_root" value="0">
                <input type="hidden" id="post_parent" name="post_parent" value="0">

				<label for="title" style="width:100%;">Title</label><br>
                <input type="text" id="title" name="title" style="width:100%; min-width:500px;"><br><br>

				<label for="content" style="width:100%">Content</label><br>
                <textarea id="summernote" name="content" style="width:100%; min-width:500px; height:60%;"></textarea><br>

				<input class="btn btn-primary" onclick="clickFunc();"  value="submit" style="float:right; margin-top:15px; width: 100px;">
			</form>
		</div>


		<script>
			$('#summernote').summernote({
				placeholder: 'content',
				tabsize: 2,
				height: 400,
                lineWrapping: true,
			});

            function clickFunc(){
                let csrf = "{{ csrf_token() }}";
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
                console.log(sendData);

                postRequest.send(JSON.stringify(sendData));
            }
		</script>


        @include('includes.layouts.footer')
        @include('includes.layouts.modal')
	</body>
<html>
