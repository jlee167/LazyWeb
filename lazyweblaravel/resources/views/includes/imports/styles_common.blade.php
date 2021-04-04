<!-- Import Bootstrap CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<!--  Import Custom stylesheets -->
<link rel="stylesheet" href="/css/layout_common.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
<!-- font-family: 'Anton', sans-serif; -->
<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
<!-- font-family: 'Lobster', cursive; -->
<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
<!-- font-family: 'Akaya Telivigala', cursive; -->
<link href="https://fonts.googleapis.com/css2?family=Akaya+Telivigala&display=swap" rel="stylesheet">

<!--  Metadata  -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Nanum+Pen+Script&display=swap" rel="stylesheet">

<!-- Modal Stylesheet -->
<link rel="stylesheet" href="/css/resume.css">

<!-- Initialize Vue Application -->
<script src="{{ mix('js/app.js') }}"></script>




<style>

/* -------------------------------------------------------------------------- */
/*              Source: https://vuejs.org/v2/examples/modal.html              */
/* -------------------------------------------------------------------------- */

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.95);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 80%;
        max-width: 1300px;
        margin: 0px auto;
        /*padding: 20px 30px;*/
        background-color: transparent;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header {
        margin: 0px 0px 0px 0px;
        padding: 0 0 0 0 !important;
        color: #42b983;
        background-color: transparent;
        border-bottom:0px !important;
    }

    .modal-body {
        /*margin: 10px 0; */
        padding: 0px 0px 0px 0px;
        margin: 0px 0px 0px 0px;
        background-color:white;
    }

    .modal-default-button {
        float: right;
    }

    /*
    * The following styles are auto-applied to elements with
    * transition="modal" when their visibility is toggled
    * by Vue.js.
    *
    * You can easily play with the modal transition by editing
    * these styles.
    */

    .modal-enter {
        opacity: 0.5;
    }

    .modal-leave-active {
        opacity: 0.5;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>
