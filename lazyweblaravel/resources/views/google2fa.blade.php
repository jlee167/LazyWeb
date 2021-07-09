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
            <form>
                <div class="form-group">
                    <small id="hint" class="form-text text-muted">Enter your 6 digit OTP number.</small>
                    <input id="otpSecret" class="form-control" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">submit</button>
                </div>
            </form>
        </article>
    </div>


    @include('includes.layouts.footer')
</body>


</html>
