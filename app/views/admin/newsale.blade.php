@extends('layout')

@section('title')
	Record an Off-Cycle Sale
@stop

@section('head-extra')
@stop

@section('content')
<div class="masthead">
	<h1>Record an Off-Cycle Sale</h1>
</div>
<div class="container-fluid">
	{{Form::model($order,['url'=>'/admin/newsale', 'method'=>'POST', 'class'=>'form'])}}
		<div class="form-group">
			<label for="dt">Date of Sale</label>
			{{ Form::input('text', 'dt', null, ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD']) }}
		</div>
		<div class="form-group">
			<label for="user">Buyer Email</label>
			{{ Form::input('text', 'user', null, ['class' => 'form-control', 'placeholder' => 'must already be a user']) }}
			TODO: search function here by name, showing email address
		</div>
		<div class="form-group">
			<label for="coop">Coop cards</label>
			<div class="input-group">
				{{ Form::input('number', 'coop', null, ['class' => 'form-control']) }}
				<span class="input-group-addon">x $100</span>
			</div>
		</div>
		<div class="form-group">
			<label for="saveon">Save-On cards</label>
			<div class="input-group">
				{{ Form::input('number', 'saveon', null, ['class' => 'form-control']) }}
				<span class="input-group-addon">x $100</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('marigold') }}
							Marigold Daycare
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('daisy') }}
							Daisy Daycare
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('sunflower') }}
							Sunflower Kindergarten
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('bluebell') }}
							Bluebell Kindergarten
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('class_1') }}
							Class 1
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('class_2') }}
							Class 2
						</label></div>
				</div>
			</div>
			<div class="col-sm-6">
				
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('class_3') }}
							Class 3
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('class_4') }}
							Class 4
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('class_5') }}
							Class 5
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('class_6') }}
							Class 6
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('class_7') }}
							Class 7
						</label></div>
				</div>
				<div class="form-group">
					<div class="checkbox"><label>
							{{ Form::checkbox('class_8') }}
							Class 8
						</label></div>
				</div>
			</div>
		</div>
	{{Form::close()}}
</div>
@stop