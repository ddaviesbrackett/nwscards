@extends('layout')
@section('title')
	Profit Leaderboard
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>We've raised ${{{$total}}} so far</h1>
</div>
<div class="container-fluid">
<table class='table'>
	<tr>
		<th></th>
		<th>Amount Raised</th>
		<th>Supporters</th>
	</tr>
	@foreach($buckets as $name => $vals)
		<tr>
			<td><a href="/tracking/{{$name}}">{{{\User::className($name)}}}</a></td>
			<td>{{{money_format('$%n',$vals['amount'])}}}</td>
			<td>{{{$vals['count']}}}</td>
		</tr>
	@endforeach
</table>
</div>
@stop