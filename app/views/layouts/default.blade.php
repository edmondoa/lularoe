<?php $layout = 'default' ?>
@include('layouts.header')
<div id="header-menu" class="hidden-print navbar navbar-fixed-top navbar-inverse" role="navigation">
    @include('layouts.header-menu')
</div><!-- /.navbar -->
<div id="main">
    <div id="sidebar" role="navigation">
        @include('layouts.main-menu')
    </div><!--/col-->
    <div id="content">
        <div class="row">
            <div class="col col-md-12">
                @include('_helpers.errors')
                @include('_helpers.message')
            </div>
        </div>
        @section('content')
        @show
        <hr>
        <footer>
            <?php
                if (Auth::check()) {
                    if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) {
                        $pages = Page::where('Reps', 1)->orWhere('Customers', 1)->orWhere('Public', 1)->where('back_office_footer', 1)->get();
                    }
                    elseif (Auth::user()->hasRole(['Customer'])) {
                        $pages = Page::where('Customers', 1)->orWhere('Public', 1)->where('back_office_footer', 1)->get();
                    }
                    elseif (Auth::user()->hasRole(['Rep'])) {
                        $pages = Page::where('Reps', 1)->orWhere('Public', 1)->where('back_office_footer', 1)->get();
                    }
                }
                else $pages = Page::where('back_office_footer', 1)->where('Public', 1)->get();
            ?>
            @if (isset($pages))
                <ul class="footer-links hidden-print">
                    @foreach ($pages as $page)
                        <li><a href="//{{ Config::get('site.domain') }}/pages/{{ $page->url }}">{{ $page->short_title }}</a></li>
                    @endforeach
                </ul>
            @endif
            <p>&copy; {{ date('Y') }} LLR INC</p>
        </footer>
    </div><!--/col-->
</div><!--/row-->
@include('layouts.footer')
