@extends('layout.master')
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->

<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Edit Uploaded Assignments</h3> 
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
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
                <div class="card">
                    <div class="card-body">
                        <div class="card-content">
                            <div class="mt-4">
                                <form role="form" method="post" action="{{ route('update_assignment',['id'=>$assignments->id]) }}" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="">Subject</label>
                                        <input type="hidden"  name="user_id" class="form-control" value="{{ Auth::user()->id }}"  required>
                                        <input type="hidden" required name="subject_id" class="form-control" value="{{ $assignments->subject_id }}" required>                                              
                                        <input type="text" required name="subject" class="form-control" value="{{ $assignments->subject->name }}" disabled>               
                                    </div>
                                    <div class="form-group">
                                    <label for="">Assignment Name</label>
                                        <input type="text" required name="name" class="form-control" value="{{ $assignments->name }}" placeholder="Name" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="">Due Date</label>
                                        <input type="date"  name="due_date" class="form-control" value="{{ $assignments->due_date }}"  required>
                                    </div>
                                        <div class="form-group">
                                    <label for="">YOUR FILE</label>
                                    <p> <a href="/assignment/download/{{$assignments->id}}" class="btn btn-info">Download/View </a></p>
                                    </div>
                                    <div class="form-group">
                                    <label for=""><font color="red">Please select if you want to update your file</font></label> </br>                                            
                                        <input type="radio"   name="edit" value="{{ $assignments->file_path }}"  checked="checked" >  DO NOT CHANGE</label><br/>
                                        <input type="radio"  name="edit" value="1" >  CHANGE FILE</label>
                                    </div>
                                    <div class="form-group" id="upload">
                                    <label for="">New File</label>
                                        <input type="file"  name="file_upload" class="form-control" value="Change file"  >
                                    </div>
                                    <div class="form-group m-b-0">
                                        <div class="text-right">
                                            <button class="btn btn-primary waves-effect waves-light"> <span>Update</span> <i class="fa fa-send m-l-10"></i> </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extraJS')
<script type="text/javascript">
    var lastSelected;
    $(function () {
        //if you have any radio selected by default
        lastSelected = $('[name="edit"]:checked').val();
         $('#upload').hide();
    });
    $(document).on('click', '[name="edit"]', function () {
        if ( $(this).val() =='1') {
            $('#upload').show(); 
        }
        else
        {
             $('#upload').hide(); 
        }
        lastSelected = $(this).val();
    });
</script>
  
@endsection()