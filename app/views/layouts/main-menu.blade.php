 			<div class="list-group" id="main-menu">
 				@if ((Auth::check()))
 					<a title="Dashboard" href="/dashboard" class="list-group-item"><i class="fa fa-dashboard"></i> <span class="text">Dashboard</span></a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Rep'])))
 					<a href="javascript:void(0)" data-href="/posts" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='/public-posts'><i class='fa fa-globe'></i> Public Announcements</a>
 						<a href='/posts'><i class='fa fa-user'></i> Announcements for {{ Config::get('site.rep_title') }}</a>
 						@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
 						 	<a href='/posts/create'><i class='fa fa-plus'></i> New Announcement</a>
 						@endif
 					">
	 					<i class="fa fa-thumb-tack"></i> <span class="text">Announcements</span>
	 				</a>
	 			@endif
	 			@if ((Auth::check())&&(Auth::user()->hasRole(['Rep'])))
 					<a href="javascript:void(0)" data-href="/events" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='/public-events'><i class='fa fa-globe'></i> Public Events Page</a>
 						<a href='/events'><i class='fa fa-calendar'></i> Upcoming Events for FC's</a>
 					">
 						<i class="fa fa-calendar"></i> <span class="text">Company Events</span>
 					</a>
 					<a href="javascript:void(0)" data-href="/leads" class='list-group-item' data-toggle="popover" data-content="
 						@if (Auth::user()->hasRole(['Rep']))
 							<a href='/leads'><i class='fa fa-users'></i> My Contacts</a>
 						@else
 							<a href='/leads'><i class='fa fa-users'></i> All Contacts</a>
 						@endif
 						<a href='/leads/create'><i class='fa fa-plus'></i> New Contact</a>
 					">
 						<i class="fa fa-users"></i> <span class="text">Contacts</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin'])))
 					<a href="javascript:void(0)" data-href="/events" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='/public-events'><i class='fa fa-globe'></i> Public Events Page</a>
 						<a href='/events'><i class='fa fa-calendar'></i> Upcoming Events</a>
 						<a href='/past-events'><i class='fa fa-reply'></i> Past Events</a>
 						<a href='/events/create'><i class='fa fa-plus'></i> New Event</a>
 					">
 						<i class="fa fa-calendar"></i> <span class="text">Company Events</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor','Rep'])))
 				    <a href="javascript:void(0)" data-href="/inventories" class='list-group-item' data-toggle="popover" data-content="
						 <a href='/products'><i class='fa fa-female'></i> My Inventory</a>
 						 <!-- <a href='/products/create'><i class='fa fa-plus'></i> Add Inventory</a> -->
                         <a href='/inventories'><i class='fa fa-plus'></i> Purchase Inventory</a>
                     ">
                         <i class="fa fa-female"></i> <span class="text">Inventory</span>
                     </a>
                @endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor'])))
 					<a href="javascript:void(0)" data-href="/pages" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/pages'><i class='fa fa-file'></i> All Pages</a>
 						<a href='/pages/create'><i class='fa fa-plus'></i> New Page</a>
 					">
						<i class="fa fa-file"></i> <span class="text">Pages</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Rep'])))
 					<a href="javascript:void(0)" data-href="/parties" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='/public-parties'><i class='fa fa-globe'></i> Public Pop-Up Boutiques Page</a>
 						<a href='/parties'><i class='fa fa-users'></i> Upcoming Pop-Up Boutiques</a>
 						<a href='/past-parties'><i class='fa fa-reply'></i> Past Pop-Up Boutiques</a>
 						<a href='/parties/create'><i class='fa fa-plus'></i> New Pop-Up Boutique</a>
 					">
 						<i class="fa fa-users"></i> <span class="text">Pop-Up Boutiques</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor','Rep'])))
 					<a href="javascript:void(0)" data-href="/opportunities" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/opportunities'><i class='fa fa-check'></i> All Promotions</a>
 						@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor'])))
 							<a href='/opportunities/create'><i class='fa fa-plus'></i> New Promotion</a>
 						@endif
 					">
 						<i class="fa fa-check"></i> <span class="text">Promotions</span>
 					</a>
 				    <a href="javascript:void(0)" data-href="/sales" class='list-group-item' data-toggle="popover" data-content="
                         <a href='/pricing'><i class='fa fa-dollar'></i> Transaction Rates</a>
                         <a href='/sales'><i class='fa fa-plus'></i> New Sale</a>
