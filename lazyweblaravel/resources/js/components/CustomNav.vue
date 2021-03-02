<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="background-color:#121212 !important;">
            <a class="navbar-brand" style="font-family: 'Lobster', cursive !important;">
                <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="min-width:40px; min-height:40px;margin-right:10px;"> LazyBoy Industries
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-collapsible" aria-controls="menu-collapsible"
            aria-expanded="false" aria-label="Toggle navigation" style="background-color:white; height:55px;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="menu-collapsible" class="navbar-collapse collapse ">
                <ul id="menu-links" class="nav navbar-nav" style="text-align:center; width:auto;">
                    <li class="nav-item"> <a class="nav-link" href="/views/main">Home</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/views/about" style="white-space: nowrap;">My Resume</a></li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle"
                        href="/views/products" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Products</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">LTE Camera</a>
                            <a class="dropdown-item" href="#">Arduino Camera</a>
                        </div>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/views/dashboard?0">Dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/views/support">Support</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/views/broadcast">Emergency</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-brand order-3 ml-auto" style="text-align:center; width:auto;">
                    <li class="nav-item">
                        <a id="signBtn" class="btn btn-outline-light" href="/views/login" role="button"
                            style="width:130px; height:45px; line-height:30px;">
                            Sign In
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>




<script>
    export default {
        props: ['msg_in'],

        mounted() {
            console.log('Component mounted.')
        },
        /*
        data() {
            return {
                message: "Hello2"
            }
        },
        */
        methods: {
            reverseMessage: function () {

            }
        }
    }
</script>
