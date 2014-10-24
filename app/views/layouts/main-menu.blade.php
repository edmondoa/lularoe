 			<div class="list-group" id="main-menu">
 				@if (Auth::user()->hasRole(['Superadmin','Admin','Rep']))
 					<a href="/dashboard" class="list-group-item"><i class="fa fa-dashboard"></i> Dashboard</a>
 					<a href="/downline/{{ Auth::user()->id }}" class="list-group-item"><i class="fa fa-home"></i> Team</a>
 				@endif
 				@if (Auth::user()->hasRole(['Superadmin','Admin']))
					<a href="/addresses" class="list-group-item"><i class="fa fa-home"></i> Addresses</a>
					<a href="/bonuses" class="list-group-item"><i class="fa fa-certificate"></i> Bonuses</a>
					<a href="/carts" class="list-group-item"><i class="fa fa-shopping-cart"></i> Cart</a>
					<!-- <a href="/commissions" class="list-group-item">Commissions</a> -->
					<a href="/emailMessages" class="list-group-item"><i class="fa fa-envelope"></i> EmailMessages</a>
					<a href="/images" class="list-group-item"><i class="fa fa-file-image-o"></i> Images</a>
					<a href="/levels" class="list-group-item"><i class="fa fa-sitemap"></i> Levels</a>
					<a href="/pages" class="list-group-item"><i class="fa fa-file-o"></i> Pages</a>
					<!-- <a href="/payments" class="list-group-item">Payments</a> -->
					<a href="/products" class="list-group-item"><i class="fa fa-mobile-phone"></i> &nbsp;Products</a>
					<a href="/profiles" class="list-group-item"><i class="fa fa-user"></i> Profiles</a>
					<a href="/ranks" class="list-group-item"><i class="fa fa-certificate"></i> Ranks</a>
					<a href="/reviews" class="list-group-item"><i class="fa fa-comments"></i> Reviews</a>
					<a href="/roles" class="list-group-item"><i class="fa fa-user"></i> Roles</a>
					<a href="/sales" class="list-group-item"><i class="fa fa-dollar"></i> Sales</a>
					<a href="/users" class="list-group-item"><i class="fa fa-users"></i> Users</a>
					<a href="/userProducts" class="list-group-item"><i class="fa fa-mobile-phone"></i> UserProducts</a>
					<a href="/userRanks" class="list-group-item"><i class="fa fa-certificate"></i> UserRanks</a>
					<a href="/smsMessages" class="list-group-item"><i class="fa fa-mobile-phone"></i> SmsMessages</a>
				@endif
 			</div>