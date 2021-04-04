<!doctype html>

<?php
	use Illuminate\Support\Facades\View;
	use Illuminate\Routing\UrlGenerator;
?>



<html>
	<head>
        <!-- Braodcast -->
        @include('includes.imports.styles_common')

        <!-- Page Specific Stylesheet -->
        <link rel="stylesheet" href="/css/chatbox.css">
        <link rel="stylesheet" href="/css/broadcast.css">

        <!--  -->
        <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">
        <script src="//vjs.zencdn.net/7.10.2/video.min.js"></script>


		<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=YOUR_CLIENT_ID"></script>

		<!-- Google Imports -->
		<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="1083086831094-qatr04h8rnthlm9501q2oa45mjkjh4r0.apps.googleusercontent.com">
		<script src="https://apis.google.com/js/platform.js" async defer></script>

		<!--  Kakao Imports -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
	</head>


	<body>
		@include('includes.layouts.navbar')

		<div id="resume-contents" class="section-contents" style="display:flex;
                                                                  flex-direction:row;
                                                                  flex-wrap:wrap;
                                                                  height:100vh;
                                                                  width:100%;
                                                                  align-content:space-between;
                                                                  background-color:red;
                                                                  ">

			<div style="width:250px; height:100%; background-color:#5d31ff;">
                <div style="margin-top:20px;">
                    <p style="color:white; margin-top:30px; margin-left:15px; font-size:14px;"> Moderators </p>
                    <user-list-display v-bind:users="users"></user-list-display>

                    <p style="color:white; margin-top:50px; margin-left:15px; font-size:14px;"> Operators </p>
                    <user-list-display v-bind:users="users"></user-list-display>

                    <p style="color:white;  margin-top:50px; margin-left:15px; font-size:14px;"> Guardians </p>
                    <user-list-display v-bind:users="users"></user-list-display>
                </div>
			</div>

            <video id="emergency_broadcast" width=320 height=240 class="video-js" controls style="flex: 1 0 auto; height:100%; vertical-align:top; margin-left:auto;">
            </video>
			<!-- Company Info-->
            <div id="map" style="display:inline-block; width:400px; height:100%; vertical-align:top; margin-right:auto;">
            </div>


			<div class="chat-container" style="height:100%; display:flex; flex-direction:column;">
				<div class="chat-top-bar" style="display:flex; flex-direction:row; justify-content:center; align-items:center;">
					<b style="color:white; font-size:100%;">Live Chat</b>
				</div>
				<div class="chat-textarea">

				</div>
				<div class="chat-inputarea">
                    <form action="/forum/general/post"
                    enctype="multipart/form-data"
                    method="POST"
                    style="margin:auto; width:200px; height:100px; flex-direction:row;">
                    @csrf
                    <textarea
                        name=""
                        style="width:100%; height:60%; border-radius:5px;"
                        placeholder="Message">
                    </textarea><br>

                    <input  class="btn btn-outline-success" type="submit" value="submit"
                            style="display:inline-block; float:right; margin-top:15px; width: 100px;"
                    >
                    </form>
				</div>
			</div>
		</div>

        <!-- Footer -->
        @include('includes.layouts.footer')
        @include('includes.layouts.modal')

		<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=fcbc674142c20da29ab5dfe6d1aae93f"></script>
		<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=fcbc674142c20da29ab5dfe6d1aae93f&libraries=services,clusterer,drawing"></script>

        <script src="{{ mix('js/app.js') }}"></script>
        <script>
            //console.log({{asset('/images/GitHub-Mark-Light-32px.png')}});
            userListApp = new Vue ({
                el: '#resume-contents',
                data: {
                    users: [
                        {
                            imageUrl: '{{asset('/images/GitHub-Mark-Light-32px.png')}}',
                            name: "lazyboy"
                        },
                        {
                            imageUrl: '{{asset('/images/GitHub-Mark-Light-32px.png')}}',
                            name: "lazyboy2"
                        }
                    ],
                    dev_height: Number(1080)
                },
                mounted: function(){
                }
            });
        </script>



		<script>
            /**
            *   Kakao Maps Setup
            *   --------------------------------------------
            *   @Desc   Constantly updates location of the target.
            *   @Todo   Determine Refresh rate
            */
			var container = document.getElementById('map');
			var lat = 33.450701;
			var streamerPosition = new kakao.maps.LatLng(lat, 126.570667);
			var options = {
				center: streamerPosition,
				level: 3
			};
			var map = new kakao.maps.Map(container, options);

			var marker = new kakao.maps.Marker({
				position: streamerPosition
			});
            marker.setMap(map);


            /* Instantiate VideoJS player */
            var player = videojs('emergency_broadcast');
            //player.fluid(true);
            player.src("//d2zihajmogu5jn.cloudfront.net/bipbop-advanced/bipbop_16x9_variant.m3u8");
            player.play();
		</script>

		<script type="text/javascript" src="{{asset('js/login_handler.js')}}"></script>
		<script type="text/javascript" src="{{asset('js/cookie_handler.js')}}">
			var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);

			var peerlist;

			var xhttp = new XMLHttpRequest();
			xhttp.open('POST', '../server/user_register.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/json');

			var accessToken = getCookie('AccessToken');
			var authenticator = getCookie('Authenticator');

			if (accessToken.length == 0)
				window.location.href = 'login.php';

			var peerlist_request = {
				"Request" : "Peer List",
				"Access Token" : accessToken,
				"Authenticator" : authenticator
			};

			xhttp.onload = function() {
				var text = 'Peer List Request Response: ' + xhttp.responseText;
				console.log(text);
				peerlist = JSON.parse(xhttp.responseText);
				console.log(peerlist);
				console.log(peerlist.protectees.length);
				update_table();
			};

			console.log(JSON.stringify(peerlist_request));
			xhttp.send(JSON.stringify(peerlist_request));

			function update_table() {
				let peerlist_content = document.getElementById("peer table");
				let emg_light;

				if (peerlist.protectees.length) {
					for (var i = 0; i < peerlist.protectees.length; i = i + 1) {
						console.log(i);
						if (peerlist.protectees[i]['status'])
							emg_light = '<td style="width:50px; background-color:red;">EMG Light</td></tr>';
						else
							emg_light = '<td style="width:50px; background-color:green;">EMG Light</td></tr>';

						peerlist_content.innerHTML += '<tr style="width:100%; height:50px;" onclick=""><td style="width:50px;">' + '<img style="width:50px; height:50px;" src ="' +  peerlist.protectees[i]['id_profile_picture'] + '">' + '</td><td>'
																	+ peerlist.protectees[i]['name']  + '<br>'
																	+ peerlist.protectees[i]['phone'] +'</td>' + emg_light;
					}
				}
			}



			//alert(getCookie('LazyWeb Signature'));
			var authProvider = getCookie('Authenticator');

			if (authProvider == 'Kakao') {
				Kakao.init('fcbc674142c20da29ab5dfe6d1aae93f');
				Kakao.API.request({
					url: '/v2/user/me',
					success: function(res) {
						//alert('login success' + JSON.stringify(res));
					},
					fail: function(error) {
						//alert('login success, but failed to request user information: ' + JSON.stringify(error));
					},
                });
			}
			else if (authProvider == 'Google') {
				var googleToken = getCookie('AccessToken' );
				var xhp = new XMLHttpRequest();
				xhp.open('POST', '../server/user_register.php', true);
				xhp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

				xhp.onload = function() {
					src_video = 'http://www.hlsserver.com/' + xhp.responseText.trim() + '.m3u8';
					console.log(src_video);
					player.src({
						src: "//d2zihajmogu5jn.cloudfront.net/bipbop-advanced/bipbop_16x9_variant.m3u8",
						type: 'application/x-mpegURL'
                    });
                    player.play();
				};
				xhp.send("googlestream=" + googleToken);
			}
		</script>
	</body>

</html>
