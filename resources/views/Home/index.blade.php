@extends('Home.layouts.app')
@section('pageTitle')
    Mygrandway
@endsection
@section('content')
    <!-- HERO-13 ============================================= -->
    <section id="hero-13" class="bg-lightgrey hero-section division">
        <div class="container">
            <div class="row d-flex align-items-center">
                <!-- HERO TEXT -->
                <div class="col-md-8 col-lg-6">
                    <div class="hero-13-txt pc-25 wow fadeInRight" data-wow-delay="0.6s">
                        <!-- Title -->
                        <h3 class="h3-sm txt-700 deepblue-color">Stay connected with your friends using Novaro App</h3>
                        <!-- Text -->
                        <p class="p-md">Feugiat primis ligula risus auctor augue egestas and mauris viverra in iaculis
                            magna feugiat mauris imperdiet varius
                        </p>
                        <!-- Text -->
                        <p class="p-md">Aliqum  mullam blandit tempor sapien gravida donec ipsum, and porta justo. Velna
                            vitae and auctor egestas magna and impedit ligula at risus mauris donec aliquet cursus
                        </p>
                        <!-- STORE BADGES -->
                        <div class="stores-badge mt-30">
                            <!-- AppStore -->
                            <a href="#" class="store">
                                <img class="appstore-original" src="{{ url('/') }}/assets/images/appstore.png" alt="appstore-badge" />
                            </a>
                            <!-- Google Play -->
                            <a href="#" class="store">
                                <img class="googleplay-original" src="{{ url('/') }}/assets/images/googleplay.png" alt="googleplay-badge" />
                            </a>
                        </div>	<!-- END STORE BADGES -->
                        <!-- Modal Video Link -->
                        <div class="modal-video grey-color">
                            <a class="video-popup1" href="https://www.youtube.com/embed/SZEflIVnhH8"> <!-- Change the video link HERE!!! -->
                                <i class="fas fa-play-circle"></i>
                                <span>
                                    {{__("Watch Overview")}}
                                    <br/>
                                    <span class="video-duration grey-color">
                                        2:40 min
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>	<!-- END HERO TEXT -->
                <!-- HERO IMAGE -->
                <div class="col-md-4 col-lg-6">
                    <div class="hero-13-img wow fadeInLeft" data-wow-delay="0.4s">
                        <img class="img-fluid" src="{{ url('/') }}/assets/images/hero-13-img.png" alt="hero-image">
                    </div>
                </div>
            </div>     <!-- End row -->
        </div>	   <!-- End container -->
    </section>	<!-- END HERO-13 -->
    <!-- CONTENT-5
    ============================================= -->
    <section id="content-5" class="bg-lightgrey wide-60 content-section division">
        <div class="container">

            <!-- CONTENT-5 TOP -->
            <div id="c5-top" class="pb-50">
                <div class="row d-flex align-items-center m-row">
                    <!-- IMAGE BLOCK -->
                    <div class="col-md-5 col-lg-6 m-bottom">
                        <div class="img-block left-column pc-25 mb-40 wow fadeInRight" data-wow-delay="0.4s">
                            <img class="img-fluid" src="{{ url('/') }}/assets/images/image-05.png" alt="content-image">
                        </div>
                    </div>
                    <!-- TEXT BLOCK -->
                    <div class="col-md-7 col-lg-6 m-top">
                        <div class="txt-block right-column pc-35 mb-40 wow fadeInLeft" data-wow-delay="0.6s">
                            <!-- Title -->
                            <h3 class="h3-sm txt-700 deepblue-color">Send group messages to your friends anytime!</h3>
                            <!-- List -->
                            <ul class="txt-list grey-color mb-10">
                                <li class="list-item">
                                    <i class="fas fa-angle-right"></i>
                                    <p class="p-md">Fringilla risus, luctus mauris orci auctor purus euismod pretium
                                        purus pretium ligula rutrum tempor sapien
                                    </p>
                                </li>
                                <li class="list-item">
                                    <i class="fas fa-angle-right"></i>
                                    <p class="p-md">Quaerat sodales sapien euismod purus blandit</p>
                                </li>
                                <li class="list-item">
                                    <i class="fas fa-angle-right"></i>
                                    <p class="p-md">Nemo ipsam egestas volute turpis dolores ut aliquam quaerat sodales
                                        sapien undo pretium a purus mauris
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>	<!-- END TEXT BLOCK -->
                </div>	  <!-- End row -->
            </div>	<!-- END CONTENT-5 TOP -->
            <!-- CONTENT-5 BOTTOM -->
            <div id="c5-bottom">
                <div class="row d-flex align-items-center">
                    <!-- TEXT BLOCK -->
                    <div class="col-md-7 col-lg-6">
                        <div class="txt-block left-column pc-35 mb-40 wow fadeInRight" data-wow-delay="0.6s">
                            <!-- Title -->
                            <h3 class="h3-sm txt-700 deepblue-color">Sync all your contacts with social profiles</h3>
                            <!-- Text -->
                            <p class="p-md grey-color">Gravida porta velna vitae auctor congue a magna impedit nihil
                                ligula risus. Mauris donec ligula and magnis
                            </p>
                            <!-- Text -->
                            <p class="p-md grey-color">Aliqum mullam blandit and tempor sapien at donec ipsum gravida
                                porta. Velna vitae auctor congue a magna impedit nihil ligula risus. Mauris donec ligula
                                and magnis at sapien sagittis sapien pretium enim gravida purus ligula
                            </p>
                        </div>
                    </div>	<!-- END TEXT BLOCK -->
                    <!-- IMAGE BLOCK -->
                    <div class="col-md-5 col-lg-6">
                        <div class="img-block right-column pc-25 mb-40 wow fadeInLeft" data-wow-delay="0.4s">
                            <img class="img-fluid" src="{{ url('/') }}/assets/images/image-22.png" alt="content-image">
                        </div>
                    </div>
                </div>	  <!-- End row -->
            </div>	<!-- END CONTENT-5 BOTTOM -->
        </div>     <!-- End container -->
    </section>	<!-- END CONTENT-5 -->

    <!-- FEATURES-4
    ============================================= -->
    <section id="features-4" class="bg-dirtygrey wide-60 features-section division">
        <div class="container">
            <!-- SECTION TITLE -->
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="section-title mb-80">
                        <!-- Title -->
                        <h3 class="h3-xl txt-700 deepblue-color">Core Features That Matters</h3>
                        <!-- Text -->
                        <p class="p-xl">Aliquam a augue suscipit, luctus neque purus ipsum neque at dolor primis libero
                            tempus, blandit and cursus varius magna
                        </p>
                    </div>
                </div>
            </div>
            <!-- FEATURES-4 HOLDER -->
            <div class="fbox-4-holder pc-05">
                <div class="row">
                    <!-- FEATURE BOX #1 -->
                    <div class="col-md-6">
                        <div class="fbox-4 mb-40 d-flex align-items-center wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Icon -->
                            <div class="fbox-4-ico grey-color ico-60"><span class="flaticon-user-2"></span></div>
                            <!-- Text -->
                            <div class="fbox-4-txt grey-color">
                                <h5 class="h5-sm">Tempor sapien a 50% gravida donec and ipsum pretium porta a justo velna</h5>
                            </div>
                        </div>
                    </div>
                    <!-- FEATURE BOX #2 -->
                    <div class="col-md-6">
                        <div class="fbox-4 mb-40 d-flex align-items-center wow fadeInUp" data-wow-delay="0.6s">
                            <!-- Icon -->
                            <div class="fbox-4-ico grey-color ico-60"><span class="flaticon-control"></span></div>
                            <!-- Text -->
                            <div class="fbox-4-txt grey-color">
                                <h5 class="h5-sm">Sapien a gravida donec and impedit at nihil ligula justo integer</h5>
                            </div>
                        </div>
                    </div>
                    <!-- FEATURE BOX #3 -->
                    <div class="col-md-6">
                        <div class="fbox-4 mb-40 d-flex align-items-center wow fadeInUp" data-wow-delay="0.8s">

                            <!-- Icon -->
                            <div class="fbox-4-ico grey-color ico-60"><span class="flaticon-block"></span></div>

                            <!-- Text -->
                            <div class="fbox-4-txt grey-color">
                                <h5 class="h5-sm">Volute turpis dolores ut aliquam quaerat sodales sapien undo pretium</h5>
                            </div>

                        </div>
                    </div>


                    <!-- FEATURE BOX #4 -->
                    <div class="col-md-6">
                        <div class="fbox-4 mb-40 d-flex align-items-center wow fadeInUp" data-wow-delay="1s">

                            <!-- Icon -->
                            <div class="fbox-4-ico grey-color ico-60"><span class="flaticon-voice-message"></span></div>

                            <!-- Text -->
                            <div class="fbox-4-txt grey-color">
                                <h5 class="h5-sm">Gravida donec and ipsum pretium porta</h5>
                            </div>

                        </div>
                    </div>


                    <!-- FEATURE BOX #5 -->
                    <div class="col-md-6">
                        <div class="fbox-4 mb-40 d-flex align-items-center wow fadeInUp" data-wow-delay="1.2s">

                            <!-- Icon -->
                            <div class="fbox-4-ico grey-color ico-60"><span class="flaticon-list"></span></div>

                            <!-- Text -->
                            <div class="fbox-4-txt grey-color">
                                <h5 class="h5-sm">Aliqum mullam blandit a tempor gravida donec undo ipsum porta velna</h5>
                            </div>

                        </div>
                    </div>


                    <!-- FEATURE BOX #6 -->
                    <div class="col-md-6">
                        <div class="fbox-4 mb-40 d-flex align-items-center wow fadeInUp" data-wow-delay="1.4s">

                            <!-- Icon -->
                            <div class="fbox-4-ico grey-color ico-60"><span class="flaticon-pins-1"></span></div>

                            <!-- Text -->
                            <div class="fbox-4-txt grey-color">
                                <h5 class="h5-sm">Blandit undo tempor sapien gravida donec at ipsum a porta tempor</h5>
                            </div>

                        </div>
                    </div>


                    <!-- FEATURE BOX #7 -->
                    <div class="col-md-6">
                        <div class="fbox-4 mb-40 d-flex align-items-center wow fadeInUp" data-wow-delay="1.6s">

                            <!-- Icon -->
                            <div class="fbox-4-ico grey-color ico-60"><span class="flaticon-gallery"></span></div>

                            <!-- Text -->
                            <div class="fbox-4-txt grey-color">
                                <h5 class="h5-sm">Nemo ipsam an egestas 24K+ volute </h5>
                            </div>

                        </div>
                    </div>


                    <!-- FEATURE BOX #8 -->
                    <div class="col-md-6">
                        <div class="fbox-4 mb-40 d-flex align-items-center wow fadeInUp" data-wow-delay="1.8s">

                            <!-- Icon -->
                            <div class="fbox-4-ico grey-color ico-60"><span class="flaticon-comment-1"></span></div>

                            <!-- Text -->
                            <div class="fbox-4-txt grey-color">
                                <h5 class="h5-sm">Dolores donec ipsum pretium 24/7 porta donec and ipsum pretium justo</h5>
                            </div>

                        </div>
                    </div>


                </div>  <!-- End row -->
            </div>	<!-- END FEATURES-4 HOLDER -->


        </div>	   <!-- End container -->
    </section>	<!-- END FEATURES-4 -->

    <!-- CONTENT-1
    ============================================= -->
    <section id="content-1" class="bg-lightgrey wide-60 content-section division">
        <div class="container">
            <div class="row d-flex align-items-center m-row">


                <!-- IMAGE BLOCK -->
                <div class="col-md-5 col-lg-6 m-bottom">
                    <div class="img-block left-column pc-25 mb-40 wow fadeInRight" data-wow-delay="0.4s">
                        <img class="img-fluid" src="{{ url('/') }}/assets/images/image-21.png" alt="content-image">
                    </div>
                </div>


                <!-- TEXT BLOCK -->
                <div class="col-md-7 col-lg-6 m-top">
                    <div class="txt-block right-column pc-35 mb-40 wow fadeInLeft" data-wow-delay="0.6s">

                        <!-- Title -->
                        <h3 class="h3-sm txt-700 deepblue-color">Share text, voice, photos, videos and files for free</h3>

                        <!-- List -->
                        <ul class="txt-list grey-color">

                            <li class="list-item">
                                <i class="fas fa-angle-right"></i>
                                <p class="p-md">Fringilla risus, luctus mauris orci auctor purus euismod pretium
                                    purus pretium ligula rutrum tempor sapien
                                </p>
                            </li>

                            <li class="list-item">
                                <i class="fas fa-angle-right"></i>
                                <p class="p-md">Quaerat sodales sapien euismod purus blandit</p>
                            </li>

                            <li class="list-item">
                                <i class="fas fa-angle-right"></i>
                                <p class="p-md">Nemo ipsam egestas volute turpis dolores ut aliquam quaerat sodales
                                    sapien undo pretium a purus mauris
                                </p>
                            </li>

                        </ul>

                    </div>
                </div>	<!-- END TEXT BLOCK -->


            </div>	  <!-- End row -->
        </div>     <!-- End container -->
    </section>	<!-- END CONTENT-1 -->


    <!-- CONTENT-3
    ============================================= -->
    <section id="content-3" class="bg-lightgrey pt-100 content-section division">
        <div class="container">
            <div class="row d-flex align-items-center">


                <!-- TEXT BLOCK -->
                <div class="col-md-7 col-lg-6">
                    <div class="txt-block left-column pc-35 wow fadeInRight" data-wow-delay="0.6s">

                        <!-- Title -->
                        <h3 class="h3-sm txt-700 deepblue-color">Get fast and secure access to your messages</h3>

                        <!-- List -->
                        <ul class="txt-list">

                            <li class="list-item">
                                <i class="fas fa-angle-right"></i>
                                <p class="p-md">Aliqum mullam blandit and tempor sapien donec ipsum at gravida porta.
                                    Velna vitae auctor congue a magna
                                </p>
                            </li>

                            <li class="list-item">
                                <i class="fas fa-angle-right"></i>
                                <p class="p-md">Quaerat sodales and sapien euismod blandit purus and luctus neque purus
                                    sagittis sapien undo sodales
                                </p>
                            </li>

                            <li class="list-item">
                                <i class="fas fa-angle-right"></i>
                                <p class="p-md">Nemo ipsam egestas volute turpis dolores and aliquam quaerat
                                    sodales sapien pretium mullam blandit
                                </p>
                            </li>

                        </ul>

                    </div>
                </div>	<!-- END TEXT BLOCK -->


                <!-- IMAGE BLOCK -->
                <div class="col-md-5 col-lg-6">
                    <div class="img-block right-column pc-25 wow fadeInUp" data-wow-delay="0.4s">
                        <img class="img-fluid" src="{{ url('/') }}/assets/images/image-17.png" alt="content-image">
                    </div>
                </div>


            </div>	  <!-- End row -->
        </div>     <!-- End container -->
    </section>	<!-- END CONTENT-3 -->


    <!-- CONTACTS-4
    ============================================= -->
    <section id="contacts-4" class="bg-dirtygrey pt-80 pb-80 contacts-section division">
        <div class="container">
            <div class="row">


                <!-- CONTACTS-4 HOLDER -->
                <div class="col-lg-10 offset-lg-1">
                    <div class="contacts-4-holder pc-08 text-center">

                        <!-- Text -->
                        <h4 class="h4-md">We’ve made Novaro to make your life easier. Feel free to send us questions,
                            feedbacks, your own ideas for new features or improvements! Drop us a line at
                            <a href="mailto:yourdomain@mail.com" class="yellow-color">yourdomain@mail.com</a>
                        </h4>

                    </div>
                </div>


            </div>    <!-- End row -->
        </div>	   <!-- End container -->
    </section>	<!-- END CONTACTS-4 -->
@endsection
