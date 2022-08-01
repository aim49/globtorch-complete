<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label"><h3 class="text-primary">{{ auth()->user()->name.' '.auth()->user()->surname }}</h3></li>
                <li> <a href="/home" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Home</span></a></li>
                <!--student-->
                @if(auth()->user()->user_type=='student')
                    <li> <a href="/enrollment" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">My Courses</span></a></li>
                    <li> <a href="{{route('student.teachers')}}" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">My Teachers</span></a></li>
                    <li> <a href="{{ route('studentassignments') }}" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Assignments</span></a></li>
                    <li> <a href="{{route('discussions')}}" aria-expanded="false"><i class="far fa-comments"></i><span class="hide-menu">Discussions</span></a></li>
                    <li><a href="{{ route('course.report') }}"><i class="far fa-newspaper"></i><span class="hide-menu">Report</span></a></li>
                    <li><a href="{{ route('feedback.create') }}"><i class="fas fa-comment-dots"></i><span class="hide-menu">Feedback</span></a></li>
                    <li><a href="https://library.globtorch.com" target="_blank"><i class="fas fa-atlas"></i><span class="hide-menu">Library</span></a></li>
                    <li><a href="{{ route('commission.instructions') }}"><i class="far fa-money-bill-alt"></i><span class="hide-menu">Invite and Earn</span></a></li>
                    <li><a href="{{ route('course.resource') }}"><i class="fas fa-file-archive"></i><span class="hide-menu">External Resources</span></a></li>
                    <li>
                        <a href="{{ route('chat_room.index') }}">
                            <i class="fas fa-sms"></i>
                            <span class="hide-menu">Chat</span>
                            @if ($unread_chats > 0)
                                &nbsp;<span class="badge badge-danger">{{$unread_chats}}</span>
                            @endif
                        </a>
                    </li>
                    <li><a href="{{ asset('docs/student_guide.pdf') }}" target="_blank"><i class="fa fa-book"></i><span class="hide-menu">Student Guide</span></a></li>
                <!---teacher--->
                @elseif(auth()->user()->user_type=='teacher')
                    <li> <a href="/teacher_subjects" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">My Subjects</span></a></li>
                    <li> <a href="/assignment/subjects" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Assignments</span></a></li>
                    <li> <a href="/discussion" aria-expanded="false"><i class="far fa-comments"></i><span class="hide-menu">Discussions</span></a></li>
                    <li><a href="{{ route('feedback.create') }}"><i class="fas fa-comment-dots"></i><span class="hide-menu">Feedback</span></a></li>
                    <li>
                        <a href="{{ route('chat_room.index') }}">
                            <i class="fas fa-sms"></i>
                            <span class="hide-menu">Chat Application</span>
                            @if ($unread_chats > 0)
                                &nbsp;<span class="badge badge-danger">{{$unread_chats}}</span>
                            @endif
                        </a>
                    </li>
                <!---admin --->
                @elseif(auth()->user()->user_type=='admin')
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Student</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <div class="card">
                                <div class="card-body">
                                    <li><a href="/student/create"><h3 class="card-title text-primary">Add Student</h3> </a></li>
                                    <li><a href="/student"> <h3 class="card-title text-danger">View Students</h3> </a></li>
                                    <li><a href="{{ route('view_paid_students')  }}"><h3 class="card-title text-success">View Paid Students</h3> </a></li>
                                    <li><a href="{{ route('student.view.course') }}"><h3 class="card-title text-primary">By Course</h3></a></li>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fas fa-user-tie"></i><span class="hide-menu">Teacher</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <div class="card">
                                <div class="card-body">
                                    <li><a href="/teacher/create"><h3 class="card-title text-primary">Add Teacher</h3> </a></li>
                                    <li><a href="/teacher"> <h3 class="card-title text-danger">View Teachers</h3> </a></li>
                                    <li><a href="/teacher_activity"> <h3 class="card-title text-success">All Activities</h3> </a></li>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-clipboard"></i><span class="hide-menu">Exam Boards</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <div class="card">
                                <div class="card-body">
                                    <li><a href="/exam_board/create"><h3 class="card-title text-primary">Add Exam Board</h3> </a></li>
                                    <li><a href="/exam_board"> <h3 class="card-title text-danger">View Exam_Boads</h3> </a></li>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Courses</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <div class="card">
                                <div class="card-body">
                                    <li><a href="/course/create"><h3 class="card-title text-primary">Add Course</h3> </a></li>
                                    <li><a href="/course"> <h3 class="card-title text-danger">View Courses</h3> </a></li>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="far fa-money-bill-alt"></i><span class="hide-menu">Payments</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <div class="card">
                                <div class="card-body">
                                    <li><a href="/commission"> <h3 class="card-title text-primary">Commissions</h3> </a></li>
                                    <li><a href="/manual_payment"> <h3 class="card-title text-danger">Manual Payment</h3> </a></li>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fas fa-mobile-alt"></i><span class="hide-menu">Announcement</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <div class="card">
                                <div class="card-body">
                                    <li><a href="/announcement/create"> <h3 class="card-title text-primary">Create</h3> </a></li>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li> 
                        <a href="{{ route('feedback.index') }}"><i class="fas fa-comment-dots"></i><span class="hide-menu">Feedback</span></a>
                    </li>
                    <li> 
                        <a href="{{ route('directory.index') }}"><i class="fa fa-book"></i><span class="hide-menu">Directories</span></a>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="far fa-building"></i><span class="hide-menu">Institutions</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <div class="card">
                                <div class="card-body">
                                    <li><a href="{{ route('institution.index') }}"> <h3 class="card-title text-primary">View All</h3> </a></li>
                                    <li><a href="{{ route('institution.create') }}"> <h3 class="card-title text-danger">Create</h3> </a></li>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li> 
                        <a href="{{ route('message_log.index') }}"><i class="fas fa-sms"></i><span class="hide-menu">Message Log</span></a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
