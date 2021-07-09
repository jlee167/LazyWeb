<!----------------------------------------------------------------------
    Original Source: https://kr.vuejs.org/v2/examples/modal.html
------------------------------------------------------------------------
The MIT License (MIT)

Copyright (c) 2013-present Yuxi Evan You

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
-----------------------------------------------------------------------

----------------------------------------------------------------------->



<style>
    /* -------------------------------------------------------------------------- */
    /*              Source: https://vuejs.org/v2/examples/modal.html              */
    /* -------------------------------------------------------------------------- */
        .no-overflow-x{
            overflow-x:hidden;
        }

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

        p.label-skill {
            margin-top: 5px;
            margin-bottom: 0px;
            height:24px;
        }

        .table-skills {
            border-spacing:0px;
            border-collapse: separate;
            text-indent: initial;
            white-space: normal;
            line-height: normal;
            font-weight: normal;
            font-size: medium;
            font-style: normal;
            color: -internal-quirk-inherit;
            text-align: start;
            border-spacing: 2px;
            font-variant: normal;
            display: inline-block;
            vertical-align:top;
            overflow: hidden;
        }

        .container-skillset {
            display: inline-flex;
            flex-direction: column;
            margin-right:100px;
            margin-top: 10px;
            margin-bottom:40px;
        }

        .label-skillset {
            text-align:center;
            color:#343032;
            margin-bottom:10px;
            font-size:24px;
        }

        .container-skill {
            align-self: center;
            height:45px;
            margin-bottom:5px;
        }

        .skill-category {
            color:#343032;
            margin-top:30px;
            margin-bottom:20px;
        }

        @media only screen and (max-width: 768px) {
            .resume-sidebar {
                display: none;
            }
        }
</style>


<script type="text/x-template" id="resume-template">
    <transition name="modal">
        <div class="background">
            <div class="resume-wrapper">
            <div class="resume-container">
                <div class="resume-header">
                    <slot name="header">
                        <div
                            onclick="setTimeout(function(){document.body.style.overflowY = 'scroll';}, 500)"
                            class="btn btn-danger" @click="$emit('close')"
                            style="margin-bottom:20px;"
                        > Close </div>
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
            @include('includes.layouts.modal-contents')
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
            showModal: false,
            hdlSkills:
                [
                    {name:"SytemVerilog", level:3}
                    ,{name:"Verilog", level:3}
                    ,{name:"VHDL", level:0}
                ],

            softwareSkills:
                [
                    {name:"C", level:2}
                    ,{name:"C++", level:2}
                    ,{name:"Python", level:2}
                    ,{name:"Java", level:0}
                    ,{name:"C#", level:0}
                    ,{name:"ARM Assembly", level:0}
                ],

            hardwareSkills:
                [
                    {name:"Digital Electronics", level:2}
                    ,{name:"Analog Electronics", level:2}
                    ,{name:"PCB Artwork", level:2}
                    ,{name:"Signal Processing", level:0}
                    ,{name:"RF Design", level:0}
                    ,{name:"High Speed Design", level:0}
                ],

            hardwareStandards:
                [
                    "LVDS"
                    ,"SSTL"
                    ,"MIPI"
                    ,"DDR2/3"
                ],

            hardwareTools:
                [
                    "Oscilloscope",
                    "OrCAD",
                    "KiCAD",
                    "EagleCAD"
                ],

            digitalPlatforms:
                [
                    "Xilinx 7 Series",
                    "Zynq (Ultrascale)",
                    "Cortex-M (Atmel, STM32)",
                    "Lattice ICE40",
                    "Cortex-A"
                ],

            digitalProtocols:
                [
                    "UART",
                    "I2C",
                    "SPI",
                    "USB",
                    "Ethernet",
                    "MIPI D-Phy",
                    "Parallel Camera"
                ],

            operatingSystems:
                [
                    "Linux",
                    "Android",
                    "Windows",
                    "RTOS"
                ],

            webProgramming:
                [
                    {name:"HTML", level:0}
                    ,{name:"CSS", level:0}
                    ,{name:"Javascript", level:0}
                    ,{name:"PHP", level:2}
                ],

            webPlatforms:
                [
                    "Apache",
                    "NodeJS",
                    "Laravel Framework",
                    "Bootstrap"
                ],

            databases:
                [
                    {name:"MySql", level:2}
                    ,{name:"MongoDB", level:0}
                    ,{name:"Redis", level:0}
                    ,{name:"TigerGraph", level:0}
                ]
        }
    })
</script>


