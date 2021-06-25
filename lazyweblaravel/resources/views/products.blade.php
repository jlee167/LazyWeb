<!doctype html>

<html>


<head>
    @include('includes.imports.styles_common')

    <!------------------ include libraries(jQuery, bootstrap) ------------------>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
</head>



<body>
    @include('includes.layouts.navbar')

    <div id="products" class="vw-100 mw-100 navbar-offset">
        <product-desc-view
            v-bind:title="title"
            v-bind:description="description"
            v-bind:price="price"
            v-bind:img-url="imgUrl"
            v-bind:bg-color="bgColor"
            v-bind:bg-img-url="bgImgUrl"
        ></product-desc-view>
    </div>

    @include('includes.layouts.footer')
</body>


<script>
    app = new Vue({
        el: "#products",
        data: {
            title       : "USB Camera",
            description : "subHead",
            price       : 99.99,
            imgUrl      : "{{asset('/images/RTL.png')}}",
            bgColor     : String("bisque"),
            bgImgUrl    : "{{asset('/images/product_background.svg')}}",
            product1    :   {
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
