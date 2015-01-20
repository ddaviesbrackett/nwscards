<?php
use Carbon\Carbon;

class ExpenseController extends BaseController {
	public function getExpenses()
	{
		return $this->result();
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

		return $this->result();
	}

	public function getEditExpense($exp)
	{
		$schoolclasses = [];
		foreach(SchoolClass::all() as $sc) {
			$schoolclasses[$sc->id] = $sc->name;
		}
		return View::make('admin.expenseform', ['expense' => $exp, 'schoolclasses' => $schoolclasses]);
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
			return Redirect::to('/admin/expenses')->withErrors(['error' => 'something went wrong with edit.  All fields are required.'], 'edit');
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
		
		return Redirect::to('/admin/expenses');
	}

	public function getDeleteExpense($exp)
	{
		return View::make('admin.expensedeleteform', ['expense' => $exp]);
	}

	public function postDeleteExpense($exp)
	{
		$exp->delete();

		return Redirect::to('/admin/expenses');
	}

	private function result($extra = [])
	{
		$expenses = Expense::orderby('updated_at', 'desc')->with('schoolclass')->get();
		$schoolclasses = [];
		foreach(SchoolClass::all() as $sc) {
			$schoolclasses[$sc->id] = $sc->name;
		}
		return View::make('admin.expenses', array_merge(['model'=>$expenses, 'schoolclasses'=> $schoolclasses], $extra));
	}
}