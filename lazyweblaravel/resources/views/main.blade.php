<!doctype html>

<html>

<head>
    @include('includes.imports.csrf')
    @include('includes.imports.styles_common')
    <link rel="stylesheet" type="text/css" href="/css/full-page-scroll.css" />
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />

    <script src="/js/full-page-scroll.js"></script>
    <script defer src="/js/main.js"></script>

    <style type="text/css">
        .scroll-section1 {
            background-color: #121212;
            border-top: 0px;
            border-bottom: 0px;
            overflow: hidden;
        }

        .scroll-section2 {
            background-color: #07080f;
            overflow: hidden;
        }

        .scroll-section3 {
            background-image: url({{asset('/images/tea-time-1080p.jpg')}});
            background-size: cover;
            overflow: hidden;
        }

        .scroll-section4 {
            background-color: #121212;
        }

        .scroll-section5 {
            background-color: #121212;
        }
    </style>
</head>


<body>
    @include('includes.layouts.navbar')


    <article id="main" class="scroll-container">
        <section id="section1" class="scroll-section1 section-center">
            <div class="scrollable-page">
                <img class="img-logo"
                    src="https://img.favpng.com/14/18/5/mustang-pony-cartoon-animation-drawing-png-favpng-eRTaFnQzSSKqTVJNerrQan3dx.jpg">
                <h1 class="front-label"> Welcome to... <br> Lazyboy Industries</h1>
            </div>
        </section>


        <section id="section2" class="scroll-section2 section-center">
            <div class="scrollable-page">
                <div class="contents">
                    <div class="preface">
                        <h1 class="header-preface"> Need my expertise? </h1>
                        <product-card v-bind:company="product1.company" v-bind:name="product1.name"
                            v-bind:description="product1.description" v-bind:bgColor="product1.bgColor"
                            v-bind:price="product1.price" v-bind:availability="product1.availability"></product-card>
                    </div>

                    <div id="skillContainer" class="container-skills">
                        <div id="skill1" class="skill-item ">
                            <img class="img-skills" src="{{asset('/images/RTL.png')}}">
                            <div class="skill-desc-container">
                                <h1 class="skill-desc-header"> Digital Logics</h1>
                                <p class="skill-desc-details">
                                    3 Years of experience in FPGA engineering.
                                    I have experience with some time-critical modules and various protocols.
                                </p>
                            </div>
                        </div>

                        <div id="skill2" class="skill-item ">
                            <!--div class="img-skills" style="background:url({{asset('/images/HARDWARE.png')}});"></div-->
                            <img class="img-skills" src="{{asset('/images/HARDWARE.png')}}">
                            <div class="skill-desc-container">
                                <h1 class="skill-desc-header"> Hardware</h1>
                                <p class="skill-desc-details">
                                    I'm from an Electrical Engineering background (BSEE).
                                    I can design simple digital/analog circuits below 1Ghz.<br>
                                </p>
                            </div>
                        </div>

                        <div id="skill3" class="skill-item ">
                            <img class="img-skills" src="{{asset('/images/SOFTWARE.png')}}">
                            <div class="skill-desc-container">
                                <h1 class="skill-desc-header"> Software</h1>
                                <p class="skill-desc-details">
                                    3 Years of experience in FPGA engineering.
                                    I have experience with some time-critical modules and various protocols.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id="section3" class="scroll-section3 section-center">
            <div class="scrollable-page">
                <div class="flex-center-vh">
                    <div class="overlay-dark overlay-box-page3">
                        <h1 id="offlineGroupHeader"> Group Study Activities </h1>
                        <p id="offlineGroupDesc">
                            <br>I'm currently looking for study groups for following subjects:
                            <br>
                            <br>React.js<br> Java<br> Spring<br> PostGres SQL
                            <br>
                            <br>
                            <br> If you need a studymate for one of the subjects above, shoot me a message!
                            <br> lazyboyindustries.main@gmail.com
                            <br>
                            <br><a href="http://naver.me/xWNhmmCZ">My preffered location</a>
                            <br>I'm happy to gather anywhere in southern part of Seoul.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </article>

</body>


<script>
    app = new Vue({
        el: "#main",
        data: {
            product1:
                {
                    company: "Lazyboy Industries",
                    name: "Lazyboy",
                    description: "Desc Here",
                    bgColor: "Pink",
                    price: 50.00,
                    availability: true
                }
        }
    });
</script>

</html>
