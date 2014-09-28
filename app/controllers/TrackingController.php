<?php

class TrackingController extends BaseController {

	public function getBucket($bucketname)
	{
		
	}

	public function getLeaderboard()
	{
		$orders = Order::all();
		$total = $orders->sum('profit');

		$buckets = [];
		$bucketnames = $this->classIds;
		$bucketnames[] = 'pac';
		$bucketnames[] = 'tuitionreduction';
		//initialize
		array_map(function($classId) use (&$buckets, $bucketnames){
			$buckets[$classId] = ['count'=>0, 'amount'=> 0];
		}, $bucketnames);

		//sum over orders
		$orders->each(function($order) use (&$buckets, $bucketnames) {
			array_map(function($classId) use (&$buckets, $bucketnames, $order){
				$buckets[$classId]['count'] += $order[$classId] > 0 ? 1 : 0;
				$buckets[$classId]['amount'] += $order[$classId];
			}, $bucketnames);
		});
		return View::make('tracking.leaderboard', ['total' => $total, 'buckets' => $buckets]);
	}
}
