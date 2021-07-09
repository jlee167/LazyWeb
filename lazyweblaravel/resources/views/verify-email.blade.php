<html>

<head>
    @include('includes.imports.csrf')
    @include('includes.imports.styles_common')
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />

    <style>
        #container {
            overflow: visible;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100vw;
            min-height: 100vh;
        }
    </style>
</head>




<body>
    @include('includes.layouts.navbar')

    <div id="container" class="section-contents">
        <article>
            <h1>Verify Your Email</h1>
            <p>Email verification link has been sent to your email. <br> Please check your inbox.</p>
            <div class="form-group">
                <button class="btn btn-primary" onclick="requestNewEmail();"> Resend Email</button>
            </div>
        </article>
    </div>


    @include('includes.layouts.footer')
</body>

<script>
    function requestNewEmail() {
        fetch('/email/resend', {
            method:'get',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            }
        })
        .then(response => {
            if (response.status === 200){
                return response.json();
            }
        })
        .then(jsonData => {
            if (jsonData.result == true){
                window.alert("New verification link sent to your email!");
            } else {
                window.alert("Request failed!. Please contact admin!");
            }
        });
    }
</script>

</html>
