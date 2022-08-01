<nav class="navbar top-navbar navbar-expand-md navbar-light">
    <!-- Logo -->
    <div class="navbar-header">
 <a class="navbar-brand sidebartoggler" href="javascript:void(0)"  title="Sidebar Menu Toggler">
             <!-- Logo icon -->
            <b><img src="{{ URL::to('images/favicon.png') }}" alt="homepage" class="dark-logo" /></b>
            <!--End Logo icon -->
            <!-- Logo text -->
           <!-- <span><img src="{{ URL::to('images/logo-text.png') }}" alt="homepage" class="dark-logo" /></span> -->
            Globtorch  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-bars"></i></a> </li>
        </a>
    </div>
    <!-- End Logo -->
    <div class="navbar-collapse">
        <!-- toggle and nav items -->
        <ul class="navbar-nav mr-auto mt-md-0">
            <!-- This is  -->
            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted" href="javascript:void(0)"></a> </li>
            <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"></a> </li>
            <!-- Messages -->
           <!-- <li class="nav-item dropdown mega-dropdown"> <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-th-large"></i></a>
                <div class="dropdown-menu animated zoomIn">
                    modal here 
                </div>
            </li>-->
            <!-- End Messages -->
        </ul>
          <marquee width="80%" direction="left" height="30%" scrollamount="2">Announcement: Video content coming up soon. Currently under development.</marquee>
        <!-- User profile and search -->
        <ul class="navbar-nav my-lg-0">

            <!-- Comment -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted text-muted  notification" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell  faa-ring animated"></i>
                    @if ($unread_notifications > 0)
                        <span class="badge">{{$unread_notifications}}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                    <ul>
                        <li>
                            <div class="drop-title">Notifications</div>
                        </li>
                        <li>
                            <div class="message-center">
                                @if (count($notifications) > 0)
                                    @foreach ($notifications as $notification)
                                        @if($notification->isRead)
                                            <!-- Read Messages -->
                                            <a href="/notification/{{$notification->id}}">
                                                <div class="mail-contnet">
                                                    <h5>{{$notification->title}}</h5> 
                                                    <span class="mail-desc">{{$notification->body}}</span> 
                                                    <span class="time">{{$notification->created_at}}</span>
                                                </div>
                                            </a>    
                                        @else
                                            <!-- Message -->
                                            <a href="/notification/{{$notification->id}}">
                                                <div class="mail-contnet">
                                                    <h5><b>{{$notification->title}}</b></h5> 
                                                    <span class="mail-desc">{{$notification->body}}</span> 
                                                    <span class="time">{{$notification->created_at}}</span>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    <p>There are currently no notifications</p>
                                @endif
                            </div>
                        </li>
                        <li>
                            <a class="nav-link text-center" href="/notification"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- End Comment -->
            <!-- Profile -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ URL::to('images/no_picture.jpeg') }}" alt="user" class="profile-pic" /></a>
                <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                    <ul class="dropdown-user">
                        <li><a href="/user/{{auth()->user()->id}}/edit"><i class="ti-user"></i> Profile</a></li>
                        <li><a href="/password/change"><i class="ti-user"></i> Change Password</a></li>
                        <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
