@extends('layouts.public')
@section('banner')
	<img src="/img/contact.jpg" style="width:100%; position:relative; z-index:1000;">
@stop
@section('content')
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
                            <p>
                                <h3 style="margin-top:0;">Customer Service:</h3>
                                {{ Config::get('site.customer_service') }}
                            </p>
                            <p>
                            	<h3>Home Office</h3>
                            	1751 California Avenue, Suite 101<br>
								Corona, CA 92881<br>
								USA
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
