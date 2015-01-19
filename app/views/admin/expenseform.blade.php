<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title" id="expenseLabel">Edit Expense</h4>
</div>
<div class="modal-body">
  {{Form::model($expense, ['route'=>['admin-posteditexpense', $expense->id], 'method'=>'POST', 'class'=>'edit-expense'])}}
    <div class="form-group">
      <label for='coop' class='text-right'>Date:</label>
      <input type="date" class="form-control" placeholder="" id="date" name="date" value="{{Form::getValueAttribute('date', $expense->expense_date)}}"/>
    </div>
    <div class="form-group">
      <label for='coop' class='text-right'>Description:</label>
      <input type="text" class="form-control" placeholder="" id="description" name="description" value="{{Form::getValueAttribute('description', $expense->description)}}"/>
    </div>
    <div class="form-group">
      <label for='coop' class='text-right'>Amount:</label>
      <div class="input-group">
        <span class="input-group-addon">$</span>
        <input type="number" min="0" step="0.01" class="form-control" placeholder="" id="amount" name="amount" value="{{Form::getValueAttribute('amount', $expense->amount)}}"/>
      </div>
    </div>
    <div class="form-group">
      <label for='coop' class='text-right'>Account:</label>
      <input type="number" class="form-control" placeholder="" id="class_id" name="class_id" value="{{Form::getValueAttribute('class_id', $expense->class_id)}}"/>
    </div>
    <div class="form-group text-right">
      <button type='submit' class='btn btn-danger btn-lg'>Update Expense</button>
    </div>
  {{Form::close()}}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>