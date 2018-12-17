
<header class="main-header">
    <a href="{{ url('/') }}" class="logo">
      <span class="logo-mini"><b>Exam</span>
      <span class="logo-lg"><b>Exam</b>DEMO</span>
    </a>
    <nav class="navbar navbar-static-top">

      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('dist/img/admin_avatar.png')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin</span>
            </a>
            <ul class="dropdown-menu">

              <li class="user-header">
                <img src="{{asset('dist/img/admin_avatar.png')}}" class="img-circle" alt="User Image">
                <p>
                  Admin
                </p>
              </li>                          
              <li class="user-footer">
                <div class="pull-left">
                  <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                </div>
                <div class="pull-right">
                  <a href="{{ url('/admin/logout') }}" class="btn btn-default btn-flat">Log out</a>
                </div>
              </li>  
            </ul>
          </li>
        </ul>
      </div>
    </nav>
</header>
