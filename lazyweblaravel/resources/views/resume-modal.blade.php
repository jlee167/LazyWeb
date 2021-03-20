    <!-- Personal Info -->
    <div id="resume-contents" class="section-contents" style="padding-top:0px; height:80vh;">
        <div style="width:100%; height:100%; display:flex; overflow-y:scroll;">
            <div class="resume-sidebar" style="overflow-y:hidden; position:fixed; background-color:#bc5c3c; height:80%;
                                                    display:inline-flex; flex-direction:column; justify-content: center;
                                                    text-align:center; margin-top:0px;">
                <div style="display:flex; flex-direction:row; justify-content:center; overflow:hidden;">
                    <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}"
                        style="min-width:120px; min-height:120px;">
                </div>
                <h2 class="title-font"
                    style="font-weight:600; font-family: 'Nunito Sans', sans-serif; margin-bottom:7px;"> LazyBoy </h2>
                <hr style="border-top: 1px solid; width:80%; border-width:1px; color:white;">
                <a href="#profile" style="color:white;">
                    <h5 class="mb-3"><b>Overview</b> <br></h2>
                </a>
                <a href="#skills" style="color:white;">
                    <h5 class="mb-3"><b>Skills</b><br></h2>
                </a>
                <a href="#rtl" style="color:white;">
                    <h5 class="mb-3"><b>RTL</b><br></h2>
                </a>
                <a href="#hardware" style="color:white;">
                    <h5 class="mb-3"> <b>Hardware</b><br></h2>
                </a>
                <a href="#software" style="color:white;">
                    <h5 class="mb-3"><b>Software</b><br></h2>
                </a>

                <hr style="border-top: 1px solid; width:80%; border-width:1px; color:white;">
                <h3 class="title-font"> Contact </h3>
                <div style="display:flex; flex-direction:row; justify-content:center;">
                    <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="width:32px; height:32px;">
                </div>
            </div>

            <div class="resume-contents" style="display:inline-block; margin-top:0px;">
                <div style="overflow:hidden;">
                    <section id="profile">
                        <h2 class="mb-6" style="color:#343032;"> <b> Profile </b></h2>
                        <hr style="border-width:3px; color:#d6c102;">
                        <p>
                            I am an RTL engineer with a little over 2 years of experience. My current work is closely
                            related to self-driving, in which I was in charge of develping FPGA logic core and designing
                            hardware.
                            My area of interests include video/image processing, RF engineering, IoT,
                            and education.

                            Details of my current work and personal information is not available at this time
                            due to a need for anonymity.
                        </p>
                    </section>


                    <section id="">

                    </section>


                    <section class="section-margin" id="skills">
                        <h2 class="mb-7" style="color:#343032;"> <b> Skills </b></h2>
                        <hr style="border-width:3px; color:#d6c102;">
                        <div class="sub-section-margin" style="overflow:hidden;">
                            <h4 style="color:#343032;margin-top:30px;"> <b> Digital Logics </b></h4>
                            <table style="display: inline-block; vertical-align:top;  overflow: hidden;">
                                <tr style="">
                                    <td colspan="1" style="border-right:1px solid;">
                                        <h5 style="text-align:center; color:#343032;">Languages</h3>
                                    </td>
                                    <td colspan="2">
                                        <h5 style="text-align:center; color:#343032;">Platforms</h3>
                                    </td>


                                </tr>
                                <tr>
                                    <td
                                        style="padding-top:20px; padding-bottom:20px;
                                                        padding-left:20px; padding-right:20px; border-right:1px solid;">
                                        <p style="display:inline-block; margin-bottom:0px;">Sytemverilog</p>
                                        <br>
                                        <skill-bar v-bind:level='2'></skill-bar><br>
                                        <p style="display:inline-block; margin-bottom:0px;">Verilog</p>
                                        <br>
                                        <skill-bar v-bind:level='2'></skill-bar><br>
                                        <p style="display:inline-block; margin-bottom:0px;">VHDL</p>
                                        <br>
                                        <skill-bar v-bind:level='0'></skill-bar><br>
                                    </td>
                                    <td style="padding-top:20px; padding-bottom:20px;
                                                    padding-left:20px; padding-right:20px;">
                                        <p style="display:inline-block; margin-bottom:0px;">Artix7/Kintex7</p>
                                        <br>
                                        <skill-bar v-bind:level='2'></skill-bar><br>
                                        <p style="display:inline-block; margin-bottom:0px;">Zynq Ultrascale+</p>
                                        <br>
                                        <skill-bar v-bind:level='1'></skill-bar><br>
                                        <p style="display:inline-block; margin-bottom:0px;">Lattice FPGA</p>
                                        <br>
                                        <skill-bar v-bind:level='0'></skill-bar><br>
                                    </td>
                                    <td style="padding-top:20px; padding-bottom:20px;
                                                    padding-left:20px; padding-right:20px; vertical-align:top;">
                                        <p style="display:inline-block; margin-bottom:0px;">Cortex-M</p>
                                        <br>
                                        <skill-bar v-bind:level='1'></skill-bar><br>
                                        <p style="display:inline-block; margin-bottom:0px;">Cortex-A</p>
                                        <br>
                                        <skill-bar v-bind:level='0'></skill-bar><br>
                                    </td>
                                </tr>
                            </table>
                        </div>


                        <h4 style="color:#343032;margin-top:30px;"> <b> Software </b></h4>
                        <table style="display: inline-block; vertical-align:top;
                                        margin-right:30px;">
                            <tr style="">
                                <td colspan="2">
                                    <h3 style="text-align:center; color:#343032;">Languages</h3>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:20px; padding-bottom:20px;
                                                padding-left:20px; padding-right:20px;">
                                    <p style="display:inline-block; margin-bottom:0px;">C</p>
                                    <br>
                                    <skill-bar v-bind:level='1'></skill-bar><br>
                                    <p style="display:inline-block; margin-bottom:0px;">C++</p>
                                    <br>
                                    <skill-bar v-bind:level='0'></skill-bar><br>
                                    <p style="display:inline-block; margin-bottom:0px;">Python</p>
                                    <br>
                                    <skill-bar v-bind:level='1'></skill-bar><br>
                                </td>


                                <td style="padding-top:20px; padding-bottom:20px;
                                                padding-left:20px; padding-right:20px; vertical-align:top;">
                                    <p style="display:inline-block; margin-bottom:0px;">Java</p>
                                    <br>
                                    <skill-bar v-bind:level='0'></skill-bar><br>
                                    <p style="display:inline-block; margin-bottom:0px;">C#</p>
                                    <br>
                                    <skill-bar v-bind:level='0'></skill-bar><br>
                                    <p style="display:inline-block; margin-bottom:0px;">x86/ARM Assembly</p>
                                    <br>
                                    <skill-bar v-bind:level='0'></skill-bar><br>
                                </td>
                            </tr>
                        </table>

                        <table style="display: inline-block; vertical-align:top;
                                        margin-right:30px;">
                            <tr style="">
                                <td style="padding-left:20px; padding-right:20px;">
                                    <h3 style="text-align:center; color:#343032;">Platforms</h3>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:20px; padding-bottom:20px; text-align:center;">
                                    <p style="display:inline-block; margin-bottom:0px;">Linux</p>
                                    <br>
                                    <p style="display:inline-block; margin-bottom:0px;">Android</p>
                                    <br>
                                    <p style="display:inline-block; margin-bottom:0px;">RTOS</p>
                                    <br>
                                    <p style="display:inline-block; margin-bottom:0px;">Windows</p>
                                </td>

                            </tr>
                        </table>




                        <h4 style="color:#343032;margin-top:30px;"> <b> Skillsets / Protocol Knowledges </b></h2>
                            <table style="text-align:center; width:100%;">
                                <tr style="background-color:navy; color:white;">
                                    <td colspan=5>Skills/Tools</td>
                                    <td colspan=1>Layer 1/2 Protocols
                                    <td>
                                    <td colspan=1>Misc Protocols
                                    <td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Digital Electronics<br>Analog Electronics<br>CMOS Circuit<br>PCB
                                        Artwork<br>Firmware<br>Device Driver<br><br></td>
                                    <td>Embedded Linux<br>Digital Camera<br>ASIC<br><br></td>
                                    <td>Qt5 GUI<br>.NET Windows GUI<br>Android Mobile Dev<br>Basic
                                        Networking<br><br><br><br></td>
                                    <td>Atmel SAM / TI C2000<br>Cortex-A Processors w/Linux<br>Logic
                                        Analyzer<br>Oscilloscope<br>Beagle Analyzer<br><br><br></td>
                                    <td> </td>
                                    <td>UART<br>I2C<br>SPI<br>USB 1.0/2.0<br>Ethernet<br>IR Light
                                        Communication<br>MIPI/Parallel<br>Camera Interface</td>
                                    <td></td>
                                    <td>TCP<br>UDP<br><br><br><br><br><br><br></td>
                                </tr>
                            </table>

                            <h4 style="color:#343032;margin-top:30px;"> <b> Web / Server </b></h2>

                                <table style="display: inline-block; vertical-align:top;
                                        margin-right:30px;">
                                    <tr style="">
                                        <td>
                                            <h3 style="text-align:center; color:#343032">Languages</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:20px; padding-bottom:20px;
                                                padding-left:20px; padding-right:20px;">
                                            <p style="display:inline-block; margin-bottom:0px;">HTML</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                            <p style="display:inline-block; margin-bottom:0px;">CSS</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                            <p style="display:inline-block; margin-bottom:0px;">Javascript</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                            <p style="display:inline-block; margin-bottom:0px;">PHP</p>
                                            <br>
                                            <skill-bar v-bind:level='1'></skill-bar><br>
                                        </td>

                                    </tr>
                                </table>

                                <table style="display: inline-block; vertical-align:top;
                                        margin-right:30px;">
                                    <tr style="">
                                        <td>
                                            <h3 style="text-align:center; color:#343032;">Database</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:20px; padding-bottom:20px;
                                                padding-left:20px; padding-right:20px;">
                                            <p style="display:inline-block; margin-bottom:0px;">MySQL / MariaDB</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                            <p style="display:inline-block; margin-bottom:0px;">MongoDB</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                            <p style="display:inline-block; margin-bottom:0px;">ArangoDB</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                        </td>

                                    </tr>
                                </table>

                                <table style="display: inline-block; vertical-align:top;
                                        margin-right:30px;">
                                    <tr style="">
                                        <td>
                                            <h3 style="text-align:center; color:#343032;">Skills / Tools</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:20px; padding-bottom:20px;
                                                padding-left:20px; padding-right:20px;">
                                            <p style="display:inline-block; margin-bottom:0px;">Bootstrap</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                            <p style="display:inline-block; margin-bottom:0px;">Apache</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                            <p style="display:inline-block; margin-bottom:0px;">REST API</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                        </td>

                                    </tr>
                                </table>


                                <table style="display: inline-block; vertical-align:top;
                                        margin-right:30px;">
                                    <tr style="">
                                        <td>
                                            <h3 style="text-align:center; color:#343032"> Frameworks</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:20px; padding-bottom:20px;
                                                    padding-left:20px; padding-right:20px;">
                                            <p style="display:inline-block; margin-bottom:0px;">Laravel</p>
                                            <br>
                                            <skill-bar v-bind:level='1'></skill-bar><br>
                                            <p style="display:inline-block; margin-bottom:0px;">NodeJS</p>
                                            <br>
                                            <skill-bar v-bind:level='0'></skill-bar><br>
                                        </td>
                                    </tr>
                                </table>
                    </section>


                    <section id="rtl" style="margin-top:50px;">

                        <h2 class="mb-3" style="color:#343032;"> <b> RTL / FPGA </b></h2>
                        <hr>
                        <p>
                            I have worked on many small-sized digital projects since college.
                            My first significant (depends on your standard for 'significant' ...) project was an
                            FPGA to digital camera (OV7670) interface
                        </p>
                    </section>

                    <section id="hardware" style="margin-top:50px;">
                        <h2 class="mb-3" style="color:#343032;"> <b> Hardware </b></h2>
                        <hr>
                    </section>

                    <section id="software" style="margin-top:50px;">
                        <h2 class="mb-3" style="color:#343032;"> <b> Software </b></h2>
                        <hr>

                    </section>
                </div>
            </div>
        </div>
    </div>


    <script>
        const app = new Vue({
            el: '#resume-contents'
        });
    </script>
