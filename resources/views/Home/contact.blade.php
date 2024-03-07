@extends('Home.Layouts.app')
@section('pageTitle')
    {{__("Contact us")}}
@endsection
@section('content')
    <br/>
    <!-- CONTACTS-5
				============================================= -->
    <section id="contacts-5" class="wide-70 b-bottom contacts-section division">
        <div class="container">
            <!-- SECTION TITLE -->
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="section-title mb-70">
                        <!-- Title 	-->
                        <h2 class="h2-xs">How Can We Help?</h2>
                        <!-- Text -->
                        <p class="p-xl">Aliquam a augue suscipit, luctus neque purus ipsum neque at dolor primis libero
                            tempus, blandit and cursus varius magna
                        </p>
                    </div>
                </div>
            </div>
            <!-- CONTACT FORM -->
            <div class="row">
                <div class="col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
                    <div class="form-holder">
                        <form name="contactform" class="row contact-form">
                            <!-- Form Select -->
                            <div id="input-subject" class="col-md-12 input-subject">
                                <p class="p-lg">This question is about: </p>
                                <span>Choose a topic, so we know who to send your request to: </span>
                                <select id="inlineFormCustomSelect1" name="Subject" class="custom-select subject">
                                    <option>This question is about...</option>
                                    <option>Registering/Authorising</option>
                                    <option>Using Application</option>
                                    <option>Troubleshooting</option>
                                    <option>Backup/Restore</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <!-- Contact Form Input -->
                            <div id="input-name" class="col-lg-12">
                                <p class="p-lg">Your Name: </p>
                                <span>Please enter your real name: </span>
                                <input type="text" name="name" class="form-control name" placeholder="Your Name*">
                            </div>

                            <div id="input-email" class="col-lg-12">
                                <p class="p-lg">Your Email Address: </p>
                                <span>Please carefully check your email address for accuracy</span>
                                <input type="text" name="email" class="form-control email" placeholder="Email Address*">
                            </div>

                            <div id="input-message" class="col-lg-12 input-message">
                                <p class="p-lg">Explain your question in details: </p>
                                <span>Your OS version, Novaro version & build, steps you did. Be VERY precise!</span>
                                <textarea class="form-control message" name="message" rows="6" placeholder="I have a problem with..."></textarea>
                            </div>

                            <!-- Contact Form Button -->
                            <div class="col-lg-12 mt-15 form-btn text-right">
                                <button type="submit" class="btn btn-blue blue-hover submit">Submit Request</button>
                            </div>

                            <!-- Contact Form Message -->
                            <div class="col-lg-12 contact-form-msg">
                                <span class="loading"></span>
                            </div>

                        </form>
                    </div>
                </div>
            </div>	   <!-- END CONTACT FORM -->

        </div>	   <!-- End container -->
    </section>
    <!-- END CONTACTS-5 -->
@endsection
