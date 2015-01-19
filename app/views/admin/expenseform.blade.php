<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title" id="expenseLabel">Edit Expense</h4>
</div>
<div class="modal-body">
  {{Form::model($expense, ['route'=>['admin-posteditexpense', $expense->id], 'method'=>'POST', 'class'=>'edit-expense'])}}
    <div class="form-group">
      <label for='date' class='text-right'>Date:</label>
      <input type="date" class="form-control" placeholder="" id="date" name="date" value="{{Form::getValueAttribute('date', $expense->expense_date->toDateString())}}"/>
    </div>
    <div class="form-group">
      <label for='description' class='text-right'>Description:</label>
      <input type="text" class="form-control" placeholder="" id="description" name="description" value="{{Form::getValueAttribute('description', $expense->description)}}"/>
    </div>
    <div class="form-group">
      <label for='amount' class='text-right'>Amount:</label>
      <div class="input-group">
        <span class="input-group-addon">$</span>
        <input type="number" min="0" step="0.01" class="form-control" placeholder="" id="amount" name="amount" value="{{Form::getValueAttribute('amount', $expense->amount)}}"/>
      </div>
    </div>
    <div class="form-group">
      <label for='class_id' class='text-right'>Account:</label>
      {{Form::select('class_id', $schoolclasses, Form::getValueAttribute('class_id', $expense->class_id), ['class'=>'form-control'])}}
    </div>
    <div class="form-group text-right">
      <button type='submit' class='btn btn-danger btn-lg'>Update Expense</button>
    </div>
  {{Form::close()}}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>