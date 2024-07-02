<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">CINTA</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page"
                        href="{{ route('dashboard.index') }}">
                        <svg class="bi">
                            <use xlink:href="#house-fill" />
                        </svg>
                        Dashboard
                    </a>
                </li>
            </ul>

            <hr class="my-3">

            <h5
                class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-3 text-body-secondary text-uppercase">
                <span>CHECKSHEET</span>
            </h5>
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('acserver.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        AC Server
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('csdatabase.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Backup Database
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('tapedrive.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Backup Server Tape
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('gacsirt.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        GA-CSIRT Report
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('mointernet.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Monitoring Internet
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('cctv.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Monitoring CCTV
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('physical.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Physical Server
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('fujixerox.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Printer Fujixerox
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('sanswitch.index') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Sanswitch
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2"
                        href="{{ route('server_electric.checksheet_list') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Server Electric
                    </a>
                </li>
                <hr class="my-3">
                <h5
                    class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-3 text-body-secondary text-uppercase">
                    <span>MASTER</span>
                </h5>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2"
                        href="{{ route('server_electric.master_list') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Master Server Electric
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('tapedrive.master_list') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Master Backup Server Tape
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Master Server CCTV
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Master Physical Server
                    </a>
                </li>
                <br> --}}
                {{-- @can('admin')
                    <h5
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-3 text-body-secondary text-uppercase">
                        <span>ADMINISTRATOR</span>
                    </h5>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="#">
                            <svg class="bi">
                                <use xlink:href="#file-earmark-text" />
                            </svg>
                            Setting
                        </a>
                    </li>
                @endcan
                @can('superadmin')
                    <h5
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-3 text-body-secondary text-uppercase">
                        <span>ADMINISTRATOR</span>
                    </h5>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="#">
                            <svg class="bi">
                                <use xlink:href="#file-earmark-text" />
                            </svg>
                            Setting
                        </a>
                    </li>
                @endcan <br><br><br><br><br> --}}
                <br><br><br>
        </div>
    </div>
</div>
