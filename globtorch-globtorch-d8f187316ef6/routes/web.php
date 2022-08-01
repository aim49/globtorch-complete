<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Pages that are on the landing page
Route::get('/', 'WelcomeController@index');
Route::get('/primary', 'WelcomeController@primary');
Route::get('/view_courses', 'WelcomeController@courses');
Route::get('/course_details/{id}', 'WelcomeController@course_details');
Route::get('/contact', 'WelcomeController@contact');
Route::get('/news', 'WelcomeController@news');
Route::get('/news_post', 'WelcomeController@news_post');
Route::get('/about', 'WelcomeController@about');
Route::get('/search', 'WelcomeController@search');
Route::get('/newsletter', 'WelcomeController@newsletter');
Route::get('/directories', 'WelcomeController@directories');
Route::get('/notify', 'WelcomeController@notify');

//register and login
Route::get('/register', 'StudentController@register')->name('register')->middleware('guest');
Route::post('/reg', 'UserController@register')->name('reg')->middleware('guest');
Route::get('/register/course/{course_id}', 'UserController@registration_course')->name('register.course');
Route::post('confirm_register', 'UserController@confirm_register')->name('confirm_register')->middleware('guest');
Route::get('/confirm', 'UserController@get_confirm_page')->name('get_confirm_page')->middleware('guest');
Route::get('/signin', 'StudentController@login')->name('login')->middleware('guest');
Route::post('/signin', 'UserController@login')->name('signin')->middleware('guest');
Route::get('/logout', 'UserController@logout')->name('logout')->middleware('auth');
Route::get('/password_reset', 'UserController@init_password_reset')->middleware('guest');
Route::post('/password_reset', 'UserController@submitted_password_reset')->name('request_reset')->middleware('guest');
Route::post('/password_reset_code', 'UserController@accept_password_reset')->name('reset_code')->middleware('guest');
Route::get('/password/reset/{user_id}', 'PasswordController@getPasswordReset')->name('password.reset')->middleware('role:admin');
Route::post('/password/reset/{user_id}', 'PasswordController@storePasswordReset')->middleware('role:admin');

//user home page
Route::get('/home', 'UserController@home')->name('home')->middleware('auth');

//user management
Route::post('/student/search', 'StudentController@search')->middleware('auth');
Route::get('/student/teachers', 'StudentController@teachers')->name('student.teachers')->middleware('role:student');
Route::resource('student', 'StudentController')->except('show');
Route::resource('teacher', 'TeacherController')->only(['edit', 'update'])->middleware('role:teacher,admin');
Route::resource('teacher', 'TeacherController')->only(['index', 'create', 'store', 'destroy'])->middleware('role:admin');
Route::resource('teacher', 'TeacherController')->only('show')->middleware('auth');
Route::resource('enrollment', 'EnrollmentController')->middleware('auth');
Route::resource('user', 'UserController')->only(['edit', 'update'])->middleware('auth');
Route::get('password/change', 'PasswordController@change')->middleware('auth');
Route::post('password/set', 'PasswordController@set')->middleware('auth');


                                /* COURSE TO CONTENT */
//course routes
Route::get('/resources', 'CourseController@resources')->name('course.resource')->middleware('auth');
Route::get('/course/report', 'CourseController@report')->middleware('auth')->name('course.report');
Route::get('/course/report/{id}', 'CourseController@show_report')->middleware('auth')->name('course.report.show');
Route::get('/course/search', 'CourseController@search')->middleware('role:admin');
Route::resource('course', 'CourseController')->except(['show'])->middleware('role:admin');
Route::resource('course', 'CourseController')->only(['show'])->middleware('auth');

//subject routes
Route::get('subject/create/{id}', 'SubjectController@create')->middleware('role:admin');
Route::resource('subject', 'SubjectController')->except(['create', 'index', 'show'])->middleware('role:admin');
Route::resource('subject', 'SubjectController')->only(['show'])->middleware('auth');    

//chapter routes
Route::get('chapter/create/{id}', 'ChapterController@create')->middleware('role:teacher,admin');
Route::resource('chapter', 'ChapterController')->except(['create', 'index', 'show'])->middleware('role:teacher,admin');
Route::resource('chapter', 'ChapterController')->only(['show'])->middleware('auth');

//topic routes
Route::get('topic/create/{id}', 'TopicController@create')->middleware('role:teacher');
Route::resource('topic', 'TopicController')->except(['create', 'index', 'show'])->middleware('role:teacher,admin');
Route::resource('topic', 'TopicController')->only(['show'])->middleware('auth');

