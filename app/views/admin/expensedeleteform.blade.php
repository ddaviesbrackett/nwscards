<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title" id="expenseLabel">Delete Expense</h4>
</div>
<div class="modal-body">
  {{Form::model($expense, ['route'=>['admin-postdeleteexpense', $expense->id], 'method'=>'POST', 'class'=>'delete-expense'])}}
    <div class="form-group">
      Are you sure you want to delete this expense?  Once it's gone, it's gone for good.
    </div>
    <div class="form-group text-left">
      <button type='submit' class='btn btn-danger btn-lg'>Delete Expense</button>
    </div>
  {{Form::close()}}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>