<!--                         <a href='/sales/ledger'><i class='fa fa-plus'></i> Previous Sales</a> -->
                     ">
                         <i class="fa fa-bank"></i> <span class="text">Sales</span>
                     </a>
                @endif
                @if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin'])))
                 	<!-- <a title="Site Settings" href="/config" class="list-group-item"><span class="fa fa-cog"></span> <span class="text">Settings</span></a> -->
                @endif
                @if ((Auth::check())&&(Auth::user()->hasRole(['Rep'])))
 					<a href="javascript:void(0)" data-href="/user-sites" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='//{{ Auth::user()->public_id }}.{{ Config::get("site.base_domain") }}'><i class='fa fa-eye'></i> View Site</a>
 						<a href='/user-sites/{{ Auth::user()->id }}/edit'><i class='fa fa-pencil'></i> Edit Site</a>
 					">
 						<i class="fa fa-globe"></i> 
 						<span class="text">Site</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor','Rep'])))
 					<a href="javascript:void(0)" data-href="/downline" class='list-group-item' data-toggle="popover" data-content="
		 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin'])))
	 						<a href='/downline/new/0'><i class='fa fa-certificate'></i> New Team Members</a>
	 						<a href='/downline/immediate/0'><i class='fa fa-arrow-down'></i> Sponsored Members</a>
	 						<a href='/downline/all/0'><i class='fa fa-bars'></i> Entire Team</a>
	 						<a href='/downline/visualization/0'><i class='fa fa-sitemap'></i> Team Tree</a>
		 				@else
	 						<a href='/downline/new/{{ Auth::user()->id }}'><i class='fa fa-certificate'></i> New Team Members</a>
	 						<a href='/downline/immediate/{{ Auth::user()->id }}'><i class='fa fa-arrow-down'></i> Sponsored Members</a>
	 						<a href='/downline/all/{{ Auth::user()->id }}'><i class='fa fa-bars'></i> Entire Team</a>
	 						<a href='/downline/visualization/{{ Auth::user()->id }}'><i class='fa fa-sitemap'></i> Team Tree</a>
	 					@endif
 					">
 						<i class="fa fa-sitemap"></i> 
 						<span class="text">Team</span>
 					</a>  
  					<a href="javascript:void(0)" data-href="/media" class='list-group-item' data-toggle="popover" data-content="
 						@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor'])))
 							<a href='/media/user/{{ Config::get('site.admin_uid') }}'><i class='fa fa-th-large'></i> Company Tools/Assets</a>
 							<a href='/media-shared-with-reps'><i class='fa fa-th-large'></i> Tools/Assets Shared with {{ Config::get('site.rep_title') }}</a>
 							<!-- <a href='/media-reps'><i class='fa fa-users'></i> Tools/Assets Uploaded by {{ Config::get('site.rep_title') }}</a> -->
 						@endif
 						@if ((Auth::check())&&(Auth::user()->hasRole(['Rep'])))
 							<a href='/media-shared-with-reps'><i class='fa fa-th-large'></i> All Tools/Assets</a>
 						@endif
  							<a href='/media-shared-with-reps?filter=Branding'><i class='fa fa-th-large'></i> Branding</a>
 							<a href='/media-shared-with-reps?filter=Documents'><i class='fa fa-file'></i> Documents</a>
 							<a href='/media-shared-with-reps?filter=Marketing-Tools'><i class='fa fa-wrench'></i> Marketing Tools</a>
 							<a href='/media-shared-with-reps?filter=Photo-Gallery'><i class='fa fa-photo'></i> Photo Gallery</a>
 							<a href='/media-shared-with-reps?filter=Training'><i class='fa fa-graduation-cap'></i> Training</a>
 						@if (Auth::user()->hasRole(['Superadmin','Admin','Editor']))
 							<a href='/media/create'><i class='fa fa-upload'></i> Upload Tool/Asset</a>
 						@endif
 					">
 						<i class="fa fa-file-image-o"></i> <span class="text">Tools/Assets</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin'])))
 					<a href="javascript:void(0)" data-href="/users" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/users'><i class='fa fa-user'></i> All Users</a>
 						<a href='/users/create'><i class='fa fa-plus'></i> New User</a>
 					">
 						<i class="fa fa-user"></i> <span class="text">Users</span>
 					</a>
 					<!-- <a href="/userProducts" class="list-group-item"><i class="fa fa-mobile-phone"></i> UserProducts</a> -->
					<!-- <a href="/userRanks" class="list-group-item"><i class="fa fa-certificate"></i> UserRanks</a> -->
					<!-- <a href="/smsMessages" class="list-group-item"><i class="fa fa-mobile-phone"></i> <span class="text">SmsMessages</span></a> -->
				@endif
 			</div>
