<!-- Top Navigation Bar -->
<div id="main_nav" style="margin-botoom:0;">
    <nav class="navbar navbar-expand-sm mb-4 fixed-top" style="height:70px; margin-bottom:0px !important; background-color:#05172a !important; opacity:0.8;">
        <ul class="navbar-nav" style="text-align:center; margin:0 auto; left:20%;">
            <li class="nav-item active" style="padding-right:20px"> <a class="nav-link neon-on" href="/views/main"><span style="font-family:'Malgun Gothic'; font-weight:bold; color:white;">Home</span></a></li>
            <li class="nav-item" style="padding-right:20px"> <a class="nav-link neon-off" href="/views/about">LazyBoy</a></li>
            <li class="nav-item dropdown" style="padding-right:20px"> <a class="nav-link dropdown-toggle neon-off"
                href="/views/products" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">LTE Camera</a>
                    <a class="dropdown-item" href="#">Arduino Camera</a>
                </div>
            </li>
            <li class="nav-item" style="padding-right:20px"> <a class="nav-link neon-off" href="/views/dashboard?0">Dashboard</a></li>
            <li class="nav-item dropdown" style="padding-right:20px">
                <a class="nav-link neon-off" href="/views/support">Support</a>
            </li>
            <li class="nav-item" style="padding-right:20px"> <a class="nav-link neon-off" href="/views/broadcast">Emergency Broadcast </a></li>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item active" style="font-weight:bold; ">
                    <a id="userInfoUI" class="nav-link neon-off" href="#" style="font-weight:bold; text-align:right;"></a>
            </li>
        </ul>

        <ul class="navbar-nav" style="vertical-align:middle;">
            <li id="signInContainer" class="nav-item active" >
                <a id="signBtn"class="btn btn-outline-light" href="/views/login" role="button" style="margin:auto; width:130px; height:45px; line-height:30px;">
                    Sign In
                </a>
            </li>
        </ul>
    </nav>
</div>
