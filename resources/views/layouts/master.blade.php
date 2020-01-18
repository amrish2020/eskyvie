
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="/css/app.css" rel="stylesheet"/>
</head>
<body class="hold-transition sidebar-mini layout-boxed">
<!-- Site wrapper -->
<div class="wrapper"  id="app">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="img/logo.png" alt="Demo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="img/profile.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}
            <br/>
            {{ Auth::user()->role }}
            </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link" active-class="active" >
                        My Account
                    </router-link>
                </li>
                @can('isCustomer')
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>My Account</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Address Book</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>My Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Return Orders</p>
                        </a>
                    </li>
                @endcan

                @can('isClientAdmin')
                    <li class="nav-item has-treeview ">
                        <router-link to="/users" class="nav-link" active-class="active" >
                            <p>User Management</p>
                        </router-link>
                    </li>
                    <li class="nav-item has-treeview ">
                        <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-smile-beam"></i>
                          <p>
                            Happening Management
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <router-link to="/articles" class="nav-link" active-class="active" >
                              <i class="fas fa-edit"></i>
                              <p>Articles</p>
                            </router-link>
                          </li>
                          <li class="nav-item">
                            <router-link to="/news" class="nav-link" active-class="active" >
                              <i class="fas fa-paperclip"></i>
                              <p>News</p>
                            </router-link>
                          </li>
                          <li class="nav-item">
                            <router-link to="/media" class="nav-link" active-class="active" >
                              <i class="fas fas fa-image"></i>
                              <p>Media</p>
                            </router-link>
                          </li>
                          <li class="nav-item">
                            <router-link to="/events" class="nav-link" active-class="active" >
                              <i class="fas fa-list"></i>
                              <p>Events</p>
                            </router-link>
                          </li>
                        </ul>
                      </li>
                @endcan
                @can('isAdmin')
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Transactions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Customer</p>
                        </a>
                    </li>
                @endcan
                @can('isMarExecOrMarMgr')
                    <li class="nav-item">
                        <router-link to="/submit-leads" class="nav-link" active-class="active" >
                        <p>Submit Leads</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>My Leads</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <router-link to="/commission" class="nav-link" active-class="active" >
                            <p> Commission & Rewards</p>
                        </a>
                    </li>
                    <hr/>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>My Team</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <router-link to="/team-marleads" class="nav-link" active-class="active" >
                            <p>Team Leads</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/team-ads" class="nav-link" active-class="active" >
                            <p>Team Ads</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/team-member" class="nav-link" active-class="active" >
                        <p>Team Member</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Leaderboard</p>
                        </a>
                    </li>
                @endcan

                @can('isSaleExecOrSaleMgr')
                    <li class="nav-item">
                        <router-link to="/customer_leads" class="nav-link" active-class="active" >
                        <p>Customer</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Sales Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" active-class="active" >
                            <p>Commission & Rewards</p>
                        </a>
                    </li>
                    <hr/>
                        <li class="nav-item">
                            <a href="#" class="nav-link" active-class="active" >
                                <p>My Team</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <router-link to="/team-member" class="nav-link" active-class="active" >
                            <p>Members</p>
                            </router-link>
                        </li>
                    @can('isSalesMgr')

                        <li class="nav-item">
                            <router-link to="/assignleads" class="nav-link" active-class="active" >
                            <p>Assign Leads</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/team_customer" class="nav-link" active-class="active" >
                                <p>Team Customer</p>
                            </router-link>

                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" active-class="active" >
                                <p>Team Sales Order</p>
                            </a>
                        </li>
                    @endcan
                @endcan

                <li class="nav-item">
                    <router-link to="/profile" class="nav-link" active-class="active" >
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Profile</p>
                    </router-link>
                </li>
                <!--li class="nav-item">
                <router-link to="/developer" class="nav-link" active-class="active" >
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                    Developer
                    </router-link>
                </a>
                </li-->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p> {{ __('Logout') }}</p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <!-- Main Footer -->
   <footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
@auth
<script>
    window.user = @json(auth()->user());
</script>
@endauth

<!-- REQUIRED SCRIPTS -->
<script src="js/app.js"></script>
</body>
</html>
