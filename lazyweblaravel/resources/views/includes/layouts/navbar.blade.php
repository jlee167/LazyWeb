<!--
Top Navigation Bar

Fixed navigation bar at the top of some pages.
Contains menu, brand, and authentication status.
Built using Bootstrap 4 Collapsible Navbar.

When user is already logged in, login button will be replaced by control links. (logout, user info...)
Opposite when not authenticated yet.
-->


<?php
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\UserController;
    use Illuminate\Support\Facades\Auth;
?>


<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="background-color:#121212 !important;
                                            height:70px !important;">
    <!-- Brand -->
    <a class="navbar-brand" style="font-family: 'Lobster', cursive !important;">
        <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}"
            style="min-width:40px; min-height:40px;margin-right:10px;"> LazyBoy Industries
    </a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler bg-light" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar"
        style="background-color:#121212 !important; width:100vw;">

        <!-- Menu -->
        <ul id="menu-links" class="navbar-nav mr-auto">
            <li class="nav-item"> <a class="nav-link" href="/views/main"> Home</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/about" style="white-space: nowrap;">My Resume</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="/views/main"> Products</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/dashboard?page=1"> Dashboard</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/support"> Support</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/broadcast"> Emergency</a></li>
        </ul>


        <div class="my-2 my-lg-0">
            <!-------------------------------------------------------------------------/
            /                           Login Button Rendering                         /
            /-------------------------------------------------------------------------->

            <!-------- Display username and logout button if currently logged in ------->
            <?php if (LoginController::get_auth_state()): ?>
            <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}"
                style="display:inline-block; width:40px; height:40px; margin:auto;">
            <a class="font-username" style="display:inline-block; color:white; display:inline-block; margin:auto;
                                                margin-left:10px; vertical-align:middle;">
                <?php echo trim(Auth::user()["username"]); ?>
            </a>
            <a style="color:white; display:inline-block; margin:auto; font-size:12px; margin-left:5px; vertical-align:middle;"
                href="javascript:logout();">
                (logout)
            </a>


            <!-------- Display login button if login is required ------->
            <?php else: ?>
            <a id="signBtn" class="btn btn-outline-light" href="/views/login" role="button"
                style="width:100px; height:45px; line-height:30px;">
                Sign In
            </a>
            <?php endif; ?>

            <!-------------------------------------------------------------------------/
            /                           /Login Button Rendering                        /
            /-------------------------------------------------------------------------->
        </div>
</nav>



<script>
    /**
     * Login with username and password
     *
     * @param {*} csrf
     * @param {*} username
     * @param {*} password
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

            //Todo: Some logout verification message perhaps...

            console.log("Successfully Logged Out!")
            window.location.reload();
        };

        loginRequest.send();
    }
</script>
