<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled pt-3" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ active_class(['dashboard']) }}">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    
    @can('visitor') 
      <li class="nav-item {{ active_class(['appoinment']) }}">
        <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="{{ is_active_route(['appointment','appointment/*']) }}" aria-controls="basic-ui">
          <i class="menu-icon mdi mdi-dna"></i>
          <span class="menu-title">Appointment</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ show_class(['appointment','appointment/*']) }}" id="basic-ui">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{ active_class(['appointment']) }}">
              <a class="nav-link" href="{{ route('appointment.index') }}">Create Ticket</a>
            </li>
            <li class="nav-item {{ active_class(['appointment/history']) }}">
              <a class="nav-link" href="{{ route('appointment.history') }}">My Ticket</a>
            </li>
          </ul>
        </div>
      </li>
    @endcan

    @can('admin')
      <li class="nav-item {{ active_class(['qrScanView','qrScan']) }}">
        <a class="nav-link" href="{{ route('qrScanView.index') }}">
          <i class="menu-icon mdi mdi-qrcode-scan"></i>
          <span class="menu-title">Scan QR Code</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['appointment']) }}">
        <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="{{ is_active_route(['appointment/*']) }}" aria-controls="basic-ui">
          <i class="menu-icon mdi mdi-dna"></i>
          <span class="menu-title">Approval</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ show_class(['appointment/*']) }}" id="basic-ui">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item {{ active_class(['appointment/appointment-ticket']) }}">
              <a class="nav-link" href="{{ route('ticket.index') }}">Appointment Ticket</a>
            </li>
            <li class="nav-item {{ active_class(['appointment/history']) }}">
              <a class="nav-link" href="{{ route('appointment.history') }}">History</a>
            </li>
          </ul>
        </div>
      </li>
    @endcan

    {{-- <li class="nav-item {{ active_class(['tables/basic-table']) }}">
      <a class="nav-link" href="#">
        <i class="menu-icon mdi mdi-table-large"></i>
        <span class="menu-title">Tables</span>
      </a>
    </li> --}}
  </ul>
</nav>