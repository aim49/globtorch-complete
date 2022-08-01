@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Your Courses</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">CHECK OUT</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @if ($errors->any())
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger" style="color:red">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class="card">
                        <div class="card-body">
                            <div style="color:green">
                                {{ session()->get('message') }}
                            </div><br/>
                        </div>
                    </div> 
                @endif
            </div>
        </div>
        <!-- Start Page Content -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
            
                <?php

// receive update from Paynow
//get posted parameters via url
$ref= $_GET['ref'];
// Database opening
global $db;
$db = new PDO('mysql:host=localhost;dbname=glob-torch;charset=utf8', 'root', '');
$sql = $db->prepare("SELECT * FROM paynow_transactions WHERE ref=? LIMIT 1");
$sql->execute([$ref]); 
$row = $sql->fetch();

 @include 'app/Paynow-PHP-SDK/autoloader.php';
    $paynow = new \Paynow\Payments\Paynow(
    6378,
    "02a11c42-1276-4a37-8b3c-fb415335e368",
    'http://example.com/gateways/paynow/update',
    'http://example.com/gateways/paynow/update');

//check with paynow to get status of the payment
$status = $paynow->pollTransaction($row['url']);
$date= date("Y/m/d");
$start_date = date("Y/m/d");
$today = strtotime(date("Y/m/d"));
$end_date= date("Y-m-d", strtotime("+1 month", $today));
$method="Paynow";
$price = $status->amount();
$enrollment_id =$row['enrollment_id'];
$user_id= $row['user_id'];
$course_id= $row['course_id'];
// You process $status to see if payment was successfull
//print_r($status);

if($status->status() =='paid' || $status->status() =='awaiting delivery') {
    $payment = make_payment($course_id,$date,$start_date,$end_date,$method,$price,$enrollment_id,$user_id,$ref,$db);
        if($payment['status']=="ok")
        {
             echo '<br>';
            echo "<center><h1>Payment was successfully done.<h1></center>"; 
        }
        elseif(($payment['status']=="fail"))
	    {
        echo '<br>';
        echo "<center><h1>Payment failed to be recorded.Contact Admin :0775 017 342<h1></center>";
        echo "<center><h1> Ref: $ref<h1></center>";

    }

} else {
    echo '<br>';
    print("Why you no pay?");
}
 //Function to make Payment
function make_payment($course_id,$date,$start_date,$end_date,$method,$price,$enrollment_id,$user_id,$ref,$db){
    if($enrollment_id == 0){
        // add new enrollment
        $sql = $db->prepare('insert into enrollments(`user_id`, `course_id`,`status`) values(?,?,?)');
        $sql->execute(array($user_id,$course_id,"Active"));
        $ed = $sql->rowCount();
        $enroll = $db->lastInsertId();
    }
    else{
        $enroll = $enrollment_id;
    }
    //add payment to database
    $result = array();
    try {
        $sql2 = $db->prepare('insert into payments(`date`, `start_date`, `end_date`, `method`, `amount`, `enrollment_id`, `ref`) values(?,?,?,?,?,?,?)');
        $sql2->execute(array($date,$start_date,$end_date,$method,$price,$enroll,$ref));
        $count = $sql2->rowCount();
        if ($count > 0) {
            $result["status"] = "ok";
        } else {
            $result["status"] = "fail";
        }
    } catch (Exception $ex) {
        $result["status"] = $ex->getMessage();
    }
    return $result;  
};
?>
                 </div>
        </div>
        
    </div>
</div>
@endsection

@section('extraJS')
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

    <!-- Form validation -->
    <script src="js/lib/form-validation/jquery.validate.min.js"></script>
    <script src="js/lib/form-validation/jquery.validate-init.js"></script>
    <!--Custom JavaScript -->
    <script src="js/scripts.js"></script>
@endsection