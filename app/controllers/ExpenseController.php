<?php
use Carbon\Carbon;

class ExpenseController extends BaseController {
	public function getExpenses()
	{
		$expenses = Expense::orderby('updated_at', 'desc')->with('schoolclass')->get();
		return View::make('admin.expenses', ['model'=>$expenses]);
	}

	public function postExpense()
	{
		$validator = Validator::make(Input::only('class_id', 'amount', 'description', 'date'),
			[
				'class_id' => 'required',
				'amount' => 'required',
				'description' => 'required',
				'date' => 'required|date',
			]);
		if($validator->fails()) {
			return Redirect::to('/admin/expenses')->withErrors($validator)->withInput(Input::all());
		}
		$class = Input::get('class_id');
		$amt = Input::get('amount');
		$desc = Input::get('description');
		$date = Carbon::parse(Input::get('date'));

		$schoolclass = SchoolClass::find($class);
		if(is_null($schoolclass)) {
			$validator->errors()->add('class_id', 'Class not found');
			return Redirect::to('/admin/expenses')->withErrors($validator)->withInput(Input::all());
		}
		$expense = new Expense(['description' => $desc, 'amount' => $amt]);
		$expense->expense_date = $date;
		$expense = $schoolclass->expenses()->save($expense);

		$expenses = Expense::orderby('updated_at', 'desc')->with('schoolclass')->get();
		return View::make('admin.expenses', ['model'=>$expenses]);
	}

	public function getEditExpense($exp)
	{
		return View::make('admin.expenseform', ['expense' => $exp]);
	}

	public function postEditExpense($exp)
	{
		$validator = Validator::make(Input::only('class_id', 'amount', 'description', 'date'),
			[
				'class_id' => 'required',
				'amount' => 'required',
				'description' => 'required',
				'date' => 'required|date',
			]);
		if($validator->fails()) {
			return Redirect::to('/admin/expenses')->withErrors($validator)->withInput(Input::all());
		}
		$class = Input::get('class_id');
		$amt = Input::get('amount');
		$desc = Input::get('description');
		$date = Input::get('date');

		$schoolclass = SchoolClass::find($class);
		if(is_null($schoolclass)) {
			$validator->errors()->add('class_id', 'Class not found');
			return Redirect::to('/admin/expenses')->withErrors($validator)->withInput(Input::all());
		}

		$exp->description = $desc;
		$exp->amount = $amt;
		$exp->schoolclass()->associate($schoolclass);
		$exp->expense_date = Carbon::parse($date);
		$exp->save();

		$expenses = Expense::orderby('updated_at', 'desc')->with('schoolclass')->get();
		return View::make('admin.expenses', ['model'=>$expenses]);
	}

	public function getDeleteExpense($exp)
	{
		return View::make('admin.expenseform', ['expense' => $exp]); //TODO WRONG
	}

	public function postDeleteExpense($exp)
	{
		$exp->delete();

		$expenses = Expense::orderby('updated_at', 'desc')->with('schoolclass')->get();
		return View::make('admin.expenses', ['model'=>$expenses]);
	}
}