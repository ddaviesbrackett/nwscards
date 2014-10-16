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
			$currentSupporters = $bucketname == 'pac' || $bucketname == 'tuitionreduction'?User::count():User::where($bucketname, '=', 1)->count();
		}

		return View::make('tracking.bucket', [
			'name' => $name,
			'orders' => $orders,
			'sum' =>$totalprofit,
			'projection' => $projection,
			'pastSupporters' => $pastSupporters,
			'currentSupporters' => $currentSupporters,
			]);
	}

	public function getLeaderboard()
	{
		$total = Order::sum('profit');

		$buckets = [];
		$bucketnames = $this->classIds;
		$bucketnames[] = 'pac';
		$bucketnames[] = 'tuitionreduction';
		//initialize
		array_map(function($classId) use (&$buckets, &$sqlparams, $bucketnames){
			$buckets[$classId] = ['count'=>0, 'amount'=> 0];
		}, $bucketnames);

		array_map(function($classId) use (&$buckets, $bucketnames){
				$buckets[$classId]['count'] = $classId == 'pac' || $classId == 'tuitionreduction'?User::count():User::where($classId, '=', 1)->count();
				$buckets[$classId]['amount'] = Order::where($classId, '>', 0)->sum($classId);
			}, $bucketnames);

		return View::make('tracking.leaderboard', ['total' => $total, 'buckets' => $buckets]);
	}
}