//content routes
Route::get('content/create/{id}', 'ContentController@create')->middleware('role:teacher');
Route::resource('content', 'ContentController')->except(['index', 'show'])->middleware('role:teacher,admin');
Route::resource('content', 'ContentController')->only(['show'])->middleware('role:teacher,student,admin');

//examination board
Route::resource('exam_board', 'Exam_BoardController')->except(['index'])->middleware('role:admin');
Route::resource('exam_board', 'Exam_BoardController')->only(['index'])->middleware('auth');
Route::resource('course_board', 'Course_BoardController')->middleware('role:admin');

//teacher subjects
Route::get('teacher_subjects/create/{id}','TeacherSubjectsController@create')->name('assign_teacher')->middleware('role:admin');
Route::resource('teacher_subjects', 'TeacherSubjectsController')->only(['store'])->middleware('role:admin');
Route::resource('teacher_subjects', 'TeacherSubjectsController')->only(['index'])->middleware('role:teacher,admin');

Route::get('pay/{total}', 'PaymentController@createPayment')->name('createPayment');

//admin routes
Route::get('view_paid_students','StudentController@view_paid_students')->name('view_paid_students')->middleware('role:admin');
Route::get('/view_student/course', 'StudentController@get_course')->name('student.view.course')->middleware('role:admin');
Route::get('/view_student/course/{course_id}', 'StudentController@by_course')->name('student.view.by_course')->middleware('role:admin');

/** DISCUSSIONS **/
Route::resource('discussion', 'DiscussionController')->except(['create']);
Route::get('view_discussion/{id}','DiscussionController@view_discussion')->name('view_discussion')->middleware('role:student,teacher,admin');
Route::post('comment/{id}','DiscussionController@comment')->name('comment')->middleware('role:student,teacher,admin');

//teacher
Route::get('/discussion/create/{id}','DiscussionController@create')->name('add_discussion')->middleware('role:student,teacher,admin');

//student
Route::get('discussions','DiscussionController@discussions')->name('discussions')->middleware('role:student');

//payments
Route::get('payment_instructions', 'PaymentController@instructions')->name('payment_steps');
Route::get('payment/{id}', 'PaymentController@create');
Route::post('initiate_payment', 'PaymentController@initiate_payment');
Route::get('payment_successful/{ref}', 'PaymentController@payment_successful')->name('payment.success');
Route::get('payment_update/{ref}', 'PaymentController@payment_update');
Route::get('manual_payment', 'PaymentController@create_manual_payment')->middleware('role:admin');
Route::post('accept_manual_payment', 'PaymentController@accept_manual_payment')->middleware('role:admin');
Route::post('registration_fee/{course_id}', 'PaymentController@registrationFee');
Route::get('reg_payment_successful/{ref}', 'PaymentController@registrationPaymentSuccessful')->name('payment.registration.success');

//tests
Route::resource('chapter_question', 'ChapterQuestionController')->except(['index', 'create','edit', 'show', 'destroy'])->middleware('role:teacher,admin');
Route::get('chapter_question/create/{id}', 'ChapterQuestionController@create')->middleware('role:teacher,admin');
Route::get('chapter_question/{id}', 'ChapterQuestionController@index')->middleware('role:teacher,admin');
Route::post('chapter_question/edit', 'ChapterQuestionController@edit')->middleware('role:teacher,admin');

Route::resource('chapter_answer', 'ChapterAnswerController')->except(['create']);
Route::get('chapter_answer/create/{id}', 'ChapterAnswerController@create')->middleware('auth');

Route::get('chapter_result/{id}', 'ChapterAnswerController@results')->middleware('auth');

 
//student assignment routes
Route::get('assignment/student_courses','AssignmentAnswerController@get_courses')->name('studentassignments')->middleware('auth');
Route::get('assignment/view_subjects/{id}','AssignmentAnswerController@showsubjects')->name('view_studentsubject')->middleware('auth');

Route::get('assignment/viewassign/{id}','AssignmentAnswerController@show')->name('view_studentassignment')->middleware('auth');

Route::get('assignment/submitassignment/{id}','AssignmentAnswerController@submit')->name('submit_assignments')->middleware('auth');
Route::post('assignment/submitassignment','AssignmentAnswerController@store')->name('save_assignmentmark')->middleware('auth');
Route::get('assignment/editsubmittedassignment/{id}','AssignmentAnswerController@editsubmit')->name('editsubmit_assignments')->middleware('auth');
Route::post('assignment/editsubmittedassignment/{id}','AssignmentAnswerController@updateassignmentmark')->name('saveeditsubmit_assignment')->middleware('auth');
Route::get('assignment_answer/download/{id}', 'AssignmentAnswerController@download')->middleware('auth');

