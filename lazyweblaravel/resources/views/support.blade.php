<!doctype html>


<html>
	<head>
		@include('includes.imports.styles_common')

		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
	</head>

	<body>
		<script src="/js/auth_helper.js"></script>
		<script>
			var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>

        @include('includes.layouts.navbar')

        <div class="section-contents" style="height:70%;">
            <form action="/support_request" enctype="multipart/form-data" method="POST" style="margin:auto; margin-top:10vh; width:60%;height:80vh; margin-bottom:100px;">
                @csrf
				<input type="hidden" id="postToken" name="postToken">

				<label style="width:100%;">What do you need support with? </label><br>
				<select id="type" name="type" style="margin-bottom:40px;">
                    <option value="REPAIR">Repair</option>
                    <option value="TECH_SUPPORT">Tech Support</option>
                    <option value="REFUND">Refund</option>
                    <option value="LEGAL">Legal</option>
                </select>

				<label for="contents" style="width:100%">State Your Issues</label><br>
				<textarea id="summernote" name="contents" style="width:100%; min-width:500px; height:60%;"></textarea><br>
				<input class="btn btn-primary" type="button" value="submit" onclick="submit_request();" style="float:right; margin-top:15px; margin-bottom:50px; width: 100px;">
            </form>

            @include('includes.layouts.footer')
		</div>


		<script>
			$('#summernote').summernote({
				placeholder: 'content',
                tabsize: 4,
                height: 300
            });
        </script>

        <script>

            /**
             * Submit support request with information provided in the form.
             */
            function submit_request(){
                /* Get user input from the form */
                var type_sel = document.getElementById("type");
                var type = type_sel.options[type_sel.selectedIndex].value;
                var text = document.getElementById("summernote").value;

                /* Acquire CSRF Token from server (Done in PHP Laravel) */
                var csrf = "{{ csrf_token() }}";

                /*  Submit support request with AJAX. This Javascript routine was used
                    instead of form due to unnecessary page refresh. */
                var xmlRequest = new XMLHttpRequest();
                xmlRequest.open('POST', '/support_request', true);
                xmlRequest.setRequestHeader('Content-Type', 'application/json');
                xmlRequest.setRequestHeader('X-CSRF-TOKEN', csrf);

                xmlRequest.onload = function() {
                    if (xmlRequest.responseText == 'true') {
                        window.alert("Your request has been submitted!");
                    }
                    window.location.href = '/views/support';
                }

                xmlRequest.send(
                    JSON.stringify({
                        "type"      : String(type),
                        "contents"  : text
                    })
                )
            }

        </script>
	</body>
</html>
