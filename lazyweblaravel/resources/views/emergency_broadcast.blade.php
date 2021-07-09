<!doctype html>

<html>

<!-----------------------------------------------------------------------------
                                     Head
------------------------------------------------------------------------------->

<head>
    <!-- Braodcast -->
    @include('includes.imports.csrf')
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





    <style type="text/css">
        .marquee-background {
            display: flex;
            flex-direction: row;
            justify-content: center;
            width: 100vw;
            height: 50px;
            background-color: rgba(117, 115, 0, 0.8);
            overflow: hidden;
        }

        .marquee {
            width: 80vw;
            font-size: 30px;
            white-space: nowrap;
            position: relative;
            color: rgb(238, 255, 0);
            vertical-align: middle;
            margin: auto;
            animation: police-line-scroll 32s linear infinite;
        }

        @keyframes police-line-scroll {
            from {
                transform: translateX(10%);
            }

            to {
                transform: translateX(-90%);
            }
        }

        #container-top {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            height: calc(100vh - 50px);
            width: 100%;
            margin: 0 0 0 0;
            align-content: space-between;
            background-color: red;
            overflow-x: hidden;
        }

        .user-type {
            color: white;
            margin-top: 50px;
            margin-left: 15px;
            font-size: 14px;
        }

        .user-list {
            width: 250px;
            height: 100%;
            background-color: #5d31ff;
        }

        .video-js {
            flex: 1 0 auto;
            height: 100%;
            vertical-align: top;
            margin-left: auto;
        }

        #map {
            display: inline-block;
            width: 400px;
            height: 100%;
            vertical-align: top;
            margin-right: auto;
        }

        #messages {
            color: white;
            padding-left: 15px;
            padding-right: 15px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #form {
            margin: auto;
            padding-top: 15px;
            padding-bottom: 15px;
            width: 100%;
            height: 70px;
            display: flex;
            flex-direction: row;
            justify-content: center;
        }

        #input {
            background-color: transparent;
            margin-right: 20px;
            margin-left: 20px;
            border-style: solid;
            border-left-width: 0px;
            border-right-width: 0px;
            border-top-width: 0px !important;
            border-bottom-width: 1;
            outline: none;
            height: 30px;
            color: white;
        }

        .title-live-chat {
            color: white;
            font-size: 100%;
        }

        .btn-send-chat {
            border-radius: 5px;
            margin-right: 20px;
        }
    </style>
</head>

<!-----------------------------------------------------------------------------
                                     /Head
------------------------------------------------------------------------------->





<!-----------------------------------------------------------------------------
                                     Body
------------------------------------------------------------------------------->

<body style="margin:0; overflow-x:hidden;overflow-y:hidden;">
    <div id="container-top">
        <!-- User List -->
        <div class="user-list">
            <div style="margin-top:20px;">
                <p class="user-type"> Operators </p>
                <user-list-display v-bind:users="operators"></user-list-display>

                <p class="user-type"> Guardians </p>
                <user-list-display v-bind:users="guardians"></user-list-display>
            </div>
        </div>

        <!-- Video Player-->
        <video id="emergency_broadcast" width=320 height=240 class="video-js" controls></video>

        <!-- Kakao Map -->
        <div id="map"></div>


        <!-- Live Chat -->
        <div class="chat-container">
            <div class="chat-top-bar">
                <b class="title-live-chat">Live Chat</b>
            </div>
            <div id="text-area" class="chat-textarea">
                <div id="messages"></div>
            </div>
            <div class="chat-inputarea">
                <form id="form">
                    <input id="input" type="text" autocomplete="off" placeholder="Message"> <br>
                    <button class="btn-send-chat" class="btn btn-outline-light" type="submit">send</button>
                </form>
            </div>
        </div>
    </div>


    <div class="marquee-background">
        <p class="marquee">
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            /// Rescue attempt in progress ///
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
    </div>

    <script src="/js/jwt.js"></script>
    <script defer>
        //let token = jwt.sign({ username: "asdfadsfadfs" }, "adfasfasdf");
        //console.log(jwt.verify(token, "adfasfasdf"));

        /* -------------------------------------------------------------------------- */
        /*                             VUE Application                                */
        /* -------------------------------------------------------------------------- */
        broadcastApp = new Vue ({
            el: '#container-top',
            data: {
                /* Small number of users. Just use array instead of map */
                operators: [
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
                guardians: [
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

                socket.on('response', function(msg) {
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
        /*                            /VUE Application                                */
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
        /*
        let urlParams = new URLSearchParams(window.location.search);
        let protected = urlParams.get('protected');
        var jwt = null;

        let jwtRequest = new XMLHttpRequest();
        jwtRequest.open("GET", "/emergency/" + protected + "/web_token", true);
        jwtRequest.setRequestHeader("Content-Type", "application/json");
        jwtRequest.setRequestHeader("X-CSRF-TOKEN", csrf);
        jwtRequest.onload = function () {
            try {
                window.alert(jwtRequest.responseText);
                let res = JSON.parse(jwtRequest.responseText);
                jwt = res.webToken;
            } catch (err) {
                window.alert(err);
                return;
            }
        };
        jwtRequest.send();
        */
    </script>
</body>

<!-----------------------------------------------------------------------------
                                     /Body
------------------------------------------------------------------------------->

</html>
