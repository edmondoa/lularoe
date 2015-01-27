@extends('layouts.public')
@section('content')
    <div id="fws_546a483693fad" class="wpb_row vc_row-fluid full-width-section standard_section    "  style="padding-top: 0px; padding-bottom: 0px; ">
        <div class="col span_12 dark left">
            <div  class="vc_span12 wpb_column column_container col no-extra-padding"  data-hover-bg="" data-animation="" data-delay="0">
                <div class="wpb_wrapper">
                    <div style="height: 600px" data-transition="swipe" data-flexible-height="" data-fullscreen="false" data-autorotate="" data-parallax="false" data-full-width="true" class="nectar-slider-wrap " id="ns-id-546a48369477d">
                        <div style="height: 600px" class="swiper-container" data-loop="false" data-height="600" data-min-height="" data-arrows="false" data-bullets="false" data-desktop-swipe="false" data-settings="">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide" style="background-image: url(http://themenectar.com/demo/salient/wp-content/uploads/2013/09/black-bg1.png);" data-bg-alignment="bottom" data-color-scheme="light" data-x-pos="centered" data-y-pos="middle">
                                    <div class="container">
                                        <div class="content">
                                            <h2>We Are {{ Config::get('site.company_name') }}</h2>
                                            <p  >
                                                <span>join the conversation!</span>
                                            </p>
                                        </div>
                                    </div><!--/container--><a href="#" class="slider-down-arrow"><i class="icon-salient-down-arrow icon-default-style"> <span class="ie-fix"></span> </i></a>
                                    <div class="video-texture ">
                                        <span class="ie-fix"></span>
                                    </div>
                                </div><!--/swiper-slide-->
                            </div>
                            <div class="nectar-slider-loading ">
                                <span class="loading-icon "> </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="fws_546a4836962d6" class="wpb_row vc_row-fluid full-width-section standard_section    "  style="padding-top: 70px; padding-bottom: 60px; ">
        <div class="col span_12 dark left">
            <div  class="vc_span8 wpb_column column_container col no-extra-padding"  data-hover-bg="" data-animation="" data-delay="0">
                <div class="wpb_wrapper">
                    <div class="wpcf7" id="wpcf7-f3065-p26-o1" lang="en-US" dir="ltr">
                        <div class="screen-reader-response"></div>

                        @include('_helpers.message')
                        @include('_helpers.errors')

                        {{ Form::open(array('action' => 'send-contact-form')) }}

                        <input type='hidden' name='user_id' value='0'>

                        <div class="form-group">
                            {{ Form::label('name','* Your Name:')}}
                            {{ Form::text('name', null, ['class'=>'form-control']) }}
                        </div>
                        <br>
                        <div class="form-group">
                            {{ Form::label('email','* Your Email Address:')}}
                            {{ Form::text('email', null, ['class'=>'form-control']) }}
                        </div>
                        <br>
                        <div class="form-group">
                            {{ Form::label('subject_line','* Subject:')}}
                            {{ Form::text('subject_line', null, $attributes = array('class'=>'form-control')) }}
                        </div>
                        <br>
                        <div class="form-group">
                            {{ Form::label('body','* Message:')}}
                            {{ Form::textarea('body',null, $attributes = array('class'=>'form-control')) }}
                        </div>
                        <br>
                        <div class="form-group">
                            {{ Form::submit('Send Message', ['class' => 'btn btn-primary']) }}
                        </div>

                        {{ Form::close() }}

                    </div>
                </div>
            </div>

            <div  class="vc_span4 wpb_column column_container col no-extra-padding"  data-hover-bg="" data-animation="" data-delay="0">
                <div class="wpb_wrapper">

                    <div class="wpb_text_column wpb_content_element ">
                        <div class="wpb_wrapper">
                            <h4><a href="/wp-content/uploads/2013/03/Contact-Image.jpg"><img class="aligncenter size-large wp-image-3072" src="/wp-content/uploads/2013/03/Contact-Image-1024x680.jpg" alt="young man using a smartphone outdoors" width="1024" height="680" /></a>Don&#8217;t hesitate to reach out!</h4>
                            <p>
                                <strong>Customer Service: 1.800.000.0000</strong>
                            </p>
                            <h2>
                        </div>
                    </div>
                    <div style="height: 20px;" class="divider"></div><div class="col span_6" data-animation="" data-delay="0"></div><div class="col span_6 col_last" data-animation="" data-delay="0"></div><div class="clear"></div>
                </div>
            </div>
        </div>
    </div></h2>
    <p>
        &nbsp;
    </p>
@stop
