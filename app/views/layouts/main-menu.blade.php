 			<div class="list-group" id="main-menu">
 				@if (Auth::user()->hasRole(['Rep']))
 					<a href="{{ url('dashboard') }}" class="list-group-item"><i class="fa fa-dashboard"></i> Dashboard</a>
 					<a href="{{ url('downline', Auth::user()->id) }}" class="list-group-item"><i class="fa fa-home"></i> Team</a>
 				@endif
 				@if (Auth::user()->hasRole(['Superadmin','Admin']))
					<a href="{{ url('addresses') }}" class="list-group-item"><i class="fa fa-home"></i> Addresses</a>
					<a href="{{ url('bonuses') }}" class="list-group-item"><i class="fa fa-certificate"></i> Bonuses</a>
					<a href="{{ url('carts') }}" class="list-group-item"><i class="fa fa-shopping-cart"></i> Cart</a>
					<!-- <a href="{{ url('commissions') }}" class="list-group-item">Commissions</a> -->
					<a href="{{ url('emailMessages') }}" class="list-group-item"><i class="fa fa-envelope"></i> EmailMessages</a>
					<a href="{{ url('images') }}" class="list-group-item"><i class="fa fa-file-image-o"></i> Images</a>
					<a href="{{ url('levels') }}" class="list-group-item"><i class="fa fa-sitemap"></i> Levels</a>
					<a href="{{ url('pages') }}" class="list-group-item"><i class="fa fa-file-o"></i> Pages</a>
					<!-- <a href="{{ url('payments') }}" class="list-group-item">Payments</a> -->
					<a href="{{ url('products') }}" class="list-group-item"><i class="fa fa-mobile-phone"></i> &nbsp;Products</a>
					<a href="{{ url('profiles') }}" class="list-group-item"><i class="fa fa-user"></i> Profiles</a>
					<a href="{{ url('ranks') }}" class="list-group-item"><i class="fa fa-certificate"></i> Ranks</a>
					<a href="{{ url('reviews') }}" class="list-group-item"><i class="fa fa-comments"></i> Reviews</a>
					<a href="{{ url('roles') }}" class="list-group-item"><i class="fa fa-user"></i> Roles</a>
					<a href="{{ url('sales') }}" class="list-group-item"><i class="fa fa-dollar"></i> Sales</a>
					<a href="{{ url('users') }}" class="list-group-item"><i class="fa fa-users"></i> Users</a>
					<a href="{{ url('userProducts') }}" class="list-group-item"><i class="fa fa-mobile-phone"></i> UserProducts</a>
					<a href="{{ url('userRanks') }}" class="list-group-item"><i class="fa fa-certificate"></i> UserRanks</a>
					<a href="{{ url('smsMessages') }}" class="list-group-item"><i class="fa fa-mobile-phone"></i> SmsMessages</a>
				@endif
 			</div>