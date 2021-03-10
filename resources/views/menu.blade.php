<li class="nav-item {{ Request::is('/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/') }}">
        <i class="fa fa-television" aria-hidden="true"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="nav-item {{ Request::is('/all-fdr') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/all-fdr') }}">
        <i class="fa fa-tasks" aria-hidden="true"></i>
        <span>All FDRs</span>
    </a>
</li>
<li class="nav-item {{ Request::is('/add-fdr') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/add-fdr') }}">
        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
        <span>Add FDR</span>
    </a>
</li>
<li class="nav-item {{ Request::is('/myfdr') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/myfdr') }}">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span>My FDR</span>
    </a>
</li>
@if (Auth::user()->is_admin == 'true')
    <li class="nav-item {{ Request::is('/users') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/users') }}">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Users</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('/pending') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pending') }}">
            <i class="fa fa-shield" aria-hidden="true"></i>
            <span>Pending FDR</span>
        </a>
    </li>
@endif
{{-- <li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        <span>All Session Schedules</span>
    </a>
</li> --}}
{{-- <li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        <span>All Archived Sessions</span>
    </a>
</li> --}}
{{-- <li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fa fa-video-camera" aria-hidden="true"></i>
        <span>Recorded Video</span>
    </a> --}}
{{-- </li> --}}
{{-- <li class="nav-item nav-dropdown">
  <a class="nav-link nav-dropdown-toggle" href="#">
    <i class="fa fa-bar-chart" aria-hidden="true"></i> Report</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="nav-icon icon-star"></i> Day Wise Statistics</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="nav-icon icon-star"></i> Top Users</a>
        </li>
    </ul>
</li> --}}
