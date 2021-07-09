<!-- Personal Info -->
<div style="overflow:hidden; max-width: 80vw; height:80vh;">
    <div style="width:100%; height:100%; display:flex; overflow:hidden;">
        <article class="resume-sidebar">
            <div style="display:flex; flex-direction:row; justify-content:center; overflow:hidden;">
                <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="min-width:120px; min-height:120px;">
            </div>
            <h2 class="title-font"> LazyBoy </h2>
            <hr class="divider-sidebar">

            <a class="section-link" href="#profile">
                <h5 class="mb-3"><b>Overview</b> </h5>
            </a>
            <a class="section-link" href="#rtl">
                <h5 class="mb-3"><b>RTL / Digital</b></h5>
            </a>
            <a class="section-link" href="#hardware">
                <h5 class="mb-3"> <b>Hardware</b></h5>
            </a>
            <a class="section-link" href="#software">
                <h5 class="mb-3"><b>Software</b></h5>
            </a>
        </article>

        <article class="resume-contents">
            <div>
                <section id="profile" class="no-overflow-x">
                    <h2 class="mb-6" style="color:#343032;"> <b> Profile </b></h2>
                    <hr class="section-title-underline">
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


                <section id="rtl" class="section-margin no-overflow-x">
                    <h2 class="mb-7" style="color:#343032;"> <b> RTL / Digital Logics </b></h2>
                    <hr class="section-title-underline">

                    <div class="container-skillset">
                        <h5 class="label-skillset">Hardware Languages</h5>
                        <div v-for="skill in hdlSkills" class="container-skill">
                            <p class="label-skill" style="margin-top:10px; width:100%;">@{{skill.name}}</p>
                            <skill-bar v-bind:level=skill.level style="margin-bottom:0px;"></skill-bar>
                        </div>
                    </div>

                    <div class="container-skillset">
                        <h5 class="label-skillset">Digital Platforms</h5>
                        <div v-for="platform in digitalPlatforms" style="align-self: center;">
                            <p class="label-skill" style="margin-top:5px; width:100%;">@{{platform}}</p>
                        </div>
                    </div>

                    <div class="container-skillset">
                        <h5 class="label-skillset">Protocols</h5>
                        <div v-for="platform in digitalProtocols" style="align-self: center;">
                            <p class="label-skill" style="margin-top:5px; width:100%;">@{{platform}}</p>
                        </div>
                    </div>
                </section>


                <section id="hardware" class="section-margin no-overflow-x">
                    <h2 class="mb-3" style="color:#343032;"> <b> Hardware </b></h2>
                    <hr class="section-title-underline">
                    <div class="container-skillset">
                        <h5 class="label-skillset">Skills</h5>
                        <div v-for="skill in hardwareSkills" class="container-skill">
                            <p class="label-skill" style="margin-top:10px; width:100%;">@{{skill.name}}</p>
                            <skill-bar v-bind:level=skill.level style="margin-bottom:0px;"></skill-bar>
                        </div>
                    </div>

                    <div class="container-skillset">
                        <h5 class="label-skillset">Standards</h5>
                        <div v-for="platform in hardwareStandards" style="align-self: center;">
                            <p class="label-skill" style="margin-top:5px; width:100%;">@{{platform}}</p>
                        </div>
                    </div>

                    <div class="container-skillset">
                        <h5 class="label-skillset">Tools</h5>
                        <div v-for="platform in hardwareTools" style="align-self: center;">
                            <p class="label-skill" style="margin-top:5px; width:100%;">@{{platform}}</p>
                        </div>
                    </div>
                </section>

                <section id="software" class="section-margin no-overflow-x">
                    <h2 class="mb-3" style="color:#343032;"> <b> Software </b></h2>
                    <hr class="section-title-underline">

                    <div class="container-skillset">
                        <h5 class="label-skillset">Software Languages</h5>
                        <div v-for="skill in softwareSkills" class="container-skill">
                            <p class="label-skill" style="margin-top:10px; width:100%;">@{{skill.name}}</p>
                            <skill-bar v-bind:level=skill.level></skill-bar>
                        </div>
                    </div>

                    <div class="container-skillset">
                        <h5 class="label-skillset">Web Programming</h5>
                        <div v-for="skill in webProgramming" class="container-skill">
                            <p class="label-skill" style="margin-top:10px; width:100%;">@{{skill.name}}</p>
                            <skill-bar v-bind:level=skill.level></skill-bar>
                        </div>
                    </div>

                    <div class="container-skillset">
                        <h5 class="label-skillset">Databases</h5>
                        <div v-for="skill in databases" class="container-skill">
                            <p class="label-skill" style="margin-top:10px; width:100%;">@{{skill.name}}</p>
                            <skill-bar v-bind:level=skill.level></skill-bar>
                        </div>
                    </div>


                    <div class="container-skillset">
                        <h5 class="label-skillset">OS Platforms</h5>
                        <div v-for="platform in operatingSystems" style="align-self: center;">
                            <p class="label-skill" style="margin-top:5px; width:100%;">@{{platform}}</p>
                        </div>
                    </div>



                    <div class="container-skillset">
                        <h5 class="label-skillset">Web Framework / Tools</h5>
                        <div v-for="platform in webPlatforms" style="align-self: center;">
                            <p class="label-skill" style="margin-top:5px; width:100%;">@{{platform}}</p>
                        </div>
                    </div>
                </section>
            </div>
        </article>
    </div>
</div>
