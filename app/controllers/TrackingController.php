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
		foreach(SchoolClass::all() as $class)
		{
			$total += $class->orders->getTotalProfit() + $class->pointsales->getTotalProfit(); 
		}

		$buckets = [];
		foreach(SchoolClass::where('displayorder', '>=', '-1')->orderby('displayorder', 'asc')->get() as $class)
		{
			$buckets[$class->bucketname] = ['nm'=>$class->name,
											'count'=>$class->users->count(),
											'amount'=> $class->orders->getTotalProfit() + $class->pointsales->getTotalProfit()];
		}

		return View::make('tracking.leaderboard', ['total' => $total, 'buckets' => $buckets]);
	}
}
