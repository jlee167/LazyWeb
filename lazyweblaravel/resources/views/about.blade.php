<!doctype html>

<html>
	<head>
        @include('includes.imports.styles_common')
	</head>

	<body>
        @include('includes.layouts.navbar')

		<script src="js/auth_helpers.js"></script>
		<script>
			var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>


        <!-- Personal Info -->
        <div class="section-contents">
            <div style="overflow:hidden; width:100%;">
                <div style="overflow:hidden; min-width:200px; width:20%; position:fixed;background-color:#e25132; height:100%; display:flex; flex-direction:column; justify-content: center; text-align:center;">
                    <a href="#overview" style="color:white;"> <h2 class="mb-5"><b>Overview</b> <br></h2></a>
                    <a href="#rtl" style="color:white;">  <h2 class="mb-5"><b>RTL</b><br></h2> </a>
                    <a href="" style="color:white;"> <h2 class="mb-5"> <b>Hardware</b><br></h2> </a>
                    <a href="" style="color:white;">  <h2 class="mb-5"><b>Software</b><br></h2> </a>
                </div>

                <div style="overflow:hidden; width:80%;float:right;">
                    <div style="overflow:hidden; max-width:1200px;float:center; padding-left:50px; padding-top:50px;">
                        <section id="overview">
                            <h2 class="mb-3" style="color:#5a5a5a;"> <b> Overview  </b></h2>

                            <div class="subheading mb-3">Things to know...</div>
                            <ul class="fa-ul mb-3">
                                <li class="fa-li fa fa-check"> Entry-level RTL engineer with ~2 years of experience</li>
                                <li class="fa-li fa fa-check"> Yes, this is an one-man business </li>
                                <li class="fa-li fa fa-check"> Jack of all trades, Master of none. Do not expect expert-level works. I will focus on assisting entry level makers for the time being </li>
                                <li class="fa-li fa fa-check"> Details about my work outside of Lazyboy (my 40hr/week job) will not be shared nor will they be invoved in my efforts within Lazyboy in any way </li>
                            </ul>

                            <h4 style="color:#5a5a5a;margin-top:30px;"> <b> HDL / Software  </b></h2>
                            <table style="text-align:center; width:100%;">
                                <tr style="background-color:navy; color:white;">
                                    <td colspan=2>Digital <br>Hardware</td>
                                    <td colspan=2>Hardware<br>Languages</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Artix7/Kintex7<br>Zynq Ultrascale+<br>Spartan<br>Lattice FPGA<br>Cortex-M<br>Cortex-A</td>
                                    <td>
                                        <span class="badge badge-success">Proficient</span><br>
                                        <span class="badge badge-warning">Intermediate</span><br>
                                        <span class="badge badge-warning">Intermediate</span><br>
                                        <span class="badge badge-warning">Intermediate</span><br>
                                        <span class="badge badge-danger">Retrainable</span><br>
                                        <span class="badge badge-danger">Retrainable</span><br>
                                    </td>
                                    <td>Systemverilog<br>Verilog<br>VHDL<br><br><br><br></td>
                                    <td>
                                        <span class="badge badge-success">Proficient</span><br>
                                        <span class="badge badge-success">Proficient</span><br>
                                        <span class="badge badge-danger">Beginner</span><br><br><br><br>
                                    </td>
                                </tr>
                            </table>


                            <h4 style="color:#5a5a5a;margin-top:30px;"> <b> HDL / Software  </b></h2>
                                <table style="text-align:center; width:100%;">
                                    <tr style="background-color:navy; color:white;">
                                        <td colspan=2>Software<br>Languages</td>
                                        <td colspan>Platforms / OS</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>C<br>C++<br>Python<br>Java<br>C#<br>x86/ARM assembly<br></td>
                                        <td><span class="badge badge-warning">Intermediate</span><br>
                                            <span class="badge badge-warning">Intermediate</span><br>
                                            <span class="badge badge-warning">Intermediate</span><br>
                                            <span class="badge badge-danger">Beginner</span><br><span class="badge badge-danger">Beginner</span><br><span class="badge badge-danger">Retrainable</span><br></td>
                                        <td> Desktop Linux<br>Embedded Linux<br>Android<br>Misc RTOS <br>Windows<br><br></td>
                                    </tr>
                                </table>

                            <h4 style="color:#5a5a5a;margin-top:30px;"> <b> Skillsets / Protocol Knowledges  </b></h2>
                            <table style="text-align:center; width:100%;">
                                <tr style="background-color:navy; color:white;">
                                    <td colspan=5>Skills/Tools</td>
                                    <td colspan=1>Layer 1/2 Protocols<td>
                                    <td colspan=1>Misc Protocols<td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Digital Electronics<br>Analog Electronics<br>CMOS Circuit<br>PCB Artwork<br>Firmware<br>Device Driver<br><br></td>
                                    <td>Embedded Linux<br>Digital Camera<br>ASIC<br>Giga Trancievers<br>LVDS<br>IO Serdes<br><br></td>
                                    <td>Qt5 GUI<br>.NET Windows GUI<br>Android Mobile Dev<br>Basic Networking<br><br><br><br></td>
                                    <td>Atmel SAM / TI C2000<br>Cortex-A Processors w/Linux<br>Logic Analyzer<br>Oscilloscope<br>Beagle Analyzer<br><br><br></td>
                                    <td> </td>
                                    <td>UART<br>I2C<br>SPI<br>USB 1.0/2.0<br>Ethernet<br>IR Light Communication<br>MIPI/Parallel<br>Camera Interface</td>
                                    <td></td>
                                    <td>TCP<br>UDP<br><br><br><br><br><br><br></td>
                                </tr>
                            </table>

                            <h4 style="color:#5a5a5a;margin-top:30px;"> <b> Web / Server </b></h2>
                            <table style="">
                                    <td>
                                        <table style="text-align:center; vertical-align:top;">
                                            <tr style="background-color:navy; color:white;">
                                                <td colspan=5>Languages</td>
                                            </tr>

                                            <tr>
                                                <td>HTML<br>CSS<br>Javascript<br>PHP</td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td style="text-align:center; vertical-align:top;">
                                        <table style="text-align:center; vertical-align:top;">
                                            <tr style="background-color:navy; color:white;">
                                                <td colspan=5>Databases</td>
                                            </tr>
                                            <tr>
                                                <td>MySQL<br>MongoDB</td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td style="text-align:center; vertical-align:top;">
                                        <table style="text-align:center; vertical-align:top;">
                                            <tr style="background-color:navy; color:white;">
                                                <td colspan=5>General Skills/Tools</td>
                                            </tr>
                                            <tr>
                                                <td>Bootstrap<br>Apache<br>REST API</td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td style="text-align:center; vertical-align:top;">
                                        <table style="text-align:center; vertical-align:top;">
                                            <tr style="background-color:navy; color:white;">
                                                <td colspan=5>Platforms/Frameworks</td>
                                            </tr>
                                            <tr>
                                                <td>Laravel<br>NodeJS</td>
                                            </tr>
                                        </table>
                                    </td>
                            </table>
                        </section>

                        <section id="rtl" style="margin-top:50px;">
                            <hr class="my-4">
                            <h2 class="mb-3" style="color:#5a5a5a;"> <b> RTL / FPGA </b></h2>
                        </section>

                        <section id="hardware" style="margin-top:50px;">
                            <hr class="my-4">
                            <h2 class="mb-3" style="color:#5a5a5a;"> <b> Hardware </b></h2>
                        </section>

                        <section id="software" style="margin-top:50px;">
                            <hr class="my-4">
                            <h2 class="mb-3" style="color:#5a5a5a;"> <b> Software </b></h2>
                        </section>
                </div>
            </div>
        </div>

	</body>
</html>
