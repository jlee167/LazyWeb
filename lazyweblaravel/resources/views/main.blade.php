<!doctype html>

<html>

<head>
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


    <div id="main" class="scroll-container">


        <section class="scroll-section1 section-center">
            <div class="scrollable-page">
                <img class="img-logo"
                    src="https://img.favpng.com/14/18/5/mustang-pony-cartoon-animation-drawing-png-favpng-eRTaFnQzSSKqTVJNerrQan3dx.jpg">
                <h1 class="front-label"> Welcome to... <br> Lazyboy Industries</h1>
            </div>
        </section>


        <section class="scroll-section2 section-center">
            <div class="scrollable-page">
                <div class="contents">
                    <div class="preface">
                        <h1 class="header-preface"> Need my expertise? </h1>
                        <product-card v-bind:company="product1.company" v-bind:name="product1.name"
                            v-bind:description="product1.description" v-bind:bgColor="product1.bgColor"
                            v-bind:price="product1.price" v-bind:availability="product1.availability"></product-card>
                    </div>

                    <div class="container-skills">
                        <div class="skill-item fade-1s">
                            <img class="img-skills" src="{{asset('/images/RTL.png')}}">
                            <div class="skill-desc-container">
                                <h1 class="skill-desc-header"> Digital Logics</h1>
                                <p class="skill-desc-details">
                                    3 Years of experience in FPGA engineering.<br>
                                    I have experience with some time-critical modules and various protocols.
                                </p>
                            </div>
                        </div>

                        <div class="skill-item fade-2s">
                            <!--div class="img-skills" style="background:url({{asset('/images/HARDWARE.png')}});"></div-->
                            <img class="img-skills" src="{{asset('/images/HARDWARE.png')}}">
                            <div class="skill-desc-container">
                                <h1 class="skill-desc-header"> Hardware</h1>
                                <p class="skill-desc-details">
                                    I'm from an Electrical Engineering background. (BSEE)<br>
                                    I can design simple digital/analog circuits below 1Ghz.<br>
                                </p>
                            </div>
                        </div>

                        <div class="skill-item fade-3s">
                            <img class="img-skills" src="{{asset('/images/SOFTWARE.png')}}">
                            <div class="skill-desc-container">
                                <h1 class="skill-desc-header"> Software</h1>
                                <p class="skill-desc-details">
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
            <div class="scrollable-page">
                <div class="flex-center-vh">
                    <div class="overlay-dark overlay-box-page3">
                        <h1 id="offlineGroupHeader"> Group Study Activities </h1>
                        <p id="offlineGroupDesc">
                            <br>I'm currently looking for study groups for following subjects:
                            <br>
                            <br>React.js, Java, Spring, SQLP
                            <br>
                            <br> If you need a studymate for one of the above, shoot me a message!
                            <br><br> lazyboyindustries.main@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

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
