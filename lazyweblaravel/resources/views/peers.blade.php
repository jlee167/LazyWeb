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
                macro_protected: LABEL_PROTECTED
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
                });
            }
        };
        getProtecteesReq.send();

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
                    relationship:   LABEL_GUARDIAN
                });
            }
        };
        getGuardiansReq.send();


        /* -------------------------------------------------------------------------- */
        /*                         /Peer data extraction logic                        */
        /* -------------------------------------------------------------------------- */
    </script>

</body>

<!-----------------------------------------------------------------------------
                                     /Body
------------------------------------------------------------------------------->

</html>
