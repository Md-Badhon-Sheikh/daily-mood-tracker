<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            DBA<span>Clinic</span>
        </a>
        <div class="sidebar-toggler ">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Admin</li>
            <!--  Dashboard  -->
            <li class="nav-item ">
                <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li
                class="nav-item">
                <a class="nav-link"  href="{{route('admin.mood_type')}}" role="button">
                    <i class="fa-regular fa-user"></i>
                    <span class="link-title">Mood Type Manage</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- partial -->