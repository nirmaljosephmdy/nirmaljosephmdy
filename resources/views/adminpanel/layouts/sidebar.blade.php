<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->


      <li class="nav-item menu-open">
        <a href="{{route('teacher.home')}}" class="nav-link active">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        {{-- <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="./index.html" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>Dashboard v1</p>
            </a>
          </li>
          <li class="nav-item">
              <p href="./index2.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v2</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="./index3.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v3</p>
            </a>
        </li>
    </ul> --}}
</li>

<li class="nav-header">Teachers</li>



       <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Teachers
            <i class="fas fa-angle-left right"></i>
            <span class="badge badge-info right">2</span>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <a href="{{route('teacher.index')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                View
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('teacher.create')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Add
              </p>
            </a>
          </li>

        </ul>
      </li> 



      <li class="nav-header">Questions</li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Questions
            <i class="fas fa-angle-left right"></i>
            <span class="badge badge-info right">2</span>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                View
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('question.add')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Add
              </p>
            </a>
          </li>

        </ul>
      </li> 


      {{-- <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>
            Charts
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="pages/charts/chartjs.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>ChartJS</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/charts/flot.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Flot</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/charts/inline.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Inline</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/charts/uplot.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>uPlot</p>
            </a>
          </li>
        </ul>
      </li> --}}





      {{-- <li class="nav-item">
        <a href="pages/calendar.html" class="nav-link">
          <i class="nav-icon far fa-calendar-alt"></i>
          <p>
            Calendar
            <span class="badge badge-info right">2</span>
          </p>
        </a>
      </li> --}}


      {{-- <li class="nav-item">
        <a href="pages/gallery.html" class="nav-link">
          <i class="nav-icon far fa-image"></i>
          <p>
            Gallery
          </p>
        </a>
      </li> --}}

      {{-- <li class="nav-item">
        <a href="pages/kanban.html" class="nav-link">
          <i class="nav-icon fas fa-columns"></i>
          <p>
            Kanban Board
          </p>
        </a>
      </li> --}}

      {{-- <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon far fa-envelope"></i>
          <p>
            Mailbox
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="pages/mailbox/mailbox.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Inbox</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/mailbox/compose.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Compose</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/mailbox/read-mail.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Read</p>
            </a>
          </li>
        </ul>
      </li> --}}

      {{-- <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book"></i>
          <p>
            Pages
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="pages/examples/invoice.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Invoice</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/profile.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Profile</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/e-commerce.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>E-commerce</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/projects.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Projects</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/project-add.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Project Add</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/project-edit.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Project Edit</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/project-detail.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Project Detail</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/contacts.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Contacts</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/faq.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>FAQ</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/contact-us.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Contact us</p>
            </a>
          </li>
        </ul>
      </li> --}}


      {{-- <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon far fa-plus-square"></i>
          <p>
            Extras
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Login & Register v1
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/examples/login.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Login v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/register.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/forgot-password.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Forgot Password v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/recover-password.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recover Password v1</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Login & Register v2
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/examples/login-v2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Login v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/register-v2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/forgot-password-v2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Forgot Password v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/recover-password-v2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recover Password v2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="pages/examples/lockscreen.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Lockscreen</p>
            </a>

          </li>
          <li class="nav-item">
            <a href="pages/examples/legacy-user-menu.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Legacy User Menu</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/language-menu.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Language Menu</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/404.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Error 404</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/500.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Error 500</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/pace.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Pace</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/blank.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Blank Page</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="starter.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Starter Page</p>
            </a>
          </li>
        </ul>
      </li> --}}



      {{-- <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-search"></i>
          <p>
            Search
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="pages/search/simple.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Simple Search</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/search/enhanced.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Enhanced</p>
            </a>
          </li>
        </ul>
      </li> --}}


      




    </ul>
  </nav>
