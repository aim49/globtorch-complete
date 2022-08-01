@extends('layout.landing_page.app')
@section('styles')
	<link rel="stylesheet" type="text/css" href="css/landing_page/styles/news_styles.css">
	<link rel="stylesheet" type="text/css" href="css/landing_page/styles/news_responsive.css">
@endsection
@section('content')
<!-- Home -->

<div class="home">
	<div class="home_background_container prlx_parent">
		<div class="home_background prlx" style="background-image:url('{{asset('images/landing_page/courses_background.jpg')}}')"></div>
	</div>
	<div class="home_content" Style="background:  #428bca;">
		<h1>Courses</h1>
	</div>
</div>

<!-- Popular -->

<div class="popular page_section">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title text-center">
					<h1>Popular Courses</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" Style="color:  black;">
					<thead>
						<tr>
							<th class="th-sm">Course Name
							</th>
							<th class="th-sm">Level
							</th>
							<th class="th-sm">Duration
							</th>
							<th class="th-sm">Price
							</th>
							<th class="th-sm">Exam Period
							</th>
							<th class="th-sm">Minimum requirements
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Grade 1</td>
							<td>Primary</td>
							<td>1 year</td>
							<td>$30</td>
							<td>Oct-Nov</td>
							<td>No requerments needed</td>
						</tr>
						<tr>
							<td>Grade 2</td>
							<td>Primary</td>
							<td>1 year</td>
							<td>$30</td>
							<td>Oct-Nov</td>
							<td>No requerments needed</td>
						</tr>
						<tr>
							<td>Grade 3</td>
							<td>Primary</td>
							<td>1 year</td>
							<td>$30</td>
							<td>Oct-Nov</td>
							<td>No requerments needed</td>
						</tr>
						<tr>
							<td>Grade 4</td>
							<td>Primary</td>
							<td>1 year</td>
							<td>$30</td>
							<td>Oct-Nov</td>
							<td>No requerments needed</td>
						</tr>
						<tr>
							<td>Grade 5</td>
							<td>Primary</td>
							<td>1 year</td>
							<td>$30</td>
							<td>Oct-Nov</td>
							<td>No requerments needed</td>
						</tr>
						<tr>
							<td>Grade 6</td>
							<td>Primary</td>
							<td>1 year</td>
							<td>$30</td>
							<td>Oct-Nov</td>
							<td>No requerments needed</td>
						</tr>
						<tr>
							<td>Grade 7</td>
							<td>Primary</td>
							<td>1 year</td>
							<td>$30</td>
							<td>Oct-Nov</td>
							<td>No requerments needed</td>
						</tr>
						<tr>
							<td>Form 1</td>
							<td>Secondary</td>
							<td>1 year</td>
							<td>$50</td>
							<td>Oct-Nov</td>
							<td>Grade 7 result slip</td>
						</tr>
						<tr>
							<td>Form 2</td>
							<td>Secondary</td>
							<td>1 year</td>
							<td>$50</td>
							<td>Oct-Nov</td>
							<td>Grade 7 result slip</td>
						</tr>
						<tr>
							<td>Form 3</td>
							<td>Secondary</td>
							<td>1 year</td>
							<td>$50</td>
							<td>Oct-Nov</td>
							<td>Grade 7 result slip</td>
						</tr>
						<tr>
							<td>Form 4</td>
							<td>Secondary</td>
							<td>1 year</td>
							<td>$50</td>
							<td>Oct-Nov</td>
							<td>Grade 7 result slip</td>
						</tr>
						<tr>
							<td>Form 1</td>
							<td>Secondary</td>
							<td>1 year</td>
							<td>$50</td>
							<td>Oct-Nov</td>
							<td>Grade 7 result slip</td>
						</tr>
						<tr>
							<td>Form 5</td>
							<td>Secondary</td>
							<td>1 year</td>
							<td>$50</td>
							<td>Oct-Nov</td>
							<td>Grade 7 result slip</td>
						</tr>

					</tbody>
					<tfoot>
						<tr>
							<th class="th-sm">Course Name
							</th>
							<th class="th-sm">Level
							</th>
							<th class="th-sm">Duration
							</th>
							<th class="th-sm">Price
							</th>
							<th class="th-sm">Exam Period
							</th>
							<th class="th-sm">Minimum requirements
							</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
 
@section('scripts') 
$('#myTab a').click(function (e) 
{ 
	e.preventDefault() 
	$(this).tab('show') 
}) 
$(document).ready(function() 
{ 
	$('#dtBasicExample').DataTable(); $('.dataTables_length').addClass('bs-select'); 
});
@endsection