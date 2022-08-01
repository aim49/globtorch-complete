@extends('layout.master')
@section('content')

<!-- Page wrapper  -->
<div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">{{$chapter->name}}</h3> 
            </div>
        </div>
<!-- End Bread crumb -->
            <!-- Start Page Content -->
                          <!-- multistep form -->
                        {!! Form::open(['action' => 'ChapterAnswerController@store', 'method'=>'POST','id'=>'msform']) !!}
                          <!-- progressbar -->
                          <ul id="progressbar">
                          <li class="active"></li>
                                @for ($i = 1; $i < count($questions); $i++)
                                  <li ></li>
                                @endfor
                          </ul>
                          <!-- fieldsets -->
                          {{Form::hidden('number_of_records', count($questions))}}
                          @foreach ($questions as $key=>$question)
                            <fieldset class="form-validation" style="position:static">
                            {{ Form::hidden($key,$question->id) }}
                                <h2 class="fs-title"> {{Form::label('question', ++$key . '. ' . $question->question)}}</h2>
                                <h3 class="fs-subtitle">Select from the options below</h3>
                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                               <tbody>
                                <tr >
                                    <td width="10%">{{Form::radio($question->id . 'answer', $question->answer_a )}}</td>
                                    <td width="10%">{{Form::label('a', 'A.')}}</td>
                                    <td align="left">{{Form::label($question->answer_a, '' )}}</td>
                                  </tr>
                                 <tr>
                                     <td width="10%">{{Form::radio($question->id . 'answer', $question->answer_b)}}</td>
                                     <td width="10%">{{Form::label('b', 'B.')}}</td>
                                    <td>{{Form::label($question->answer_b, '')}}</td>
                                 </tr>
                                  <tr>
                                     <td width="10%">{{Form::radio($question->id . 'answer', $question->answer_c)}}</td>
                                     <td width="10%">{{Form::label('c', 'C.')}}</td>
                                    <td>{{Form::label($question->answer_c, '')}}</td>
                                  </tr>
                                  <tr >
                                     <td width="10%">{{Form::radio($question->id . 'answer', $question->answer_d)}}</td>
                                     <td width="10%">{{Form::label('d', 'D.')}}</td>
                                    <td align:left >{{Form::label($question->answer_d, '')}}</td>
                                  </tr>
                                  </tbody>
                                    </table>
                                @if($key>1)
                                  <input type="button" name="previous" class="previous action-button" value="Previous" />
                                @endif  
                                @if ( $key != count($questions))
                                  <input type="button" name="next" class="next action-button" value="Next" />
                                @else
                                {{Form::submit('Submit', ['class' => 'btn btn-primary  action-button'])}}
                                @endif
                              </fieldset>
                          @endforeach
                        </form>
</div>  

<!-- /# questions style  -->
<style>
/*form styles*/
#msform {
  width: 80%;
  text-align: left;
  position: relative;
}
#msform fieldset {
  background: white;
  border: 0 none;
  border-radius: 3px;
  box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
  padding: 20px 30px;
  box-sizing: border-box;
  width: 100%;
  margin: 0 10%;
  /*stacking fieldsets above each other*/
  position: absolute;
}
/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
  display: none;
}
/*inputs*/
#msform input,
#msform textarea {
  padding: 15px;
  border: 1px solid #ccc;
  border-radius: 3px;
  margin-bottom: 10px;
  width: 100%;
  box-sizing: border-box;
  font-family: montserrat;
  color: #2C3E50;
  font-size: 13px;
}
/*buttons*/
#msform .action-button {
  width: 100px;
  background: blue;
  font-weight: bold;
  color: white;
  border: 0 none;
  border-radius: 1px;
  cursor: pointer;
  padding: 10px 5px;
  margin: 10px 5px;
}
#msform .action-button:hover,
#msform .action-button:focus {
  box-shadow: 0 0 0 2px white, 0 0 0 3px blue;
}
/*headings*/
.fs-title {
  font-size: 20px;
  color: #63a2cb;
  margin-bottom: 10px;
}
.fs-subtitle {
  font-weight: normal;
  font-size: 14px;
  color: red;
  margin-bottom: 20px;
}
/*progressbar*/
#progressbar {
  margin-bottom: 30px;
  overflow: hidden;
  /*CSS counters to number the steps*/
  counter-reset: step;
}
#progressbar li {
  list-style-type: none;
  color: white;
  text-transform: uppercase;
  font-size: 14px;
  width: 10%;
  float: left;
  position: relative;
}
#progressbar li:before {
  content: counter(step);
  counter-increment: step;
  width: 30px;
  line-height: 30px;
  display: block;
  font-size: 20px;
  text-align: center;
  color: white;
  background: green;
  border-radius: 3px;
  margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
  content: '';
  width: 100%;
  height: 2px;
  background: white;
  position: absolute;
  left: -50%;
  top: 9px;
  z-index: -1;
  /*put it behind the numbers*/
}
#progressbar li:first-child:after {
  /*connector not needed before the first step*/
  content: none;
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,
#progressbar li.active:after {
  background: blue;
  color: white;
}
.help-block {
  font-size: 0.8em;
  color: #7c7c7c;
  text-align: left;
  margin-bottom: 0.5em;
}

</style>
  
@endsection()

@section('extraJS')
  
  <script type="text/javascript">
  //jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 500, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 500, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});

$(".submit").click(function(){
	return false;
})
</script>
@endsection()
