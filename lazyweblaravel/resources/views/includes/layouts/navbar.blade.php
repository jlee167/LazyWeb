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
    use App\Models\User;
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

    #brand-name {
        margin: auto;
        margin-left:10px;
        vertical-align: middle;
        color:white;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light navbar-default bg-light fixed-top">
    <!-- Brand -->
    <div id="brand-container" class="navbar-brand brand-text">
        <img id="brand-logo" src="{{asset('/images/GitHub-Mark-Light-32px.png')}}">
        <p id="brand-name">LazyBoy Industries</p>
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
            <li class="nav-item">
                <a  class="nav-link"
                    onclick=  " modalApp.showModal=true;
                                document.body.style.overflowY='hidden';"
                    style="white-space: nowrap; cursor: pointer;"
                    onmouseover=""
                >My Resume</a>
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


        <div class="my-2 my-lg-0 d-flex flex-row align-items-center">
            <!-------------------------------------------------------------------------/
            /                           Login Button Rendering                         /
            /-------------------------------------------------------------------------->

            <!-------- Display username and logout button if currently logged in ------->
            <?php if (LoginController::getAuthState()):
                $linkTag = '<a href="/views/user-info" style="margin:0 0 0 0; margin-right:5px; padding: 0 0 0 0;">';
                $imgTag = '<img id="profileImage" style="box-shadow: 0px 0px 4px 2px rgba(0, 174, 255, 0.753);" src="' . User::DEFAULT_IMAGE_URL . '">';
                //echo $imgTag;
                echo $linkTag . $imgTag . '</a>';
            ?>

                <a class="font-username" href="/views/user-info">
                    <?php //echo trim(Auth::user()["username"]); ?>
                </a>
                <a id="logout" href="javascript:logout();" >
                    <div style="margin-top: auto; margin-bottom:auto;">
                        <img src="{{asset('/images/icon-power.svg')}}" style="width:25px; height:25px;">
                        <p class="mb-0">logout</p>
                    </div>
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
