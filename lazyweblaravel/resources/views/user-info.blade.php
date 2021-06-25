<html>


<head>
    @include('includes.imports.styles_common')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
</head>





<body>
    @include('includes.layouts.navbar')

    <div class="section-contents" style="overflow:visible; display:flex; flex-direction:row;
                                         width:100vw; min-height:100vh;">
        <table>

        </table>
    </div>


    @include('includes.layouts.footer')
    @include('includes.layouts.modal')
</body>


<script>
    user_info = {
        id:
    };
</script>


</html>
