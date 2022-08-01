@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{$course->name}} - Progress report</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($course->subjects as $subject)
                                @if ($loop->index % 4 == 0)
                                    </div>
                                    <br />
                                    <div class="row">
                                @endif
                                <div class="col-lg-3">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <tr>
                                                <th class="text-left" colspan="2">{{$subject->name}}</th>
                                            </tr>
                                            <tr>
                                                <th>Chapter</th>
                                                <th>Percentage (%)</th>
                                            </tr>
                                            @foreach ($subject->chapters as $chapter)
                                                <tr>
                                                    <td>{{$chapter->name}}</td>
                                                    @if (($result = $chapter->results->where('user_id', Auth::id())->first()) == null)
                                                        <td>-</td>
                                                    @else
                                                        @if ($result->percentage < 50)
                                                            <td class="text-danger">{{$result->percentage}}</td>
                                                        @else
                                                            <td class="text-success">{{$result->percentage}}</td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection