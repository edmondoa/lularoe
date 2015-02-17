 			<div class="list-group" id="main-menu">
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin', 'Editor'])))
 					<a title="Dashboard" href="/dashboard" class="list-group-item"><i class="fa fa-dashboard"></i> <span class="text">Dashboard</span></a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin'])))
 					<a href="javascript:void(0)" data-href="/downline" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/downline/new/{{ Config::get('site.admin_uid') }}'><i class='fa fa-certificate'></i> New Downline</a>
 						<a href='/downline/immediate/{{ Config::get('site.admin_uid') }}'><i class='fa fa-arrow-down'></i> Immediate Downline</a>
 						<a href='/downline/all/{{ Config::get('site.admin_uid') }}'><i class='fa fa-bars'></i> All Downline</a>
 						<!-- <a href='/downline/state/{{ Config::get('site.admin_uid') }}'><i class='fa fa-bars'></i> Downline by State</a> -->
 						<a href='/downline/visualization/{{ Config::get('site.admin_uid') }}'><i class='fa fa-sitemap'></i> Visualization</a>
 					">
 						<i class="fa fa-sitemap"></i> <span class="text">Downline</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Rep'])))
 					<a title="Dashboard" href="/dashboard" class="list-group-item"><i class="fa fa-dashboard"></i> <span class="text">Dashboard</span></a>
 					<a href="javascript:void(0)" data-href="/downline" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/downline/new/{{ Auth::user()->id }}'><i class='fa fa-certificate'></i> New Downline</a>
 						<a href='/downline/immediate/{{ Auth::user()->id }}'><i class='fa fa-arrow-down'></i> Immediate Downline</a>
 						<a href='/downline/all/{{ Auth::user()->id }}'><i class='fa fa-bars'></i> All Downline</a>
 						<a href='/downline/visualization/{{ Auth::user()->id }}'><i class='fa fa-sitemap'></i> Visualization</a>
 					">
 						<i class="fa fa-sitemap"></i> 
 						<span class="text">My Downline</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Rep'])))
 					<a href="javascript:void(0)" data-href="/leads" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/leads'><i class='fa fa-users'></i> All Leads</a>
 						<a href='/leads/create'><i class='fa fa-plus'></i> New Lead</a>
 					">
 						<i class="fa fa-user"></i> <span class="text">My Leads</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Rep'])))
 					<a href="javascript:void(0)" data-href="/user-sites" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='//{{ Auth::user()->public_id }}.{{ Config::get("site.base_domain") }}'><i class='fa fa-eye'></i> View Site</a>
 						<a href='/user-sites/{{ Auth::user()->id }}/edit'><i class='fa fa-pencil'></i> Edit Site</a>
 					">
 						<i class="fa fa-globe"></i> 
 						<span class="text">My Site</span>
 					</a>
 					<a href="javascript:void(0)" data-href="/events" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='/public-events'><i class='fa fa-globe'></i> Public Events Page</a>
 						<a href='/events'><i class='fa fa-calendar'></i> Upcoming Events for ISM's</a>
 					">
	 					<i class="fa fa-calendar"></i> <span class="text">Events</span>
	 				</a>
 					<a href="javascript:void(0)" data-href="/posts" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='/public-posts'><i class='fa fa-globe'></i> Public Announcements</a>
 						<a href='/posts'><i class='fa fa-user'></i> Announcements for ISM's</a>
 					">
	 					<i class="fa fa-thumb-tack"></i> <span class="text">Announcements</span>
	 				</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin'])))
 					<a href="javascript:void(0)" data-href="/events" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='/public-events'><i class='fa fa-globe'></i> Public Events Page</a>
 						<a href='/events'><i class='fa fa-calendar'></i> Upcoming Events</a>
 						<a href='/past-events'><i class='fa fa-reply'></i> Past Events</a>
 						<a href='/events/create'><i class='fa fa-plus'></i> New Event</a>
 					">
 						<i class="fa fa-calendar"></i> <span class="text">Events</span>
 					</a>
 					<a href="javascript:void(0)" data-href="/leads" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/leads'><i class='fa fa-users'></i> All Leads</a>
 						<a href='/leads/create'><i class='fa fa-plus'></i> New Lead</a>
 					">
 						<i class="fa fa-users"></i> <span class="text">Leads</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor','Rep'])))
  					<a href="javascript:void(0)" data-href="/media" class='list-group-item' data-toggle="popover" data-content="
 						@if ((Auth::check())&&(Auth::user()->hasRole(['Rep'])))
 							<a href='/media/user/{{ Auth::user()->id }}'><i class='fa fa-user'></i> My Resources</a>
 						@endif
 						@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor'])))
 							<a href='/media/user/{{ Config::get('site.admin_uid') }}'><i class='fa fa-th-large'></i> Company Resources</a>
 							<a href='/media-shared-with-reps'><i class='fa fa-th-large'></i> Resources Shared with ISM's</a>
 							<a href='/media-reps'><i class='fa fa-users'></i> Resources Uploaded by ISM's</a>
 						@endif
 						@if ((Auth::check())&&(Auth::user()->hasRole(['Rep'])))
 							<a href='/media'><i class='fa fa-th-large'></i> Resource Library</a>
 						@endif
 						<a href='/media/create'><i class='fa fa-upload'></i> Upload Resource</a>
 					">
 						<i class="fa fa-file-image-o"></i> <span class="text">Resources</span>
 					</a>
 				    <a href="javascript:void(0)" data-href="/inventories" class='list-group-item' data-toggle="popover" data-content="
                         <a href='/inventories'><i class='fa fa-check'></i> All Inventories</a>
                         @if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor'])))
                             <a href='/inventories/create'><i class='fa fa-plus'></i> New Inventory</a>
                         @endif
                     ">
                         <i class="fa fa-list-ol"></i> <span class="text">Inventories</span>
                     </a>
 					<a href="javascript:void(0)" data-href="/opportunities" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/opportunities'><i class='fa fa-check'></i> All Opportunities</a>
 						@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor'])))
 							<a href='/opportunities/create'><i class='fa fa-plus'></i> New Opportunity</a>
 						@endif
 					">
 						<i class="fa fa-check"></i> <span class="text">Opportunities</span>
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
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor'])))
 					<a href="javascript:void(0)" data-href="/posts" class='list-group-item' data-toggle="popover" data-content="
 						<a target='_blank' href='/public-posts'><i class='fa fa-globe'></i> Public Announcements Page</a>
 						<a href='/posts'><i class='fa fa-thumb-tack'></i> All Announcements</a>
 						<a href='/posts/create'><i class='fa fa-plus'></i> New Announcement</a>
 					">
						<i class="fa fa-thumb-tack"></i> <span class="text">Announcements</span>
 					</a>
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin','Editor'])))
					<!-- <a href="/addresses" class="list-group-item"><i class="fa fa-home"></i> <span class="text">Addresses</span></a> -->
					<!-- <a href="/bonuses" class="list-group-item"><i class="fa fa-certificate"></i> Bonuses</a> -->
					<!-- <a href="/carts" class="list-group-item"><i class="fa fa-shopping-cart"></i> Cart</a> -->
					<!-- <a href="/commissions" class="list-group-item">Commissions</a> -->
					<!-- <a href="/emailMessages" class="list-group-item"><i class="fa fa-envelope"></i> <span class="text">EmailMessages</span></a> -->
					<!-- <a href="/levels" class="list-group-item"><i class="fa fa-sitemap"></i> Levels</a> -->
					<!-- <a href="/payments" class="list-group-item">Payments</a> -->
 					<a href="javascript:void(0)" data-href="/products" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/products'><i class='fa fa-mobile-phone'></i> All Products</a>
 						<a href='/productCategories'><i class='fa fa-mobile-phone'></i> All Product Categories</a>
 						<a href='/products/create'><i class='fa fa-plus'></i> New Product</a>
 						<a href='/productCategories/create'><i class='fa fa-plus'></i> New Product Category</a>
 					">
						<i class="fa fa-mobile-phone"></i> <span class="text">Products</span>
					</a>
					<!-- <a href="/profiles" class="list-group-item"><i class="fa fa-user"></i> Profiles</a> -->
					<!-- <a href="/ranks" class="list-group-item"><i class="fa fa-certificate"></i> Ranks</a> -->
					<!-- <a href="/reviews" class="list-group-item"><i class="fa fa-comments"></i> Reviews</a> -->
					<!-- <a href="/roles" class="list-group-item"><i class="fa fa-user"></i> Roles</a> -->
					<!-- <a href="/sales" class="list-group-item"><i class="fa fa-dollar"></i> Sales</a> -->
 					<!-- <a title="Users" href='/users' class="list-group-item"><i class='fa fa-user'></i> <span class="text">Users</span></a> -->
 				@endif
 				@if ((Auth::check())&&(Auth::user()->hasRole(['Superadmin','Admin'])))
 					<a href="javascript:void(0)" data-href="/users" class='list-group-item' data-toggle="popover" data-content="
 						<a href='/users'><i class='fa fa-user'></i> All Users</a>
 						<a href='/users/create'><i class='fa fa-plus'></i> New User</a>
 					">
 						<i class="fa fa-user"></i> <span class="text">Users</span>
 					</a>
 					<a title="Site Settings" href="/config" class="list-group-item"><span class="fa fa-cog"></span> <span class="text">Site Settings</span></a>
 					<!-- <a href="/userProducts" class="list-group-item"><i class="fa fa-mobile-phone"></i> UserProducts</a> -->
					<!-- <a href="/userRanks" class="list-group-item"><i class="fa fa-certificate"></i> UserRanks</a> -->
					<!-- <a href="/smsMessages" class="list-group-item"><i class="fa fa-mobile-phone"></i> <span class="text">SmsMessages</span></a> -->
				@endif
 			</div>
