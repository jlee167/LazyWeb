<!doctype html>

<?php
	use Illuminate\Support\Facades\View;
	use Illuminate\Routing\UrlGenerator;
?>



<html>

<!-----------------------------------------------------------------------------
                                     Head
------------------------------------------------------------------------------->

<head>
    <!-- Braodcast -->
    @include('includes.imports.styles_common')

    <!-- Page Specific Stylesheet -->
    <link rel="stylesheet" href="/css/chatbox.css">

    <!--  -->
    <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/7.10.2/video.min.js"></script>


    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=YOUR_CLIENT_ID">
    </script>

    <!-- Google Imports -->
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id"
        content="1083086831094-qatr04h8rnthlm9501q2oa45mjkjh4r0.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!--  Kakao Imports -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

    <script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
        integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
    </script>


    <script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=fcbc674142c20da29ab5dfe6d1aae93f">
    </script>
    <script type="text/javascript"
        src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=fcbc674142c20da29ab5dfe6d1aae93f&libraries=services,clusterer,drawing">
    </script>
</head>

<!-----------------------------------------------------------------------------
                                     /Head
------------------------------------------------------------------------------->





<!-----------------------------------------------------------------------------
                                     Body
------------------------------------------------------------------------------->

<body style="margin:0">
    <div id="resume-contents" style="display:flex;
        flex-direction:row;
        flex-wrap:wrap;
        height:100vh;
        width:100%;
        margin:0 0 0 0;
        align-content:space-between;
        background-color:red;">

        <div style="width:250px; height:100%; background-color:#5d31ff;">
            <div style="margin-top:20px;">
                <p style="color:white; margin-top:30px; margin-left:15px; font-size:14px;"> Moderators </p>
                <user-list-display v-bind:users="users"></user-list-display>

                <p style="color:white;  margin-top:50px; margin-left:15px; font-size:14px;"> Guardians </p>
                <user-list-display v-bind:users="users"></user-list-display>
            </div>
        </div>


        <video id="emergency_broadcast" width=320 height=240 class="video-js" controls
            style="flex: 1 0 auto; height:100%; vertical-align:top; margin-left:auto;">
        </video>


        <!-- Company Info-->
        <div id="map" style="display:inline-block; width:400px; height:100%; vertical-align:top; margin-right:auto;">
        </div>


        <div class="chat-container" style="height:100%; display:flex; flex-direction:column;">
            <div class="chat-top-bar"
                style="display:flex; flex-direction:row; justify-content:center; align-items:center;">
                <b style="color:white; font-size:100%;">Live Chat</b>
            </div>
            <div id="text-area" class="chat-textarea" style="overflow-y:scroll;">
                <div id="messages"
                    style="color:white; padding-left:15px; padding-right:15px; text-overflow:ellipsis;white-space:nowrap;">
                </div>
            </div>
            <div class="chat-inputarea">
                <form id="form" style="margin:auto; margin-bottom:20px; width:80%; height:100px; display:flex; flex-direction:row; justify-content:center;
								align-items:center;">

                    <textarea id="input" type="text" style="height:50px; border-radius:5px;" placeholder="Message">
						</textarea><br>

                    <button style="height:50px; border-radius:5px;">send</button>
                </form>
            </div>
        </div>
    </div>


    <script>
        /* -------------------------------------------------------------------------- */
        /*                                    VUE Init                                */
        /* -------------------------------------------------------------------------- */
        broadcastApp = new Vue ({
            el: '#resume-contents',
            data: {
                /* Small number of users. Just use array instead of map */
                users: [
                    {
                        imageUrl: '{{asset('/images/GitHub-Mark-Light-32px.png')}}',
                        name: "lazyboy",
                        status: 'AWAY'
                    },
                    {
                        imageUrl: '{{asset('/images/GitHub-Mark-Light-32px.png')}}',
                        name: "lazyboy2",
                        status: 'ONLINE'
                    }
                ],
                socket:     Object,
                messages:   Object,
                form:       Object,
                input:      Object,
                dev_height: Number(1080)
            },

            mounted: function(){

                /* ---------------- SocketIO Setup ------------------- */
                socket = io('localhost:3001');
                messages = document.getElementById('messages');
                form = document.getElementById('form');
                input = document.getElementById('input');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (input.value) {
                        socket.emit('chat message', input.value);
                        input.value = '';
                    }
                });

                socket.on('chat message', function(msg) {
                    var item = document.createElement('p');
                    item.textContent = msg;
                    item.style.cssText='text-overflow:ellipsis;width:100%; word-break:break-all; white-space:pre-line;';
                    messages.appendChild(item);
                    let chatDiv = document.getElementById('text-area');
                    chatDiv.scrollTop = chatDiv.scrollHeight;
                });
            }
        });
        /* -------------------------------------------------------------------------- */
        /*                                  /VUE Init                                 */
        /* -------------------------------------------------------------------------- */




        /* -------------------------------------------------------------------------- */
        /*                                Modules Init                                */
        /* -------------------------------------------------------------------------- */

        /* -------------------------------- Kakao Map ------------------------------- */
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


        /* --------------------------------- VideoJS -------------------------------- */
        videojs.Vhs.xhr.beforeRequest = function(options) {
            options.headers = {
                jwt: "sample jwt"   // Authentication Header
            };
            return options;
        };

        var player = videojs('emergency_broadcast');
        player.src("//d2zihajmogu5jn.cloudfront.net/bipbop-advanced/bipbop_16x9_variant.m3u8");
        player.play();

        /* -------------------------------------------------------------------------- */
        /*                               /Modules Init                                */
        /* -------------------------------------------------------------------------- */
    </script>
</body>

<!-----------------------------------------------------------------------------
                                     /Body
------------------------------------------------------------------------------->

</html>
