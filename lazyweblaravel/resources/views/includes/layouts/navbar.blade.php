<!--
Top Navigation Bar

Fixed navigation bar at the top of some pages.
Contains menu, brand, and authentication status.
Built using Bootstrap 4 Collapsible Navbar.

@ServerSide_Rendering
When user is already logged in, login button will be replaced by control links. (logout, user info...)
Opposite when not authenticated yet.
-->


<?php
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Auth;
?>


<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="background-color:#121212 !important; height:70px !important;">

    <!-- Brand -->
    <a class="navbar-brand" style="font-family: 'Lobster', cursive !important;">
        <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="min-width:40px; min-height:40px;margin-right:10px;"> LazyBoy Industries
    </a>


    <!-- Collapse Control Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-collapsible" aria-controls="menu-collapsible"
        aria-expanded="false" aria-label="Toggle navigation" style="background-color:white; ">
        <span class="navbar-toggler-icon"></span>
    </button>


    <div id="menu-collapsible" class="navbar-collapse collapse ">

        <!-- Menu -->
        <ul id="menu-links" class="nav navbar-nav" style="text-align:center; width:auto;">
            <li class="nav-item"> <a class="nav-link" href="/views/main">Home</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/about" style="white-space: nowrap;">My Resume</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/main">Products</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/dashboard?0">Dashboard</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="/views/support">Support</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="/views/broadcast">Emergency</a></li>
        </ul>


        <!-- Authentication Status GUI. Conditionally rendered depending on user authentication status. -->
        <ul class="nav navbar-nav navbar-brand order-3 ml-auto" style="width:auto;">
                <?php if (LoginController::get_auth_state()): ?>
                    <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}"
                    style="width:40px; height:40px; margin:auto;">
                    <a class="font-username" style="color:white; display:inline-block; margin:auto; margin-left:10px; ">
                        <?php echo trim(Auth::user()["username"]); ?>
                    </a>
                    <p style="color:white; display:inline-block; margin:auto; font-size:12px; margin-left:5px; vertical-align:middle;">
                        (logout)
                    </p>
                <?php else: ?>
                    <a id="signBtn" class="btn btn-outline-light" href="/views/login" role="button"
                        style="width:100px; height:45px; line-height:30px;">
                        Sign In
                    </a>
                <?php endif; ?>
        </ul>
    </div>
</nav>

<script>
    /**
     *  Non-social login routine.
     *  Authenticate users by username and password
     */
    function logout(){
        var csrf = "{{ csrf_token() }}";
        var loginRequest = new XMLHttpRequest();
        loginRequest.open('POST', '/logout', true);
        loginRequest.setRequestHeader('Content-Type', 'application/json');
        loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
        loginRequest.onload = function() {
            console.log(loginRequest.responseText);
            var response = JSON.parse(loginRequest.responseText);
            if (response.authenticated == true) {
                console.log("Successfully authenticated by LazyWeb!")
                window.location.href = "{{url()->previous()}}";
            }
            else {
                console.log("Login Failed!");
            }
        };

        loginRequest.send(JSON.stringify({
            "username" : username,
            "password" : password
        }));
    }
</script>
