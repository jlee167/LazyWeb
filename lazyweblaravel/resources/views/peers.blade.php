<html>

<head>
    @include('includes.imports.csrf')
    @include('includes.imports.styles_common')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>

    <style>
        #peer-list-section {
            overflow-y: visible;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        #peer-page-content {
            width: 100vw;
            min-height: 100vh;
            padding-top: 70px;
            background-color: rgb(224, 224, 224);
        }
    </style>
</head>



<body>
    @include('includes.layouts.navbar')

    <div id="peer-page-content" class="section-contents">
        <article id="peer-list-section">
            <h1 style="margin:auto; margin-bottom: 50px;"> Peers </h1>
            <peer-list
                v-bind:contents="contents"
                v-bind:macro_guardian="macro_guardian"
                v-bind:macro_protected="macro_protected"
                v-bind:callback_request_guardian="addGuardianFunc"
                v-bind:callback_request_protected="addProtectedFunc"
                v-bind:callback_refresh_ui="refreshUiFunc"
                v-bind:callback_respond="respondFunc">
            </peer-list>
        </article>

        <article>

        </article>
    </div>
    @include('includes.layouts.footer')

    <script>
        /* ---------------------------- Page UI Settings ---------------------------- */
        const LABEL_GUARDIAN    = "GUARDIAN";
        const LABEL_PROTECTED   = "PROTECTED";


        /* -------------------------------------------------------------------------- */
        /*                                   Vue App                                  */
        /* -------------------------------------------------------------------------- */

        peerApp = new Vue({
            el: '#peer-list-section',

            data: {
                contents:           null,
                macro_guardian:     LABEL_GUARDIAN,
                macro_protected:    LABEL_PROTECTED,
                addGuardianFunc:    addGuardian,
                addProtectedFunc:   addProtected,
                respondFunc:        respondPeerRequest,
                refreshUiFunc:      refreshUI
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
        const URI_GUARDIAN  = "/members/guardian/";
        const URI_PROTECTED = "/members/protected/";

        let sort_mutex = false;

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

                if (res) {
                    for (var iter = 0; iter < res.length; iter++){
                        if (res[iter].uid_guardian == uid)
                            peerApp.contents.push({
                                requestID:      res[iter].id,
                                uid:            res[iter].uid_protected,
                                username:       res[iter].username,
                                relationship:   LABEL_PROTECTED,
                                status:         'FINE',
                                authorized:     false
                            });
                        else if (res[iter].uid_protected == uid)
                            peerApp.contents.push({
                                requestID:      res[iter].id,
                                uid:            res[iter].uid_guardian,
                                username:       res[iter].username,
                                relationship:   LABEL_GUARDIAN,
                                status:         'FINE',
                                authorized:     false
                            });
                    }
                }
            });


            /* Get guardian list and pass to Vue app */
            let getGuardiansReq = new XMLHttpRequest();
            getGuardiansReq.open('GET', '/members/guardian/all');
            getGuardiansReq.setRequestHeader('Content-Type', 'application/json');
            getGuardiansReq.setRequestHeader('X-CSRF-TOKEN', csrf);
            getGuardiansReq.onload = function() {
                var guardians = JSON.parse(getGuardiansReq.responseText);

                for (var iter = 0; iter < guardians.length; iter++){
                    peerApp.contents.push({
                        uid:            guardians[iter].id,
                        username:       guardians[iter].username,
                        image_url:      guardians[iter].image_url,
                        relationship:   LABEL_GUARDIAN,
                        authorized:     true
                    });
                }


                while(true) {
                    if (!sort_mutex) {
                        sort_mutex = true;
                        break;
                    }
                }

                peerApp.contents.sort(function(a,b){
                    return a.uid - b.uid;
                });

                for (let i = 0; i + 1 < peerApp.contents.length; i ++) {
                    if ((peerApp.contents[i].uid === peerApp.contents[i+1].uid) &&
                        peerApp.contents[i].authorized && peerApp.contents[i+1].authorized)
                    {
                        peerApp.contents[i].relationship = "DUAL";
                        peerApp.contents.splice(i+1, 1);
                    }
                }

                peerApp.contents.sort(function(a,b){
                    return Number(a.authorized) - Number(b.authorized);
                });

                sort_mutex = false;

                console.log(peerApp.contents);
            };
            getGuardiansReq.send();


            /* Get protecteds list and pass to Vue app */
            let getProtecteesReq = new XMLHttpRequest();
            getProtecteesReq.open('GET', '/members/protected/all');
            getProtecteesReq.setRequestHeader('Content-Type', 'application/json');
            getProtecteesReq.setRequestHeader('X-CSRF-TOKEN', csrf);
            getProtecteesReq.onload = function() {
                var protectees = JSON.parse(getProtecteesReq.responseText);

                for (var iter = 0; iter < protectees.length; iter++){
                    peerApp.contents.push({
                        uid:            protectees[iter].id,
                        username:       protectees[iter].username,
                        image_url:      protectees[iter].image_url,
                        relationship:   LABEL_PROTECTED,
                        status:         protectees[iter].status,
                        authorized:     true
                    });
                }


                while(true) {
                    if (!sort_mutex) {
                        sort_mutex = true;
                        break;
                    }
                }

                peerApp.contents.sort(function(a,b){
                    return a.uid - b.uid;
                });
                for (let i = 0; i + 1 < peerApp.contents.length; i ++) {
                    if ((peerApp.contents[i].uid === peerApp.contents[i+1].uid) &&
                        peerApp.contents[i].authorized && peerApp.contents[i+1].authorized)
                    {
                        peerApp.contents[i].relationship = "DUAL";
                        peerApp.contents.splice(i+1, 1);
                    }
                }
                peerApp.contents.sort(function(a,b){
                    return Number(a.authorized) - Number(b.authorized);
                });

                console.log(peerApp.contents);

                sort_mutex = false;
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
                    xhttpRequest('POST', uri + uid, null, function(req){
                        var res = JSON.parse(req.responseText);
                        if (res.status == "ok") {
                            window.location.reload();
                        }
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


        /* Get protecteds list and pass to Vue app */
        function respondPeerRequest(requestID, response){
            let peerRequestResponse = new XMLHttpRequest();
            peerRequestResponse.open('PUT', '/peer_request');
            peerRequestResponse.setRequestHeader('Content-Type', 'application/json');
            peerRequestResponse.setRequestHeader('X-CSRF-TOKEN', csrf);
            peerRequestResponse.onload = function() {
                console.log(peerRequestResponse.responseText);
                window.location.reload();
            };
            console.log(JSON.stringify({
                requestID:  requestID,
                response:   response
            }));
            peerRequestResponse.send(JSON.stringify({
                requestID:  requestID,
                response:   response
            }));
        }


        /* -------------------------------------------------------------------------- */
        /*                          /Peer Request Functions                           */
        /* -------------------------------------------------------------------------- */
    </script>

</body>


</html>
