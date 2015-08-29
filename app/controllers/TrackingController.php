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

		$sc = SchoolClass::where('bucketname', '=', $bucketname)->firstOrFail();
		
		if(! empty($name) ) {
			$orders = Order::with('cutoffdate')->where($bucketname, '>', 0)
				->groupBy('cutoff_date_id')
				->join('cutoffdates', 'cutoffdates.id', '=', 'orders.cutoff_date_id')
				->orderBy('cutoffdates.cutoff','desc')
				->get([DB::raw('SUM('.$bucketname.') as profit'), DB::raw('count('.$bucketname.') as supporters'), 'cutoff_date_id']);
			$totalprofit = Order::sum($bucketname);
			if(count($orders) > 1)
			{
				$monthsleft = \Carbon\Carbon::createFromDate(2015,7,1)->diffInMonths();
				$projection = $totalprofit + (($orders[0]->profit + $orders[1]->profit) * $monthsleft);
				$pastSupporters = $orders[0]->supporters + $orders[1]->supporters;
			}
			$currentSupporters = $sc->users->count();

			$expenses = $sc->expenses()->orderBy('expense_date', 'desc')->get();
			$pointsales = $sc->pointsales()->orderBy('saledate', 'desc')->get();

			foreach($pointsales as $ps)
			{
				$totalprofit += $ps->pivot->profit;
			}
		}

		return View::make('tracking.bucket', [
			'name' => $name,
			'orders' => $orders,
			'expenses' => $expenses,
			'pointsales' => $pointsales,
			'sum' =>$totalprofit,
			'projection' => $projection,
			'pastSupporters' => $pastSupporters,
			'currentSupporters' => $currentSupporters,
			]);
	}

	public function getLeaderboard()
	{
		$total = 0;

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
