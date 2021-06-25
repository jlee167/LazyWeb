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

<style>
    .nav-item:hover {
        /*transform: scale(1.15);*/
    }

    .navbar-default {
        background-color: #121212 !important;
        width: 100vw;
        height: 70px !important;
        padding: 0 0 0 0;
    }

    .navbar-toggler {
        margin: 0 auto;
    }

    .brand-text {}

    #brand-container{
        height: 70px !important;
        margin: auto;
        margin-right:20px;
        padding: auto;
        display:flex;
        flex-direction:row;
        align-items: center;
        justify-content: center;
    }

    .font-username {
        display: inline-block;
        color: white;
        display: inline-block;
        margin: auto;
        margin-left: 10px;
        vertical-align: middle;
    }

    #logout {
        color: white;
        display: inline-block;
        margin: auto;
        font-size: 12px;
        margin-left: 5px;
        vertical-align: middle;
        margin-right: 20px;
    }

    #signBtn {
        width: 100px;
        height: 45px;
        line-height: 30px;
        margin-right: 20px;
    }

    #profileImage {
        display: inline-block;
        width: 40px;
        height: 40px;
        margin: auto;
    }

    #logoImage {
        min-width: 40px;
        min-height: 40px;
        margin-right: 10px;
        margin-left: 15px;
    }

    #collapsibleNavbar {
        background-color: #121212 !important;
        width: 100%;
    }

    #brand-container {
        font-family: 'Lobster', cursive !important;
        margin-left: 15px;
    }

    #brand-logo {
        margin:auto;
        margin-right:5px;
    }

    .navbar .navbar-collapse {
        text-align: center;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light navbar-default bg-light fixed-top">
    <!-- Brand -->
    <div id="brand-container" class="navbar-brand brand-text">
        <img id="brand-logo" src="{{asset('/images/GitHub-Mark-Light-32px.png')}}">
        <p style="margin: auto; vertical-align: middle; color:white;">LazyBoy Industries</p>
    </div>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler bg-light" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"
        style="margin-right:20px;">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <!-- Menu -->
        <ul id="menu-links" class="navbar-nav mr-auto">
            <li class="nav-item"> <a class="nav-link" href="/views/main"> Home</a></li>
            <li class="nav-item"> <a class="nav-link"
                    onclick="modalApp.showModal=true; document.body.style.overflowY='hidden';"
                    style="white-space: nowrap; cursor: pointer;" onmouseover="">My Resume</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="/views/products"> Products</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/dashboard?page=1"> Dashboard</a></li>
            <li class="nav-item"> <a class="nav-link" href="/views/support"> Support</a></li>
            <li class="nav-item">
                <a class="nav-link" href="/views/emergency_broadcast">Emergency</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/views/peers">
                    <img src="{{asset('/images/peer-icon.svg')}}" style="">
                </a>
            </li>
        </ul>


        <div class="my-2 my-lg-0">
            <!-------------------------------------------------------------------------/
            /                           Login Button Rendering                         /
            /-------------------------------------------------------------------------->

            <!-------- Display username and logout button if currently logged in ------->
            <?php if (LoginController::get_auth_state()): ?>

            <img id="profileImage" src="{{asset('/images/GitHub-Mark-Light-32px.png')}}">
            <a class="font-username">
                <?php echo trim(Auth::user()["username"]); ?>
            </a>
            <a id="logout" href="javascript:logout();">
                (logout)
            </a>

            <!-------- Display login button if login is required ------->
            <?php else: ?>
            <a id="signBtn" class="btn btn-outline-light" href="/views/login" role="button">
                Sign In
            </a>
            <?php endif; ?>

            <!-------------------------------------------------------------------------/
            /                           /Login Button Rendering                        /
            /-------------------------------------------------------------------------->
        </div>
    </div>
</nav>

@include('includes.layouts.modal')
