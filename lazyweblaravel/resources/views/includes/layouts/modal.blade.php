<!-- template for the modal component -->
<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-header">
                    <slot name="header">
                        <button class="modal-default-button" @click="$emit('close')">
                            OK
                          </button>
                    </slot>
                </div>

                <div class="modal-body">
                <slot name="body">
                </slot>
                </div>
            </div>
            </div>
        </div>
    </transition>
</script>

<!-- app -->
<div id="app">
    <!--button id="show-modal" @click="showModal = true">Show Modal</button-->
    <!-- use the modal component, pass in the prop -->
    <modal v-if="showModal" @close="showModal = false">
        <div slot="body">
            @include('resume-modal')
        </div>
    </modal>
</div>

<script>
    // register modal component
        Vue.component('modal', {
            template: '#modal-template'
        })

        // start app
        modalApp = new Vue({
            el: '#app',
            data: {
                showModal: false
            }
        })
</script>
