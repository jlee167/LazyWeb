<html>

<head>
    @include('includes.imports.styles_common')
    @include('includes.imports.csrf')

    <!------------------ include libraries(jQuery, bootstrap) ------------------>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>

    <link rel="stylesheet" href="/css/support.css">
    <script src="/js/support.js"></script>
</head>




<body>
    @include('includes.layouts.navbar')

    <div class="section-contents background-support">

        <div id="support_sidebar" class="sidebar-support-page">
            <a class="sidebar-item" href="#FAQ" style="text-decoration: none;">
                <img class="sidebar-image" src="{{asset('/images/question-circle.svg')}}">
                <p class="sidebar-text">FAQ</p>
            </a>

            <a class="sidebar-item" href="#request_view" style="text-decoration: none;">
                <img class="sidebar-image" src="{{asset('/images/chat-dots.svg')}}">
                <p class="sidebar-text"> Make a Request </p>
            </a>
        </div>


        <div class="contents-support">
            <!-- FAQ Section -->
            <section id="FAQ" style="padding-top:70px;">
                <div>
                    <h3 style="color:#343032"> F.A.Q </h3>
                    <hr>

                    <h6>
                        Any further plan for this year?
                    </h6>
                    <p>
                        I will focus on devloping low-code hardware/software to help IOT start-ups.
                        Many of these companies have trouble with supply of embedded engineers.
                        My new projects will hopefully ease up the HW/FW prototyping stages,
                        which would encouge more entrepreneurs to try new idea without financial
                        burdens.
                        <br><br>
                    </p>

                    <h6> Why are some source codes of your project not available?</h6>
                    <img src="https://i.kym-cdn.com/photos/images/newsfeed/001/062/734/964.jpg"
                        style="width:300px; height:300px;">
                    <p>
                        <br>
                        By my own laziness, I pushed some personal credentials to some of my Github
                        repositories. I deleted existing repositories and made a fresh one with according
                        ignore parameters. Some works got lost in the way. Sorry!
                    </p>
                </div>
            </section>


            <!-- Request Section -->
            <section id="request_view" style="padding-top:70px;">
                <div>
                    <h3 style="color:#343032"> Make your requests here! </h3>
                    <hr>
                    <p>
                        I am currently occupied with work and my own projects. <br>
                        If you need my help in building something, please make your request in the form below!
                        If the job's small enough and suits my taste, I may be able to assist you in my free time.
                        I will most likely ask for compensation, of course.<br><br>
                    </p>

                    <p style="color:red;"> Note </p>

                    <p>
                        I may waiver the fee for projects that are also of my personal benefit.
                        <br>
                    </p>

                    <form class="w-100" action="/support_request" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" id="postToken" name="postToken">

                        <label>Category </label><br>
                        <select id="type" name="type" style="margin-bottom:20px;">
                            <option value="REPAIR"> Repair </option>
                            <option value="TECH_SUPPORT"> Tech Support </option>
                            <option value="REFUND"> Refund </option>
                            <option value="LEGAL"> Legal </option>
                        </select>

                        <label for="email">Your Email</label><br>
                        <input class="input-small" type="text" id="email" name="email"><br><br>

                        <label for="contents">State Your Issues</label><br>
                        <textarea id="summernote" name="contents"></textarea><br>
                        <input class="btn btn-info btn-form-submit" type="button" value="submit"
                            onclick="submit_request();">
                    </form>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer -->
    @include('includes.layouts.footer')


    <script>
        /* Initialize Summernote */
        $('#summernote').summernote({
            placeholder: 'State your issues',
            tabsize: 4,
            width: 600,
            height: 300,
            codemirror: {
                mode: 'text/html',
                htmlMode: true,
                lineNumbers: true,
                theme: 'darkly'
            }
        });
    </script>
</body>


</html>
