<html>

<!-----------------------------------------------------------------------------
                                     Head
------------------------------------------------------------------------------->

<head>
    @include('includes.imports.styles_common')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
</head>

<!-----------------------------------------------------------------------------
                                     /Head
------------------------------------------------------------------------------->




<!-----------------------------------------------------------------------------
                                     Body
------------------------------------------------------------------------------->
<body>
    @include('includes.layouts.navbar')

    <div id="peers-view" class="section-contents" style="overflow:visible; display:flex; flex-direction:row;
        background-color:rgb(250, 202, 246); width:100vw; min-height:100vh;">
        <peer-list
            v-bind:contents="contents"
            v-bind:macro_guardian="macro_guardian"
            v-bind:macro_protected="macro_protected"
            v-bind:callback_request_guardian="addGuardianFunc"
            v-bind:callback_request_protected="addProtectedFunc"
            v-bind:callback_refresh_ui = "refreshUiFunc"
        >
        </peer-list>
    </div>
    @include('includes.layouts.footer')
    @include('includes.layouts.modal')

    <script>
        /* -------------------------------------------------------------------------- */
        /*                                   Vue App                                  */
        /* -------------------------------------------------------------------------- */

        /* Some macros for peer list UI */
        const LABEL_GUARDIAN    = "GUARDIAN";
        const LABEL_PROTECTED   = "PROTECTED";

        peerApp = new Vue({
            el: '#peers-view',

            data: {
                contents: [],
                macro_guardian: LABEL_GUARDIAN,
                macro_protected: LABEL_PROTECTED,
                addGuardianFunc: addGuardian,
                addProtectedFunc: addProtected,
                refreshUiFunc: refreshUI
            },

            mounted: function(){
            }
        });

        /* -------------------------------------------------------------------------- */
        /*                                   /Vue App                                 */
        /* -------------------------------------------------------------------------- */






        /* -------------------------------------------------------------------------- */
        /*                         Peer data extraction logic                         */
        /* -------------------------------------------------------------------------- */
        const csrf = "{{ csrf_token() }}";
        const URI_GUARDIAN  = "/members/guardian/";
        const URI_PROTECTED = "/members/protected/";

        function xhttpRequest(reqType, uri, data, callback){
            var req = new XMLHttpRequest();
            req.open(reqType, uri);
            req.setRequestHeader('Content-Type', 'application/json');
            req.setRequestHeader('X-CSRF-TOKEN', csrf);
            req.onload = function() {
                callback(req);
            }
            req.send(data);
        }




        function refreshUI(){
            peerApp.contents = [];

            xhttpRequest('GET', '/pending_requests', null, function(req){
                //@Todo: Replace with client-side code
                <?php
                    echo "var uid = " . Auth::id() . ";";
                ?>
                var res = JSON.parse(req.responseText);
                console.log(res);
                if (res) {
                    for (var iter = 0; iter < res.length; iter++){
                        if (res[iter].uid_guardian == uid)
                            peerApp.contents.push({
                                uid:            res[iter].uid_protected,
                                username:       res[iter].uid_protected,
                                relationship:   LABEL_PROTECTED,
                                status:         'FINE',
                                authorized:     false
                            });
                        else if (res[iter].uid_protected == uid)
                            peerApp.contents.push({
                                uid:            res[iter].uid_guardian,
                                username:       res[iter].uid_guardian,
                                relationship:   LABEL_GUARDIAN,
                                status:         'FINE',
                                authorized:     false
                            });
                        console.log(res[iter].uid_guardian);
                    }
                }
            });


            /* Get guardian list and pass to Vue app */
            let getGuardiansReq = new XMLHttpRequest();
            getGuardiansReq.open('GET', '/members/guardian/all');
            getGuardiansReq.setRequestHeader('Content-Type', 'application/json');
            getGuardiansReq.setRequestHeader('X-CSRF-TOKEN', csrf);
            getGuardiansReq.onload = function() {
                console.log(getGuardiansReq.responseText);
                var guardians = JSON.parse(getGuardiansReq.responseText);

                for (var iter = 0; iter < guardians.length; iter++){
                    console.log(guardians[iter].id);
                    console.log(guardians[iter].username);
                    peerApp.contents.push({
                        uid:            guardians[iter].id,
                        username:       guardians[iter].username,
                        relationship:   LABEL_GUARDIAN,
                        authorized:     true
                    });
                }
            };
            getGuardiansReq.send();


            /* Get protecteds list and pass to Vue app */
            let getProtecteesReq = new XMLHttpRequest();
            getProtecteesReq.open('GET', '/members/protected/all');
            getProtecteesReq.setRequestHeader('Content-Type', 'application/json');
            getProtecteesReq.setRequestHeader('X-CSRF-TOKEN', csrf);
            getProtecteesReq.onload = function() {
                console.log(getProtecteesReq.responseText);
                var protectees = JSON.parse(getProtecteesReq.responseText);

                for (var iter = 0; iter < protectees.length; iter++){
                    console.log(protectees[iter].id);
                    console.log(protectees[iter].username);
                    console.log(protectees[iter].status);
                    peerApp.contents.push({
                        uid:            protectees[iter].id,
                        username:       protectees[iter].username,
                        relationship:   LABEL_PROTECTED,
                        status:         protectees[iter].status,
                        authorized:     true
                    });
                }
            };
            getProtecteesReq.send();
        }

        refreshUI();
        /* -------------------------------------------------------------------------- */
        /*                         /Peer data extraction logic                        */
        /* -------------------------------------------------------------------------- */






        /* -------------------------------------------------------------------------- */
        /*                           Peer Request Functions                           */
        /* -------------------------------------------------------------------------- */

        function getUid(username, callback) {
            xhttpRequest('GET', '/members/uid/'+username, null, function(req){
                var res = JSON.parse(req.responseText)[0];
                if(!res) {
                    window.alert('User not found');
                    return false;
                }

                if (res.hasOwnProperty('id')) {
                    console.log(res.id);
                    if (callback)
                        callback(res.id);
                    return res.id;
                }
                else {
                    window.alert('User not found');
                    return false;
                }
            });
        }


        function requestGuardianship(peer, uri){
            getUid(peer, function(uid){
                if (uid) {
                    console.log('h' + uid);
                    xhttpRequest('POST', uri + uid, null, function(req){
                        console.log(req.responseText);
                        var res = JSON.parse(req.responseText);
                        if (res.status == "ok")
                            console.log("pass");
                        else
                            console.log(req.responseText);
                    });
                }
            });
        }


        function addProtected(peer){
            requestGuardianship(peer, URI_PROTECTED);
        }


        function addGuardian(peer){
            requestGuardianship(peer, URI_GUARDIAN);
        }

        /* -------------------------------------------------------------------------- */
        /*                          /Peer Request Functions                           */
        /* -------------------------------------------------------------------------- */
    </script>

</body>

<!-----------------------------------------------------------------------------
                                     /Body
------------------------------------------------------------------------------->

</html>
