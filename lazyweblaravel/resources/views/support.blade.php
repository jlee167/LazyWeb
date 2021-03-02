<!doctype html>

<html>

<head>
    @include('includes.imports.styles_common')

    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
</head>




<body>
    <script src="/js/auth_helper.js"></script>
    <script>
        var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
    </script>

    @include('includes.layouts.navbar')

    <div class="section-contents" style="overflow:visible; display:flex; flex-direction:row;
                                            background-color:rgb(250, 202, 246); ">
        <div id="support_sidebar" class="resume-sidebar" style="background-color:#9a6ea5;
                                                                width:70px;
                                                                min-height:100vh;
                                                                height:auto;
                                                                flex-direction:column;
                                                                text-align:center;
                                                                margin-top:0px;
                                                                ">

            <a style="display:flex; flex-direction:column; margin-top:40px; pointer-events: none;"
                href="https://www.google.com">
                <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}"
                    style="margin:auto; width:32px; height:32px;">
                <p style="margin:auto;color:white; line-height:12px; font-size:12px; margin-top:5px;">FAQ</p>
            </a>

            <a style="display:flex; flex-direction:column; margin-top:40px; pointer-events: none;"
                href="https://www.google.com">
                <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}"
                    style="margin:auto; width:32px; height:32px;">
                <p style="margin:auto; color:white; line-height:12px; font-size:12px; margin-top:5px; ">Make a Request
                </p>
            </a>
        </div>





        <!--
        Main Contents Section

        Conditional Rendering
        @Views      FAQ, Request
        @Condition  Button Click from sidebar
        @Trigger    (id:'support_sidebar')
        -->
        <div style="width:80%; display:flex; margin-top:30px; margin-left:5%;">
            <!-- FAQ View -->
            <div>
            </div>


            <!-- Request View -->
            <div>
                <h3 style="color:#343032"> Make your requests here! </h3>
                <hr>
                <p>
                    I am currently occupied with work and my own projects. <br>
                    If you need my help in building something, please make your request in the form below! <br>
                    If the job's small enough and suits my taste, I may be able to assist you in my free time. <br>
                    I will most likely ask for compensation, of course.<br><br>
                </p>

                <p style="color:red;"> Note </p>

                <p>
                    I may waiver the fee
                    <br>
                </p>

                <form action="/support_request" enctype="multipart/form-data" method="POST" style="width:600px;">
                    @csrf
                    <input type="hidden" id="postToken" name="postToken">

                    <label style="width:100%; font-family: 'Nunito' !important;
                                                        font-weight: 650 !important;">Category </label><br>
                    <select id="type" name="type" style="margin-bottom:40px;">
                        <option value="REPAIR">Repair</option>
                        <option value="TECH_SUPPORT">Tech Support</option>
                        <option value="REFUND">Refund</option>
                        <option value="LEGAL">Legal</option>
                    </select>


                    <label for="contents" style="width:100%;
                                        font-family: 'Nunito' !important;
                                        font-weight: 650 !important;">
                        State Your Issues
                    </label><br>
                    <textarea id="summernote" name="contents" style="width:100%; height:60%;"></textarea><br>
                    <input class="btn btn-outline-info" type="button" value="submit" onclick="submit_request();"
                        style="float:right; width: 100px; margin-bottom:40px;">
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('includes.layouts.footer')



    <script>
        /* Initialize Summernote */
        $('#summernote').summernote({
            placeholder: 'State your issues',
            tabsize: 4,
            height: 300,
            codemirror: {
                mode: 'text/html',
                htmlMode: true,
                lineNumbers: true,
                theme: 'darkly'
            }
        });


        /**
         * Submit support request with information provided in the form
         *
         * @param   None
         * @return  None
         *
         */
        function submit_request(){

            /* Get user input from the form */
            var type_sel = document.getElementById("type");
            var type = type_sel.options[type_sel.selectedIndex].value;
            var text = document.getElementById("summernote").value;

            /* Acquire CSRF Token from server */
            var csrf = "{{ csrf_token() }}";

            /*  Submit support request with AJAX.
                This Javascript routine was used instead of form due to unnecessary page refresh. */
            var xmlRequest = new XMLHttpRequest();
            xmlRequest.open('POST', '/support_request', true);
            xmlRequest.setRequestHeader('Content-Type', 'application/json');
            xmlRequest.setRequestHeader('X-CSRF-TOKEN', csrf);

            xmlRequest.onload = function() {
                if (xmlRequest.responseText == 'true') {
                    window.alert("Your request has been submitted!");
                }
                window.location.href = '/views/support';
            }

            xmlRequest.send(
                JSON.stringify({
                    "type"      : String(type),
                    "contents"  : text
                })
            )
        }
    </script>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
