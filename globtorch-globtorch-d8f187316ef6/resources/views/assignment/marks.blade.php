@extends('layout.master')
@section('content')
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
    <div class="page-wrapper">
            <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Add Student Assignment Marks</h3> </div>
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
                                            <form role="form" method="post" action="{{ route('edit_assignmentmark',['id'=>$assignments->id]) }}" enctype="multipart/form-data" >
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label for="">Assignment Name</label>  
                                                    <input type="hidden"  name="asssignment_id"   class="form-control" value="{{$assignments->assignment_id }}" required>                                                                                                     
                                                    <input type="text"  name="asssignment"   class="form-control" value="{{$assignments->assignment->name }}" disabled>                                                                                                                                                   
                                                </div>
                                                <div class="form-group">assignment_answers_id
                                                    <label for="">Student ID and Full Name</label>  
                                                   <input type="hidden"name="user_id"   class="form-control" value="{{ $assignments->user_id }}" required>     
                                                   <input type="text"  name="user"   class="form-control" value=" {{ $assignments->user->school_id }}  |  {{ $assignments->user->name }}  {{  $assignments->user->surname }}" disabled>                                        
                                                </div>
                                                <div class="form-group">
                                                <label for="">Assignment Mark (%)</label>
                                                    <input type="number"  name="mark" max="100" min="0"  class="form-control" value="{{ $assignments->mark }}" required>
                                                </div>
                                                @if ($assignments->marked_answer != null)
                                                    <div class="form-group">
                                                        <label for=""><font color="red">Please select if you want to update your file</font></label> </br>                                            
                                                    <input type="radio"   name="edit" value="{{$assignments->marked_answer }}"  checked="checked" >  DO NOT CHANGE</label><br/>
                                                        <input type="radio"  name="edit" value="1" >  CHANGE FILE</label>
                                                    </div>
                                                @endif
                                                <div class="form-group" id="upload">
                                                <label for="">Marked Answer File</label>
                                                    <input type="file"  name="file_upload" class="form-control" value="Change file"  >
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <div class="text-right">
                                                        <button class="btn btn-primary waves-effect waves-light"> <span>Save</span> <i class="fa fa-send m-l-10"></i> </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end card-->
                                        
							    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>     
                <!-- End PAge Content -->              
@endsection()
@section('extraJS')
@if ($assignments->marked_answer != null)
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
@endif
  
@endsection()