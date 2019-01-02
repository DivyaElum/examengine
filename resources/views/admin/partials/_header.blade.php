
<header class="main-header">
    <a href="{{ url('/admin/dashboard') }}" class="logo">
        @php
        if(!empty($siteSetting->site_logo_image))
        {
          $urlPath = url('/storage/site-setting/thumbnails/'.$siteSetting->site_logo_image);
        }
        else
        {
          $urlPath = url('/images/msc-logo.png');

        }
      @endphp 
        <span class="logo-lg"><img id="logo" src="{{ $urlPath }}" alt="Featured Image" class="img-responsive" style="margin: 4px 0px;" /></span>
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
