<!doctype html>

<html>

<head>
    @include('includes.imports.styles_common')
    <link rel="stylesheet" type="text/css" href="/css/full-page-scroll.css" />
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .scroll-section1 {
            background-color: #121212;
            border-top:0px;
            border-bottom:0px;
        }

        .scroll-section2 {
            background-color: #282736;
        }

        .scroll-section3 {
            background-image: url({{asset('/images/tea-time-1080p.jpg')}});
            background-size: cover;
        }

        .scroll-section4 {
            background-color: #121212;
        }

        .scroll-section5 {
            background-color: #121212;
        }

        .section-center {
            font-family: "Open Sans";
            font-style: normal;
            text-align: center;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .page-container {
            font-family: "Open Sans";
            font-style: normal;
            text-align: center;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .button {
            background-color: #f2cf66;
            border-bottom: 5px solid #d1b358;
            text-shadow: 0px -2px #d1b358;
            padding: 10px 40px;
            border-radius: 10px;
            font-size: 25px;
            color: #fff;
            text-decoration: none;
        }

        .overlay-dark {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.8); /* Black background with opacity */
            z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
        }
    </style>
</head>


<body>
    @include('includes.layouts.navbar')


    <div id="main" class="scroll-container">
        <section class="scroll-section1 section-center">
            <div class="page-container">
                <img
                    class="img-logo"
                    src="https://img.favpng.com/14/18/5/mustang-pony-cartoon-animation-drawing-png-favpng-eRTaFnQzSSKqTVJNerrQan3dx.jpg"
                >
                <h1 class="front-label"> Hi, I'm LazyBoy!</h1>
            </div>
        </section>
        <section class="scroll-section2 section-center">
            <div class="page-container">
                <div class="contents">
                    <div class="logo-engineering">
                        <img class="img-logo" src="https://img.favpng.com/14/18/5/mustang-pony-cartoon-animation-drawing-png-favpng-eRTaFnQzSSKqTVJNerrQan3dx.jpg">
                    </div>

                    <div style="display:flex; flex-direction:column; justify-content:center; padding-left:30px; padding-right:20px;">
                        <div class="container-skills">
                            <img class="img-skills" src="{{asset('/images/RTL.png')}}">
                            <div style="display:flex; flex-direction:column; justify-content:start; align-items:flex-start;">
                                <h1 class="header-skills"> Digital Logics</h1>
                                <p class="desc_skills">
                                    3 Years of experience in FPGA engineering.<br>
                                    I have experience with some time-critical modules and various protocols.
                                </p>
                            </div>
                        </div>

                        <div class="container-skills">
                            <img class="img-skills" src="{{asset('/images/HARDWARE.png')}}">
                            <div style="display:flex; flex-direction:column; justify-content:start; align-items:flex-start;">
                                <h1 class="header-skills"> Hardware</h1>
                                <p class="desc_skills">
                                    I'm from an Electrical Engineering background. (BSEE)<br>
                                    I can design simple digital/analog circuits below 1Ghz.<br>
                                </p>
                            </div>
                        </div>

                        <div class="container-skills">
                            <img class="img-skills" src="{{asset('/images/SOFTWARE.png')}}">
                            <div style="display:flex; flex-direction:column; justify-content:start; align-items:flex-start;">
                                <h1 class="header-skills"> Software</h1>
                                <p class="desc_skills">
                                    3 Years of experience in FPGA engineering.<br>
                                    I have experience with some time-critical modules and various protocols.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="scroll-section3 section-center">
            <div  class="page-container">
                <div div style="display:flex; flex-direction:row; justify-content:center; align-items:center;">
                    <div class="overlay-dark"
                        style="display:flex; flex-direction:column; justify-content:start; align-items:center; padding: 20px 20px 20px 20px;">
                        <h1 style="font-family:'Anton', sans-serif !important; color:rgb(252, 252, 252);
                                font-weight: 500 !important; font-size:35px;"> Study with me! </h1>
                        <p style="color:white; font-weight:600; font-family: 'Nunito Sans', sans-serif;">
                            <br>Currently looking for study groups:
                            <br>React.js, Spring, SQL Cert
                            <br><br> Contact: lazyboyindustries.main@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('includes.layouts.modal')

    <script src="/js/full-page-scroll.js"></script>
    <script type="text/javascript">
        /* Page Scroll App */
        new fullScroll({
            mainElement: "main",
            displayDots: true,
            dotsPosition: "left",
            animateTime: 0.7,
            animateFunction: "ease",
            transitionItems: []
        });
    </script>
</body>

</html>
