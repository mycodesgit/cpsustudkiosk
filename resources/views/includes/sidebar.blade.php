@php
    $current_route = request()->route() ? request()->route()->getName() : null;

    $dashActive = in_array($current_route, ['dashboard.index']) ? 'active' : '';
    $kioskHomeActive = in_array($current_route, ['kioskhome']) ? 'active' : '';
    $kioskAccountActive = in_array($current_route, ['kioskaccount']) ? 'active' : '';
    $kioskSchedActive = in_array($current_route, ['schedclassRead', 'schedclassShow']) ? 'active' : '';
@endphp

<ul class="nav flex-column">
    <li class="px-4 py-2">
        <small class="nav-text text-muted">Main Navigation</small>
    </li>
    @if (Route::has('dashboard.index'))
        <li>
            <a class="nav-link {{ $dashActive }}" href="{{ route('dashboard.index') }}" data-tooltip="Dashboard">
                <i class="ti ti-layout-grid"></i><span class="nav-text">Dashboard</span>
            </a>
        </li>
    @endif
    <li class="px-4 py-2">
        <small class="nav-text text-muted">Student Kiosk</small>
    </li>
    <li>
        <a class="nav-link {{ $kioskHomeActive }}" href="{{ route('kioskhome') }}" data-tooltip="View Grades">
            <i class="ti ti-certificate"></i><span class="nav-text">View Grade</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $kioskAccountActive }}" href="{{ route('kioskaccount') }}" data-tooltip="View Appraisal">
            <i class="ti ti-file-invoice"></i><span class="nav-text">View Appraisal</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $kioskSchedActive }}" href="{{ route('schedclassRead') }}" data-tooltip="View Schedule">
            <i class="ti ti-calendar"></i><span class="nav-text">Class Schedule</span>
        </a>
    </li>
    <li>
        <a class="nav-link" href="{{ route('kiosk.logout') }}" data-tooltip="Logout">
            <i class="ti ti-logout"></i><span class="nav-text">Logout</span>
        </a>
    </li>
</ul>
