<style type="text/css">
.user-panel {height: 50px !important;}
.user-panel > .info {left: 0px !important; font-size: 20px;}
.dropdown.user.user-menu a {background-color: #3c8dbc;border-color: #3c8dbc;border-color: #3c8dbc;font-size: 16px;font-weight: 700;}
</style>
<aside class="main-sidebar">
    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left info">
          <p>Welcome Admin</p>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="{{ active('admin/dashboard') }}">
          <a href="{{ url('/admin') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview {{ active(['admin/question-type','admin/question-type/*','admin/question-category','admin/question-category/*','admin/question','admin/question/*']) }} ">
          <a href="javascript:void(0)">
            <i class="fa fa-database" aria-hidden="true"></i> <span>Question</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="">
              <li class="{{ active(['admin/question-type','admin/question-type/*']) }}">
                <a href="{{ route('question-type.index') }}">
                  <i class="fa fa-circle-o"></i> <span>Question Types</span>
                </a>
              </li>
              <li class="{{ active(['admin/question-category','admin/question-category/*']) }}">
                <a href="{{ url('/admin/question-category') }}">
                   <i class="fa fa-circle-o"></i> <span>Question Category</span>
                </a>
              </li>
              <li class="{{ active(['admin/question','admin/question/*']) }}">
                <a href="{{ route('question.index') }}">
                   <i class="fa fa-circle-o"></i> <span>Question</span>
                </a>
              </li>
          </ul>
        </li>

        <li class="{{ active(['admin/exam','admin/exam/*']) }}">
          <a href="{{ route('exam.index') }}">
            <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Exam</span>
          </a>
        </li>

        <li class="{{ active(['admin/prerequisite','admin/prerequisite/*']) }}">
          <a href="{{ route('prerequisite.index') }}">
            <i class="fa fa-file-video-o" aria-hidden="true"></i> <span>Prerequisite</span>
          </a>
        </li>

        <li class="{{ active(['admin/course','admin/course/*']) }}">
          <a href="{{ route('course.index') }}">
             <i class="fa fa-folder-open" aria-hidden="true"></i> <span>Course</span>
          </a>
        </li>

        <li class="{{ active(['admin/site-setting','admin/site-setting/*']) }}">
          <a href="{{ route('site-setting.index') }}">
            <i class="fa fa-cog"></i> <span>Site Setting</span>
          </a>
        </li>
        
        <li class="{{ active(['admin/council-member','admin/council-member/*']) }}">
          <a href="{{ url('/admin/council-member') }}">
            <i class="fa fa-id-badge" aria-hidden="true"></i> <span>Council Members</span>
          </a>
        </li>

        <li>
          <a href="{{ url('/admin/logout') }}">
            <i class="fa fa-sign-out"></i><span>Logout</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
</aside>