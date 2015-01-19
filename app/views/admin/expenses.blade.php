@extends('layout')

@section('title')
	Expenses
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
	<h1>Expenses</h1>
</div>
<div class="container-fluid">
<h3>Record a new expense</h3>
{{Form::open(['route'=>['admin-postexpense'], 'method'=>'POST', 'class'=>'new-expense'])}}
    @if($errors->edit->has('error'))
        <span class='help-block'>{{{$errors->edit->first('error')}}}</span>
    @endif
    <div class="form-group">
		    <label for='date' class='text-right'>Date:</label>
      	<input type="date" class="form-control" placeholder="" id="date" name="date" value="{{Form::getValueAttribute('date', '')}}"/>
    </div>
    <div class="form-group">
      <label for='description' class='text-right'>Description:</label>
      <input type="text" class="form-control" placeholder="" id="description" name="description" value="{{Form::getValueAttribute('description', '')}}"/>
    </div>
    <div class="form-group">
      <label for='amount' class='text-right'>Amount:</label>
      <div class="input-group">
        <span class="input-group-addon">$</span>
        <input type="number" min="0" step="0.01" class="form-control" placeholder="" id="amount" name="amount" value="{{Form::getValueAttribute('amount', 0)}}"/>
      </div>
    </div>
    <div class="form-group">
      <label for='class_id' class='text-right'>Account:</label>
      {{Form::select('class_id', $schoolclasses, Form::getValueAttribute('class_id', 1), ['class'=>'form-control'])}}
    </div>
    <div class="form-group text-right">
      <div class="col-sm-12">
        <button type='submit' class='btn btn-danger btn-lg'>Add Expense</button>
      </div>
    </div>
	{{Form::close()}}
<h3>Expense History</h3>
<table class="table">
	<tr>
		<th>Date</th>
		<th>Description</th>
		<th>Amount</th>
		<th>Account</th>
		<th></th>
	</tr>
	@foreach($model as $exp)
		<tr>
			<td>{{{$exp->expense_date->toDateString()}}}</td>
			<td>{{{$exp->description}}}</td>
			<td>{{{$exp->amount}}}</td>
			<td>{{{$exp->schoolclass->name}}}</td>
			<td><a data-toggle="modal" data-target="#expenseform" href="{{URL::route('admin-geteditexpense', ['expense' => $exp->id])}}">Edit</a></td>
			<td><a data-toggle="modal" data-target="#expenseform" href="{{URL::route('admin-getdeleteexpense', ['expense' => $exp->id])}}">Delete</a></td>
		
		</tr>
	@endforeach
</table>
</div>

<div class="modal fade" id="expenseform" tabindex="-1" role="dialog" aria-labelledby="expenselabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
@stop