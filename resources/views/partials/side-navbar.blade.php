<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                {{-- <li>
                    <a href="{{ route('getDashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboard">Dashboard</span>
                    </a>
                </li> --}}

                <li>
                    <a href="{{ route('getCompany') }}" class="waves-effect">
                        <i class='bx bx-book'></i>
                        <span key="t-company">Company</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class='bx bx-book'></i>
                        <span key="t-master">Master</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('getCourse') }}" key="t-carousel">Course</a></li>
                        <li><a href="{{ route('getCourseType') }}" key="t-testimonial">Course Type</a></li>
                        <li><a href="{{ route('getCoursePackage') }}" key="t-blog">Course Package</a></li>
                        <li><a href="{{ route('getDifficulty') }}" key="t-blog">Course Difficulty</a></li>
                        <li><a href="{{ route('getPartner') }}" key="t-blog">Partners</a></li>
                        <li><a href="{{ route('getCategory') }}" key="t-blog">Category</a></li>
                        <li><a href="{{ route('getProposalType') }}" key="t-blog">Proposal Type</a></li>
                        <li><a href="{{ route('getProposalStatus') }}" key="t-blog">Proposal Status</a></li>
                        <li><a href="{{ route('getEventType') }}" key="t-blog">Event Type</a></li>
                        <li><a href="{{ route('getPartnershipType') }}" key="t-blog">Partnership Type</a></li>
                        <li><a href="{{ route('getSurvey') }}" key="t-blog">Survey</a></li>
                        <li><a href="{{ route('getAcademicPeriod') }}" key="t-blog">Academic Period</a></li>
                        <li><a href="{{ route('getScore') }}" key="t-blog">Grade</a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class='bx bxs-graduation'></i>
                        <span key="t-class">Class</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('getCourseClass') }}" key="t-class">Class Management</a></li>
                        <li><a href="{{ route('certificate-templates.index') }}" key="t-certificate">Certificate
                                Template</a></li>
                        <li><a href="{{ route('getCCMH') }}" key="t-student-tracker">Student Tracker</a></li>
                <li><a href="{{ route('getGrade') }}" key="t-grade-assignment">Grade Assignment</a></li>
            </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class='bx bx-calendar-event'></i>
                    <span key="t-schedule">Schedule</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('getSchedule') }}" key="t-schedule">Schedule</a></li>
                    <li><a href="{{ route('getGeneralSchedule') }}" key="t-general-schedule">General Schedule</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class='bx bx-lock-open'></i>
                    <span key="t-user-access">User & Access</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('getUser') }}" key="t-user">Users</a></li>
                    <li><a href="{{ route('getAccessGroup') }}" key="t-access-group">Access Group</a></li>
                    <li><a href="{{ route('getAccessMaster') }}" key="t-access-master">Access Master</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class='bx bx-cart'></i>
                    <span key="t-transaction">Transaction</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('getTransOrder') }}" key="t-order">Order</a></li>
                    <li><a href="{{ route('getVoucher') }}" key="t-voucher">Vouchers</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class='bx bx-user-circle'></i>
                    <span key="t-member">Member</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('getTestimonial') }}" key="t-testimonial">Testimonial</a></li>
                    <li><a href="{{ route('getRedeemCode') }}" key="t-redeem-code">Redeem Code</a></li>
                    <li><a href="{{ route('getProposal') }}" key="t-proposal">Proposal</a></li>
                    <li><a href="{{ route('getTranskrip') }}" key="t-proposal">Transkrip</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bxs-bar-chart-alt-2"></i>
                    <span key="t-content">Content</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('getCarousel') }}" key="t-carousel">Carousel</a></li>
                    <li><a href="{{ route('getEvent') }}" key="t-event">Event</a></li>
                    <li><a href="{{ route('getPartnership') }}" key="t-partnership">Partnership</a></li>
                    <li><a href="#" key="t-testimonial">Testimonial</a></li>
                    <li><a href="{{ route('getBlog') }}" key="t-blog">Blog</a></li>
                    <li><a href="{{ route('getBlogTag') }}" key="t-blog-tag">Blog Tag</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class='bx bx-cog'></i>
                    <span key="t-setting">Settings</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('getGeneral') }}" key="t-general">General</a></li>
                    <li><a href="{{ route('getMaxyTalk') }}" key="t-maxy-talk">Maxy Talk</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('profile') }}" class="waves-effect">
                    <i class="bx bx-info-circle"></i>
                    <span key="t-profile">Profile</span>
                </a>
            </li> --}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
