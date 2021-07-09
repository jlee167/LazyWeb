/**
 * Submit support request with information provided in the form
 *
 * @param   None
 * @return  None
 *
 */
window.submit_request = function() {

    /* Get user input from the form */
    var type_sel = document.getElementById("type");
    var type = type_sel.options[type_sel.selectedIndex].value;
    var text = document.getElementById("summernote").value;
    var contact = document.getElementById("email").value;

    /*  Submit support request with AJAX.
        This Javascript routine was used instead of form due to unnecessary page refresh. */
    var xmlRequest = new XMLHttpRequest();
    xmlRequest.open('POST', '/support_request', true);
    xmlRequest.setRequestHeader('Content-Type', 'application/json');
    xmlRequest.setRequestHeader('X-CSRF-TOKEN', csrf);

    xmlRequest.onload = function() {
        //console.log(xmlRequest.responseText);
        let res = JSON.parse(xmlRequest.responseText);
        if (res.result == true) {
            window.alert("Your request has been submitted!");
            document.getElementById("email").value = "";
            $("#summernote").summernote("reset");
        }
    };

    xmlRequest.send(
        JSON.stringify({
            "type": String(type),
            "contents": text,
            "contact": contact
        })
    );
}
