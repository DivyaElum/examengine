<aside class="main-sidebar">
    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Sheshkumar Prjajapati</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li class="{{ active('admin/dashboard') }}">
          <a href="{{ url('/admin') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="{{ active(['admin/question-type','admin/question-type/*']) }}">
          <a href="{{ route('question-type.index') }}">
            <i class="fa fa-bars"></i> <span>Question Types</span>
          </a>
        </li>

        <li class="{{ active(['admin/repository','admin/repository/*']) }}">
          <a href="{{ route('repository.index') }}">
            <i class="fa fa-bars"></i> <span>Repository</span>
          </a>
        </li>
        <li class="{{ active(['admin/site-setting','admin/site-setting/*']) }}">
          <a href="{{ route('site-setting.index') }}">
            <i class="fa fa-bars"></i> <span>Site setting</span>
          </a>
        </li>
        <li class="{{ active(['admin/concil-members','admin/concil-members/*']) }}">
          <a href="{{ url('/admin/concil-member') }}">
            <i class="fa fa-bars"></i> <span>Council Members</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
</aside>