@extends('layout')

@section('title')
	Record a Point Sale
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Point Sales</h1>
</div>
<div class="container-fluid">
	<h3>Record a new Point Sale</h3>
	{{Form::model($pointsale,['url'=>'/admin/recordsale', 'method'=>'POST', 'class'=>'form'])}}
		{{Form::input('hidden', 'payment', 0)}}
		<div class="form-group">
			<label for="dt">Date of Sale</label>
			{{ Form::input('text', 'saledate', null, ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD']) }}
			@if($errors->has('saledate'))
				<span class='help-block'>{{{$errors->first('saledate')}}}</span>
			@endif
		</div>
		<div class="form-group">
			<label for="coop_dollars">Coop total value (IN DOLLARS NOT CARDS)</label>
			<div class="input-group">
				<span class="input-group-addon">$</span>
				{{ Form::input('number', 'coop_dollars', null, ['class' => 'form-control']) }}
			</div>
			@if($errors->has('coop_dollars'))
				<span class='help-block'>{{{$errors->first('coop_dollars')}}}</span>
			@endif
		</div>
		<div class="form-group">
			<label for="saveon_dollars">Save-On total value (IN DOLLARS NOT CARDS)</label>
			<div class="input-group">
				<span class="input-group-addon">$</span>
				{{ Form::input('number', 'saveon_dollars', null, ['class' => 'form-control']) }}
			</div>
			@if($errors->has('saveon_dollars'))
				<span class='help-block'>{{{$errors->first('saveon_dollars')}}}</span>
			@endif
		</div>
		<div class="form-group">
			@if($errors->has('saletotal'))
				<span class='help-block'>{{{$errors->first('saletotal')}}}</span>
			@endif
		</div>
		<div class="form-group">
				<button type='submit' class='btn btn-danger btn-lg'>
						Record Point Sale
				</button>
		</div>
	{{Form::close()}}
	<h3> Existing Sales </h3>
	<ul>
	@foreach ($pointsales as $ps)
		<li>{{{$ps->saledate->format('l, F jS')}}}:{{{money_format('$%n',$ps->profit)}}}</li>
	@endforeach
	</ul>
</div>
@stop