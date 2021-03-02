<!DOCTYPE html>
<html>
  <head>
    <title>Full page scroll</title>
    <link
      rel="stylesheet"
      type="text/css"
      href="/css/full-page-scroll.css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans"
      rel="stylesheet"
      type="text/css"
    />
    <style type="text/css">
      .section1 {
        background-color: #7dbcd4;
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

      span {
        font-size: 4em;
        font-style: normal;
        color: #fff;
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
    <div id="main" class="scroll-container">
      <section class="section1">
        <div>
          <span>It's beautiful and don't need Jquery :D</span>
        </div>
        <div>
          <a href="#" class="button">Download here</a>
        </div>
      </section>
      <section class="section2">
        <div>
          <span>Working on Tablets and Phones</span>
        </div>
      </section>
      <section class="section3">
        <div>
          <span>Edivaldo Pericleiton Rasta</span>
        </div>
      </section>
      <section class="section4">
        <div>
          <span>Funciona até no IE!</span>
        </div>
      </section>
      <section class="section5">
        <div>
          <span>:)</span>
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
  </body>
</html>
