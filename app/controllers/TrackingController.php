<?php

class TrackingController extends BaseController {

	public function getBucket($bucketname)
	{
		$sc = SchoolClass::where('bucketname', '=', $bucketname)->first();
		if(is_null($sc))
		{
			return Redirect::to('/tracking');
		}

		$profitMap = [];
		$orders = $sc->orders;
		$currentSupporters = $sc->users->count();
		$expenses = $sc->expenses()->orderBy('expense_date', 'desc')->get();
		$pointsales = $sc->pointsales()->orderBy('saledate', 'desc')->get();

		foreach($orders as $order)
		{
			$profitMap[$order->cutoffdate->id] = 0;
		}

		foreach($orders as $order)
		{
			$profitMap[$order->cutoffdate->id] += $order->pivot->profit;
		}

		$totalprofit = $orders->getTotalProfit() + $sc->pointsales->getTotalProfit();

		return View::make('tracking.bucket', [
			'name' => $sc->name,
			'profitMap' => $profitMap,
			'expenses' => $expenses,
			'pointsales' => $pointsales,
			'sum' =>$totalprofit,
			'currentSupporters' => $currentSupporters,
			]);
	}

	public function getLeaderboard()
	{
		$total = 0;
                $classes_arr=[];
                $buckets = [];
                
		foreach(SchoolClass::all() as $class)
		{
                        $class_profit=DB::select('SELECT SUM(profit) as classTotal FROM classes_orders WHERE class_id='.$class->id.'');
                        $total+=$class_profit[0]->classTotal + $class->pointsales->getTotalProfit(); 
                        $classes_arr[$class->id]= $class_profit[0]->classTotal + $class->pointsales->getTotalProfit(); 
                                                
			//$total += $class->orders->getTotalProfit() + $class->pointsales->getTotalProfit(); 
                        //$classes_arr[$class->id]= $class->orders->getTotalProfit() + $class->pointsales->getTotalProfit(); 
		}
               
		
		foreach(SchoolClass::where('displayorder', '>=', '-1')->orderby('displayorder', 'asc')->get() as $class)
		{
                    $class_expenses=DB::select('SELECT SUM(amount) as classTotalExpenses FROM expenses WHERE class_id='.$class->id.'');

                    $buckets[$class->bucketname]['nm']=$class->name;
                    $buckets[$class->bucketname]['expenses'] = $class_expenses[0]->classTotalExpenses;
                    $class_user_count=DB::select('SELECT count(*) as class_users from classes_users WHERE 1 AND class_id='.$class->id.' GROUP BY class_id');
                    //***$buckets[$class->bucketname]['count']=10;//$class_user_count[0]->class_users;                       
                    $buckets[$class->bucketname]['count']=$class->users->count();   
                    //***$class->orders->getTotalProfit()+$class->pointsales->getTotalProfit() 
                    $buckets[$class->bucketname]['amount']=$classes_arr[$class->id];
                    $buckets[$class->bucketname]['fundsAvailable']=$classes_arr[$class->id]-$class_expenses[0]->classTotalExpenses; 
		}
                
                return View::make('tracking.leaderboard', ['total' => $total, 'buckets' => $buckets]);
	}}
