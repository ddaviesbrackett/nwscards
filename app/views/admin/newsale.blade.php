@extends('layout')

@section('title')
	Record a Point Sale
@stop

@section('head-extra')
<script>
	//reload the popup every time, so it doesn't have stale data in it
	$(document).on('hidden.bs.modal', function (e) {
		$(e.target).removeData('bs.modal').find('.modal-content').html('');
	});
</script>
@stop

@section('content')
<div class="masthead">
	<h1>Point Sales</h1>
</div>
<div class="container-fluid">
	<h3>Record a new Point Sale</h3>
	{{Form::model($pointsale,['url'=>'/admin/pointsale', 'method'=>'POST', 'class'=>'form'])}}
		{{Form::input('hidden', 'payment', 0)}}
		<div class="form-group  {{{$errors->has('saledate')?'has-error':''}}}">
			<label for="dt">Date of Sale</label>
			{{ Form::input('text', 'saledate', null, ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD']) }}
			@if($errors->has('saledate'))
				<span class='help-block'>{{{$errors->first('saledate')}}}</span>
			@endif
		</div>
		<div class="form-group {{{$errors->has('coop_dollars')?'has-error':''}}}">
			<label for="coop_dollars">Coop total value (IN DOLLARS NOT CARDS)</label>
			<div class="input-group">
				<span class="input-group-addon">$</span>
				{{ Form::input('number', 'coop_dollars', null, ['class' => 'form-control']) }}
			</div>
			@if($errors->has('coop_dollars'))
				<span class='help-block'>{{{$errors->first('coop_dollars')}}}</span>
			@endif
		</div>
		<div class="form-group {{{$errors->has('saveon_dollars')?'has-error':''}}}">
			<label for="saveon_dollars">Save-On total value (IN DOLLARS NOT CARDS)</label>
			<div class="input-group">
				<span class="input-group-addon">$</span>
				{{ Form::input('number', 'saveon_dollars', null, ['class' => 'form-control']) }}
			</div>
			@if($errors->has('saveon_dollars'))
				<span class='help-block'>{{{$errors->first('saveon_dollars')}}}</span>
			@endif
		</div>
		@if($errors->has('saletotal'))
			<div class="form-group has-error">
				<span class='help-block'>{{{$errors->first('saletotal')}}}</span>
			</div>
		@endif
		<div class="form-group">
			<button type='submit' class='btn btn-danger btn-lg'>
				Record Point Sale
			</button>
		</div>
	{{Form::close()}}
	<h3> Existing Sales </h3>
	<table class="table">
		<tr>
			<th>Sale Date</th>
			<th>Amount</th>
			<th>Profit</th>
			<th></th>
		</tr>
	@foreach ($pointsales as $ps)
		<tr>
			<td>{{{$ps->saledate->format('l, F jS')}}}</td>
			<td>{{{money_format('$%n',$ps->saveon_dollars + $ps->coop_dollars)}}}</td>
			<td>{{{money_format('$%n',$ps->profit)}}}</td>
			<td><a data-toggle="modal" data-target="#saleform" href="{{URL::route('admin-getdeletesale', ['sale' => $ps->id])}}">Delete</a></td>
		</tr>
	@endforeach
	</table>
</div>

<div class="modal fade" id="saleform" tabindex="-1" role="dialog" aria-labelledby="salelabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
@stop