
<header class="main-header">
    <a href="{{ url('/') }}" class="logo">
      <span class="logo-mini"><b><?php echo $siteSetting->site_title ?? 'Managed Services Council'; ?></span>
      <span class="logo-lg"><b><?php echo $siteSetting->site_title ?? 'Managed Services Council'; ?></b></span>
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
              <a href="{{ url('/admin/logout') }}" class="btn btn-default btn-flat" title="Log out"><i class="fa fa-sign-out"></i></a>
          </li>
        </ul>
      </div>
    </nav>
</header>
