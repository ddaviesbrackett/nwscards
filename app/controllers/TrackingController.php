<?php

class TrackingController extends BaseController {

	public function getBucket($bucketname)
	{
		$name = User::className($bucketname);
		$orders = null;
		$totalprofit = 0;
		$projection = 0;
		$pastSupporters = 0;
		$projectionSupporters = 0;
		$currentSupporters = 0;
		$expenses = null;
		$pointsales = null;

		
		if(! empty($name) ) {

			$sc = SchoolClass::where('bucketname', '=', $bucketname)->firstOrFail();
			$orders = $sc->orders;
			$currentSupporters = $sc->users->count();
			$expenses = $sc->expenses()->orderBy('expense_date', 'desc')->get();
			$pointsales = $sc->pointsales()->orderBy('saledate', 'desc')->get();

			$totalprofit = $orders->getTotalProfit() + $sc->pointsales->getTotalProfit();
		}

		return View::make('tracking.bucket', [
			'name' => $name,
			'orders' => $orders,
			'expenses' => $expenses,
			'pointsales' => $pointsales,
			'sum' =>$totalprofit,
			'projection' => '(unavailable)',
			'pastSupporters' => '(unavailable)',
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
			$total += $buckets[$class->bucketname]['amount']; 
		}

		return View::make('tracking.leaderboard', ['total' => $total, 'buckets' => $buckets]);
	}
}
