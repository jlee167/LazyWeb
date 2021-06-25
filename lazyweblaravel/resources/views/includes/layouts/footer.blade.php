<!-- Footer Area -->
<style>
    #copyright {
        color: white;
        text-align: center;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    #footer-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        background-color: #181818;
        vertical-align: bottom;
        border-top: 1px;
        margin: 0 0 0 0;
        padding: 0 0 0 0;
    }

    #footer-contents {
        display: flex;
        justify-content: center;
        padding-top: 50px;
    }

    #footer-skills {
        display: flex;
        flex-direction: column;
        padding-right: 50px;
        width: 300px;
    }

    #footer-contact {
        display: flex;
        flex-direction: column;
        padding-right: 50px;
    }

    #footer-register {
        display: flex;
        flex-direction: column;
    }

    #footer-signBtn {
        width: 130px;
        height: 45px;
        line-height: 30px;
    }


    .footer-column-header {
        color: white;
        font-family: 'Akaya Telivigala', cursive;
        font-size: 20px;
        white-space: nowrap;
    }

    .footer-skill-item {
        display: flex;
        flex-direction: row;
        padding-right: 50px;
    }

    .footer-skill-label {
        color: white;
        padding-left: 15px;
        white-space: nowrap;
    }

    .footer-skill-imgsize {
        width: 32px;
        height: 32px;
    }

    .footer-contanct-icon {
        display: inline;
        width: 25px;
        height: 25px;
        margin-right: 10px;
    }

    .footer-contact-label {
        display: inline;
        white-space: nowrap;
        color: white;
    }



    @media only screen and (max-width: 920px) {
        #footer-register {
            display: none;
        }

        #footer-contact {
            padding-right: 0px;
        }
    }

    @media only screen and (max-width: 600px) {
        #footer-skills {
            display: none;
        }
    }
</style>

<div id="footer-container">
    <div id="footer-contents">
        <div id="footer-skills">
            <p class="footer-column-header">Built With</p>
            <div class="footer-skill-item">
                <a class="footer-skill-imgsize">
                    <img class="footer-skill-imgsize" src="{{asset('/images/php_logo.png')}}" />
                </a>
                <p class="footer-skill-label">PHP 7.3</p>
            </div>
            <div class="footer-skill-item">
                <a class="footer-skill-imgsize">
                    <img class="footer-skill-imgsize" src="{{asset('/images/laravel_logo.png')}}" />
                </a>
                <p class="footer-skill-label">Laravel 8</p>
            </div>
            <div class="footer-skill-item">
                <a class="footer-skill-imgsize">
                    <img class="footer-skill-imgsize" src="{{asset('/images/vue_logo.png')}}" />
                </a>
                <p class="footer-skill-label">Vue.js 2.6</p>
            </div>
        </div>

        <div id="footer-contact">
            <p class="footer-column-header">Contact</p>
            <div style="margin-bottom:10px;">
                <img class="footer-contanct-icon" src="/images/icon-building.svg" />
                <p class="footer-contact-label">LazyBoy Co.Ltd</p>
            </div>
            <div style="margin-bottom:10px;">
                <img class="footer-contanct-icon" src="/images/icon-mail.svg" />
                <p class="footer-contact-label">lazyboyindustries.main@gmail.com</p>
            </div>
            <div style="margin-bottom:10px;">
                <img class="footer-contanct-icon" src="/images/icon-phone.svg" />
                <p class="footer-contact-label">010-xxxx-xxxx</p>
            </div>

            <div style="margin-top:20px;">
                <a href="https://github.com/jlee167" style="width:25px; height:25px;">
                    <img class="footer-contanct-icon" src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" />
                </a>
                <a href="https://github.com/jlee167" style="width:25px; height:25px;">
                    <img class="footer-contanct-icon" src="{{asset('/images/linkedin.svg')}}">
                </a>
                <a href="https://github.com/jlee167" style="width:25px; height:25px;">
                    <img class="footer-contanct-icon" src="{{asset('/images/google.svg')}}">
                </a>

            </div>
        </div>

        <div id="footer-register">
            <p style="color:white; white-space:nowrap;">Want to participate in my projects?</p>
            <a id="footer-signBtn" class="btn btn-outline-success" href="/views/register" role="button">
                Sign up!
            </a>
        </div>

    </div>
    <div class="container" style="justify-content:center; padding-top:50px; width:100%">
        <hr style="height:2px; border-width:0; background-color:white; color:white;">
        <p id="copyright">
            Copyright 2021 Lazyboy Industry CO.Limitied All Rights Reserved
        </p>
    </div>
</div>
