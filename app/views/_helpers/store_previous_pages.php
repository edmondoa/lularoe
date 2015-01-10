<?php
// store pages for back buttons
if (Session::get('previous_page') != null) {
	Session::put('previous_page_2', Session::get('previous_page'));
}
Session::put('previous_page', Request::url());