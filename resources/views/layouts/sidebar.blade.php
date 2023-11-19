<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">CINTA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="#">
                    <svg class="bi"><use xlink:href="#house-fill"/></svg>
                    Dashboard
                </a>
            </li>
        </ul>
        
        <hr class="my-3">

        <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-3 text-body-secondary text-uppercase">
          <span>CHECKSHEET</span>
        </h5>
        <ul class="nav flex-column mb-auto">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              AC Server
            </a>
          </li>
          <li class="nav-item" style="color: red;">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('database.index') }}">
                <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
                Backup Database
            </a>
          </li>      
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Backup Server Tape
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              GA-CSIRT Report
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Monitoring Internet
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Monitoring CCTV
            </a>
          </li>
          <li class="nav-item" style="fill: rgb(248, 13, 13)">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('physical.index') }}">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Physical Server
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Printer Fujixerox
            </a>
          </li>
          <li class="nav-item" style="fill: rgb(248, 13, 13)">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('sanswitch.index') }}">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Sanswitch
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Safe Stock Device
            </a>
          </li>
          </ul>

        <br>
        <hr class="my-3">

        <ul class="nav flex-column mb-auto">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#gear-wide-connected"/></svg>
              Settings
            </a>
          </li>
          <li class="nav-item mb-2">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#door-closed"/></svg>
              Logout
            </a>
          </li><br><br><br>
        </ul>
      </div>
    </div>
  </div>