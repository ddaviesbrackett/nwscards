@extends('layout')
@section('title')
	Order list
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
	<h1>Order list</h1>
</div>
<div class="container-fluid">
<table class='table'>
	<tr>
		<th></th>
		<th>Delivery Date</th>
		<th># Orders</th>
		<th>Save-On Cards</th>
		<th>Co-op Cards</th>
		<th>Save-On Profit</th>
		<th>Co-op Profit</th>
	</tr>
	@foreach($model as $order)
		<tr>
			<td>
				<a href="{{URL::route('admin-order', ['id' => $order['id']])}}">Order Sheet</a> &middot;
				<a href="{{URL::route('admin-caft', ['id' => $order['id']])}}">CAFT</a>
			</td>
			<td>{{{$order['delivery']}}}</td>
			<td>{{{$order['orders']}}}</td>
			<td>{{{$order['saveon']}}}</td>
			<td>{{{$order['coop']}}}</td>
			<td><a data-toggle="modal" data-target="#profitform" href="{{URL::route('admin-getprofit', ['dateforprofit' => $order['id']])}}">{{{$order['saveon_profit']}}}%</a></td>
			<td><a data-toggle="modal" data-target="#profitform" href="{{URL::route('admin-getprofit', ['dateforprofit' => $order['id']])}}">{{{$order['coop_profit']}}}%</a></td>
		</tr>
	@endforeach
</table>
</div>

<div class="modal fade" id="profitform" tabindex="-1" role="dialog" aria-labelledby="profitLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
@stop