//teacher assignment routes
Route::get('assignment/subjects', 'AssignmentController@show_subjects')->middleware('role:teacher,admin');
Route::get('assignment/create/{id}','AssignmentController@create')->name('add_assignment')->middleware('role:teacher,admin');
Route::post('assignment/create','AssignmentController@store')->name('save_assignment')->middleware('role:teacher,admin');
Route::get('assignment/{id}','AssignmentController@index')->name('view_assignments')->middleware('auth');
Route::get('assignment/download/{id}', 'AssignmentController@show')->middleware('auth');
Route::get('assignment/edit/{id}','AssignmentController@edit')->name('edit_assignments')->middleware('auth');
Route::post('assignment/edit/{id}','AssignmentController@update')->name('update_assignment')->middleware('auth');

//teacher mark assignment routes
Route::get('assignment/getassignanswer/{id}','AssignmentAnswerController@getassign')->name('get_assignments_answer')->middleware('auth');
Route::get('assignment/marks/{id}','AssignmentAnswerController@marks')->name('add_assignments_mark')->middleware('auth');
Route::post('assignment/marks/{id}','AssignmentAnswerController@update')->name('edit_assignmentmark')->middleware('auth');

//notifications
Route::get('/notification/all_read', 'NotificationController@all_read')->middleware('auth');
Route::resource('notification', 'NotificationController')->only(['index', 'show'])->middleware('auth');

//announcements
Route::get('/announcement/create', 'NotificationController@create_announcement')->middleware('role:admin');
Route::post('/announcement/send', 'NotificationController@send_announcement')->middleware('role:admin');

//commission
Route::get('/commission/instructions', 'CommissionController@instructions')->name('commission.instructions')->middleware('auth');
Route::resource('commission', 'CommissionController')->only(['index', 'show', 'edit', 'update'])->middleware('auth');

//notes
Route::get('/note/isDone/{id}', 'NoteController@mark_done')->middleware('auth');
Route::resource('note', 'NoteController')->except('show')->middleware('auth');

//user
Route::get('/user/search', 'UserController@search_user')->middleware('role:admin');

//feedback
Route::resource('/feedback', 'FeedbacksController')->only('index')->middleware('role:admin');
Route::resource('/feedback', 'FeedbacksController')->only('create', 'store')->middleware('auth');

//directory
Route::resource('/directory', 'DirectoriesController')->only('create', 'store');
Route::resource('/directory', 'DirectoriesController')->only('index', 'destroy')->middleware('role:admin');
Route::get('/directory/{id}/verify', 'DirectoriesController@verify')->name('directory.verify')->middleware('auth');

//teacher activities
Route::resource('/teacher_activity', 'TeacherActivitiesController')->only('index')->middleware('role:admin');
Route::resource('/teacher_activity', 'TeacherActivitiesController')->only('show')->middleware('role:admin');

//maintenance
Route::get('/maintenance', 'MaintenancesController@run')->middleware('role:admin');

//Teacher ratings
Route::get('/teacher_rating/{teacher_id}', 'TeacherRatingsController@index')->name('teacher.rating.index')->middleware('role:admin');
Route::get('/teacher_rating/create/{teacher_id}', 'TeacherRatingsController@create')->name('teacher.rating.create')->middleware('role:student');
Route::resource('/teacher_rating', 'TeacherRatingsController')->only('store', 'update')->middleware('role:student');

//institutions
Route::resource('/institution', 'InstitutionController')->middleware('role:admin');

Route::get('/chat_room/create/{id}', 'ChatRoomController@create')->name('chat_room.create')->middleware('auth');
Route::resource('/chat_room', 'ChatRoomController')->except('create')->middleware('auth');

Route::resource('/message_log', 'MessageLogController')->only('index')->middleware('role:admin');


// new routes

Route::get('course/{id}/subject/add', 'CourseSubjectController@addExistingSubject')->name('course.subject.add');
Route::post('course/{id}/subject/add', 'CourseSubjectController@storeExistingSubject');
Route::resource('course.subject', 'CourseSubjectController');
Route::resource('course.subject.chapter', 'CourseSubjectChapterController');
Route::resource('course.subject.chapter.topic', 'CourseSubjectChapterTopicController');
Route::resource('course.subject.chapter.topic.content', 'CourseSubjectChapterTopicContentController');

Route::resource('course.subject.assignment', 'CourseSubjectAssignmentController');
Route::resource('subject.assignment', 'SubjectAssignmentController');

Route::get('/student/print', 'StudentController@print')->middleware('role:admin');