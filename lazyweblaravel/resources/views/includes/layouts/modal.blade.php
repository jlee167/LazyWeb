<!-- template for the modal component -->
<script type="text/x-template" id="resume-template">
    <transition name="modal">
        <div class="background">
            <div class="resume-wrapper">
            <div class="resume-container">
                <div class="resume-header">
                    <slot name="header">
                        <div onclick="setTimeout(function(){document.body.style.overflowY = 'scroll';}, 500)" class="btn btn-danger" @click="$emit('close')">
                            OK
                        </div>
                    </slot>
                </div>

                <div class="resume-body">
                <slot name="body">
                </slot>
                </div>
            </div>
            </div>
        </div>
    </transition>
</script>


<div id="resumeApp">
    <modal v-if="showModal" @close="showModal = false">
        <div slot="body">
            @include('resume-modal')
        </div>
    </modal>
</div>

<script>
    // register modal component
        Vue.component('modal', {
            template: '#resume-template'
        })

        // start app
        modalApp = new Vue({
            el: '#resumeApp',
            data: {
                showModal: false
            }
        })
</script>

<style>
    /* -------------------------------------------------------------------------- */
    /*              Source: https://vuejs.org/v2/examples/modal.html              */
    /* -------------------------------------------------------------------------- */

        .background {
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

        .resume-wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .resume-container {
            width: 80%;
            max-width: 1300px;
            margin: 0px auto;
            background-color: transparent;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            font-family: Helvetica, Arial, sans-serif;
        }

        .resume-header {
            margin: 0px 0px 0px 0px;
            padding: 0 0 0 0 !important;
            color: #42b983;
            background-color: transparent;
            border-bottom:0px !important;
        }

        .resume-body {
            padding: 0px 0px 0px 0px;
            margin: 0px 0px 0px 0px;
            background-color:white;
        }

        .resume-default-button {
            float: right;
        }


        .transition-open {
            opacity: 0.5;
        }

        .transition-close {
            opacity: 0.5;
        }

        .transition-open .resume-container,
        .transition-close .resume-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
</style>
