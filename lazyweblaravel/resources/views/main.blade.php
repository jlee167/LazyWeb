<!doctype html>

<html>

<head>
    @include('includes.imports.styles_common')
    <link rel="stylesheet" type="text/css" href="/css/full-page-scroll.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .section1 {
            background-color: #121212;
        }

        .section2 {
            background-color: #98c19f;
        }

        .section3 {
            background-color: #a199e2;
        }

        .section4 {
            background-color: #cc938e;
        }

        .section5 {
            background-color: #d2c598;
        }

        section div {
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
    </style>
</head>


<body>
    @include('includes.layouts.navbar')


    <div id="main" class="scroll-container">
        <section class="section1">
            <div>
                <h1> My Picture Goes Here </h1>
                <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
            font-weight: 500 !important; font-size:100px;"> Hi, I'm LazyBoy!</h1>
            </div>
        </section>
        <section class="section2">
            <div>
                <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
        font-weight: 500 !important; font-size:35px; "> Digital Logics</h1>
                <p>
                    3 Years of experience in FPGA engineering.
                    I have experience with some time-critical modules and various protocols.

                </p>
            </div>
        </section>
        <section class="section3">
            <div>
                <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
        font-weight: 500 !important; font-size:35px; "> Digital Logics</h1>
                <p>
                    3 Years of experience in FPGA engineering.
                    I have experience with some time-critical modules and various protocols.

                </p>
            </div>
        </section>
        <section class="section4">
            <div>
                <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
        font-weight: 500 !important; font-size:35px; "> Digital Logics</h1>
                <p>
                    3 Years of experience in FPGA engineering.
                    I have experience with some time-critical modules and various protocols.

                </p>
            </div>
        </section>
        <section class="section5">
            <div>
                <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
        font-weight: 500 !important; font-size:35px; "> Digital Logics</h1>
                <p>
                    3 Years of experience in FPGA engineering.
                    I have experience with some time-critical modules and various protocols.

                </p>
            </div>
        </section>
    </div>
    <script src="/js/full-page-scroll.js"></script>
    <script type="text/javascript">
        new fullScroll({
      mainElement: "main",
      displayDots: true,
      dotsPosition: "left",
      animateTime: 0.7,
      animateFunction: "ease",
    });
    </script>


    <div style="height:70vh; background-color:#121212;">
        <div class="section-contents">
        </div>
    </div>

    <div style="height:80vh; background-color:#121212;">
        <h1> My Picture Goes Here </h1>
        <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
            font-weight: 500 !important; font-size:100px;"> Hi, I'm LazyBoy!</h1>
    </div>

    <div style="height:600px; background-color:#121212;">
        <div style="width:100%; display:flex; justify-content:center; ">
            <div style="display:inline-block;">
                <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
                    font-weight: 500 !important; font-size:35px; "> Digital Logics</h1>
                <p>
                    3 Years of experience with FPGA .

                </p>
            </div>
            <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="min-width:120px; min-height:120px;">
        </div>
    </div>

    <div style="height:600px; background-color:#121212;">
        <div style="display:flex; flex-direction:row; width:100vw; height:60px; margin-top:70px;
                        border-bottom: 1px solid #D5D5D5; align-items:center;">
            <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="min-width:120px; min-height:120px;">
            <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
                            font-weight: 500 !important; font-size:50px;"> Hardware</h1>
            <p> </p>
        </div>
    </div>

    <div style="height:600px; background-color:#121212;">
        <h1 style="font-family:'Anton', sans-serif !important; color:rgb(247, 190, 4);
            font-weight: 500 !important; font-size:50px;"> Software</h1>
        <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="min-width:120px; min-height:120px;">
    </div>









</body>

</html>
