@php
    $nik = auth()->user()->nik;
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
    $timeFrameWeek = 'Week';
    $timeFrameMonth = 'Month';
@endphp
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            <img src="{{ asset('assets') }}/images/logo/icon-hgt.png" alt=""> App<span>Task</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Home</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/Dashboard') }}" class="nav-link" role="button" aria-expanded="false"
                    aria-controls="general-pages" target="_blank">
                    <i class="link-icon" data-feather="grid"></i>
                    <span class="link-title">Full Dashboard</span>
                </a>
            </li>
            @if ($depart == 3 || in_array($role, [20, 15]))
                <li class="nav-item nav-category">Issue</li>
                <li class="nav-item">
                    <a href="{{ url('Search/Data-Issue') }}" class="nav-link" role="button" aria-expanded="false"
                        aria-controls="general-pages">
                        <i class="link-icon" data-feather="search"></i>
                        <span class="link-title">Search</span>
                    </a>
                </li>
                <li class="nav-item nav-category">PIC</li>
                <li class="nav-item">
                    <a href="{{ url('Data/Activity=PIC') }}" class="nav-link" role="button" aria-expanded="false"
                        aria-controls="general-pages">
                        <i class="link-icon" data-feather="trello"></i>
                        <span class="link-title">My Activity</span>
                    </a>
                </li>
            @endif
            @if ($depart != 3)
                <li class="nav-item nav-category">Ticketing</li>
                @if ($depart != 15)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ticket" role="button"
                            aria-expanded="false" aria-controls="ticket">
                            <i class="link-icon" data-feather="edit"></i>
                            <span class="position-relative">
                                <span class="link-title">Manage Ticket</span>
                            </span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="ticket">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ url('helpdesk/manage=Ticket') }}" class="nav-link">
                                        @if ($depart == 9)
                                            AWB Not Available
                                        @elseif ($depart == 10)
                                            Inquiry
                                        @else
                                            All Open
                                            <span
                                                class="position-absolute top-10 start-30 translate-middle-y badge rounded-pill bg-danger">
                                                {{ $not_closed_ticket }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                                @if ($depart == 4 || $role == 15)
                                    <li class="nav-item">
                                        <a href="{{ url('helpdesk/Ticket=today') }}" class="nav-link">
                                            Open Today
                                        </a>
                                    </li>
                                @elseif ($depart == 10)
                                    <li class="nav-item">
                                        <a href="{{ url('helpdesk/Ticket=today') }}" class="nav-link">
                                            Request List
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('ticket.closed') }}" class="nav-link">
                                        @if ($depart == 9)
                                            AWB Available
                                        @elseif ($depart == 10)
                                            Complete
                                        @else
                                            Closed
                                        @endif
                                    </a>
                                </li>
                                @if (($role == 19 && $depart == 4) || $role == 20)
                                    <li class="nav-item">
                                        <a href="{{ route('ticket.cancel') }}" class="nav-link">
                                            Cancel Ticket
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (in_array($depart, [6, 15]) || $role == 20)
                    @php
                        $temp = 'null';
                    @endphp
                    <li class="nav-item">
                        <a href="{{ url("My-Expenses/id=$temp") }}" class="nav-link" role="button"
                            aria-expanded="false" aria-controls="general-pages">
                            <i class="link-icon" data-feather="credit-card"></i>
                            <span class="link-title">
                                {{ $dsc_menu = $role == 19 || $depart == 15 ? 'Request' : 'My Expenses' }}
                            </span>
                        </a>
                    </li>
                @endif
            @endif
            @if (in_array($depart, [4, 5, 3, 10, 15]) ||
                    in_array($role, [20, 15]) ||
                    ($depart == 6 && $role == 19) ||
                    in_array($nik, ['HGT-KR138', 'HGT-KR112']))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#reports" role="button" aria-expanded="false"
                        aria-controls="report">
                        <i class="link-icon" data-feather="tag"></i>
                        <span class="link-title">Report</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="reports">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ url('Report/data=Ticket') }}" class="nav-link">Data Report Ticket</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('Compare/report=Ticket') }}" class="nav-link">Compare Report
                                    Ticket</a>
                            </li>
                            @if ($role == 16 && $depart == 4)
                                <li class="nav-item">
                                    <a href="{{ url('Report/data=Each-Week') }}" class="nav-link">Weekly
                                        Ticket</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Report/data=Each-Month') }}" class="nav-link">Monthly
                                        Ticket</a>
                                </li>
                            @elseif ($depart == 15 || $role == 20)
                                <li class="nav-item">
                                    <a href="{{ url('/Report-Expenses') }}" class="nav-link">Data Expenses</a>
                                </li>
                            @endif
                            @if (in_array($role, [20, 15, 19]) || ($role == 16 && in_array($depart, [3, 5, 6, 13, 10])))
                                @if (!in_array($depart, [3, 6, 13, 10]))
                                    <li class="nav-item">
                                        <a href="{{ url('Report/Chart/Monthly-Ticket') }}" class="nav-link">Chart
                                            Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('Report/data=KPI-User') }}" class="nav-link">Timestamps
                                            Engineer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('Report/data=Lat&Lng') }}" class="nav-link">Lat & Lng
                                            Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('Report/KPI/data=L2-en') }}" class="nav-link">Timestamps
                                            L2</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('Report/data=Act-Helpdesk') }}" class="nav-link">Timestamps
                                            Helpdesk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('Report/data=Each-Week') }}" class="nav-link">Weekly
                                            Ticket</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('Report/data=Each-Month') }}" class="nav-link">Monthly
                                            Ticket</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url("Report/Helpdesk=Each-$timeFrameWeek") }}"
                                            class="nav-link">Act Weekly Helpdesk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url("Report/Helpdesk=Each-$timeFrameMonth") }}"
                                            class="nav-link">Act Monthly Helpdesk</a>
                                    </li>
                                    @if ($depart != 5)
                                        <li class="nav-item">
                                            <a href="{{ url("Report/SP=Each-$timeFrameWeek") }}"
                                                class="nav-link">Weekly SP</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url("Report/SP=Each-$timeFrameMonth") }}"
                                                class="nav-link">Monthly SP</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url("Report/AE=Each-$timeFrameWeek") }}" class="nav-link">Act
                                                Weekly
                                                En</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url("Report/AE=Each-$timeFrameMonth") }}"
                                                class="nav-link">Act Monthly
                                                En</a>
                                        </li>
                                    @endif
                                @else
                                    @if ($depart == 3 || $depart == 10)
                                        <li class="nav-item">
                                            <a href="{{ url('Report/data=Each-Week') }}" class="nav-link">Weekly
                                                Ticket</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('Report/data=Each-Month') }}" class="nav-link">Monthly
                                                Ticket</a>
                                        </li>
                                    @elseif ($depart == 6 || $depart == 13)
                                        @if ($role == 19)
                                            <li class="nav-item">
                                                <a href="{{ url('Report/data=KPI-User') }}"
                                                    class="nav-link">Timestamps
                                                    Engineer</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ url('Report/KPI/data=L2-en') }}"
                                                    class="nav-link">Timestamps
                                                    L2</a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ url("Report/SP=Each-$timeFrameWeek") }}"
                                                class="nav-link">Weekly SP</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url("Report/SP=Each-$timeFrameMonth") }}"
                                                class="nav-link">Monthly SP</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url("Report/AE=Each-$timeFrameWeek") }}" class="nav-link">Act
                                                Weekly
                                                En</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url("Report/AE=Each-$timeFrameMonth") }}"
                                                class="nav-link">Act Monthly
                                                En</a>
                                        </li>
                                    @endif
                                @endif
                                <li class="nav-item">
                                    <a href="{{ url('Report/data=History-Ticket') }}" class="nav-link">History
                                        Ticket</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Report/Data=Ticket-Pending') }}" class="nav-link">Pending
                                        Ticket</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Report/Data=Top-Part') }}" class="nav-link">Top Part</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Report/Ticket/Admin') }}" class="nav-link">Temporary</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            @if (in_array($role, [20, 15]) || $depart == 4)
                <li class="nav-item">
                    <a href="{{ url('Trello/Engineer') }}" class="nav-link" role="button" aria-expanded="false"
                        aria-controls="general-pages">
                        <i class="link-icon" data-feather="trello"></i>
                        <span class="link-title">Trello En</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/SP-DT') }}" class="nav-link" role="button" aria-expanded="false"
                        aria-controls="general-pages">
                        <i class="link-icon" data-feather="clipboard"></i>
                        <span class="link-title">SP Detil</span>
                    </a>
                </li>
            @endif
            @if (in_array($depart, [5, 4, 15]) || in_array($role, [20, 15]))
                <li class="nav-item nav-category">Components</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button"
                        aria-expanded="false" aria-controls="forms">
                        <i class="link-icon" data-feather="archive"></i>
                        <span class="link-title">Forms Master</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav sub-menu">
                            @if (($depart == 4 && $role == 19) || in_array($role, [20, 15]))
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Source') }}" class="nav-link">Source</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=ServicePoint') }}" class="nav-link">Service
                                        Point</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Severity') }}" class="nav-link">Severity</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Partner') }}" class="nav-link">Partner</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Type-Part') }}" class="nav-link">Part Type</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Category-Unit') }}" class="nav-link">Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Merk-Unit') }}" class="nav-link">Merk</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Office-Type') }}" class="nav-link">Office
                                        Type</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Unit-Type') }}" class="nav-link">Unit Type</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Type-Ticket') }}" class="nav-link">Ticket
                                        Type</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Category-Part') }}" class="nav-link">Category
                                        Part</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Project') }}" class="nav-link">Project</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=SLA') }}" class="nav-link">SLA</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Category-Note') }}" class="nav-link">Category
                                        Note</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Stats-Pending') }}" class="nav-link">Status
                                        Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Type-Act/PIC') }}" class="nav-link">Type
                                        Activity</a>
                                </li>
                            @endif
                            @if ($depart == 5)
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Project') }}" class="nav-link">Project</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=SLA') }}" class="nav-link">SLA</a>
                                </li>
                            @endif
                            @if ($depart == 15 || in_array($role, [20, 15]))
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Ctgr-Expenses') }}" class="nav-link">Category
                                        Expenses</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/data=Ctgr-Reqs') }}" class="nav-link">Category Reqs</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Master/Data=TypeOfTransportation') }}" class="nav-link">Type of
                                        Transportation</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @if (in_array($role, [20, 15]))
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#initialize" role="button"
                            aria-expanded="false" aria-controls="forms">
                            <i class="link-icon" data-feather="hash"></i>
                            <span class="link-title">Initialize</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="initialize">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ url('Initialize/data=Merk-Category') }}" class="nav-link">Merk
                                        &nbsp;<i class="mdi mdi-arrow-left"></i>&nbsp; Category</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('Master/data=User') }}" class="nav-link" role="button"
                            aria-expanded="false" aria-controls="general-pages">
                            <i class="link-icon" data-feather="user"></i>
                            <span class="position-relative">
                                <span class="link-title">User</span>
                                @if ($not_verif != 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle-y badge rounded-pill bg-danger">
                                        {{ $not_verif }}
                                    </span>
                                @endif
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/WhatsNews') }}" class="nav-link" role="button" aria-expanded="false"
                            aria-controls="general-pages">
                            <i class="link-icon" data-feather="bookmark"></i>
                            <span class="position-relative">
                                <span class="link-title">Whats New's</span>
                        </a>
                    </li>
                @elseif ($depart == 4)
                    <li class="nav-item">
                        <a href="{{ url('/WhatsNews') }}" class="nav-link" role="button" aria-expanded="false"
                            aria-controls="general-pages">
                            <i class="link-icon" data-feather="bookmark"></i>
                            <span class="position-relative">
                                <span class="link-title">Whats New's</span>
                        </a>
                    </li>
                @endif
            @endif
            @if (in_array($role, [20, 15]))
                <li class="nav-item nav-category">Previous System</li>
                <li class="nav-item">
                    <a href="#" class="nav-link" role="button" aria-expanded="false"
                        aria-controls="general-pages">
                        <i class="link-icon" data-feather="table"></i>
                        <span class="position-relative">
                            <span class="link-title">Ticket</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-category">Main Website HGT</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#wbHGT-product" role="button"
                        aria-expanded="false" aria-controls="forms">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Product Menu</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="wbHGT-product">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ url('Master/data-Web=Category-Product') }}" class="nav-link">Category</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('Master/data-Web=Product') }}" class="nav-link">Product</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ url('Data/Inquiry-Message') }}" class="nav-link" role="button"
                        aria-expanded="false" aria-controls="general-pages">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="position-relative">
                            <span class="link-title">Inquiry Message</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-category">Pages</li>
                <li class="nav-item">
                    <a href="{{ url('/Test') }}" class="nav-link" role="button" aria-expanded="false"
                        aria-controls="general-pages">
                        <i class="link-icon" data-feather="settings"></i>
                        <span class="link-title">Test</span>
                    </a>
                </li>
            @endif
            <li class="nav-item nav-category">Docs</li>
            <li class="nav-item">
                <form method="POST" action="{{ url('/Docs-download') }}" style="display: none;" id="fdd-sistem">
                    @csrf
                </form>
                <a href="javascript:;" class="nav-link a-fdd-sistem">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Documentation</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
@push('custom')
    <script>
        $('.a-fdd-sistem').on('click', function() {
            jQuery('#fdd-sistem').submit();
        });
    </script>
@endpush
