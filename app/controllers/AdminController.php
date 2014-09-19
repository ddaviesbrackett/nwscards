<?php

class AdminController extends BaseController {
	public function getCaft()
	{
		$users = User::where('payment', '=', 0)->orderby('activated_at', 'desc')->get();
		$viewmodel = [];
		$total = 0;
		$users->each(function($user) use (&$viewmodel, &$total) {
			$gateway = new Laravel\Cashier\StripeGateway($user);
			$stripeCustomer = $gateway->getStripeCustomer();
			$total += $user->saveon + $user->coop;
			$viewmodel[] = [
				'user' => $user,
				'acct' =>$stripeCustomer->metadata['debit-account'],
				'transit' =>$stripeCustomer->metadata['debit-transit'],
				'institution' =>$stripeCustomer->metadata['debit-institution'],
			];
		});
		return View::make('admin.caft', ['model'=>$viewmodel, 'total' => $total]); 
	}

	public function getTotals()
	{
		$userQuery = DB::table('users');
		$userMonthlyQuery = DB::table('users')->where('schedule', '=', 'monthly');
		$userMonthlySecondQuery = DB::table('users')->where('schedule', '=', 'monthly-second');
		$biweeklyQuery = DB::table('users')->where('schedule', '=', 'biweekly');
		$classtotals = [];
		array_map(function($classid) use (&$classtotals, $userQuery) {
			$classtotals[User::className($classid)] = $userQuery->sum($classid);
		}, ['marigold', 'daisy', 'sunflower', 'bluebell', 'class_1', 'class_2', 'class_3', 'class_4', 'class_5', 'class_6', 'class_7', 'class_8']);
		return View::make('admin.totals', [
			'totalUsers'=>$userQuery->count(), 
			'monthly'=>['saveon'=>$userMonthlyQuery->sum('saveon'), 'coop'=>$userMonthlyQuery->sum('coop')], 
			'monthlySecond'=>['saveon'=>$userMonthlySecondQuery->sum('saveon'), 'coop'=>$userMonthlySecondQuery->sum('coop')], 
			'biweekly'=>['saveon'=>$biweeklyQuery->sum('saveon'), 'coop'=>$biweeklyQuery->sum('coop')], 
			'classes'=>$classtotals,
			]);
	}

	public function getOrders()
	{
		$viewmodel = [];
		$dates = CutoffDate::has('orders')->orderby('cutoff', 'desc')->get();
		$dates->each(function($date) use (&$viewmodel) {
			$dt = new \Carbon\Carbon($date->cutoff);
			$viewmodel[] = [
				'id' => $date->id,
				'delivery' => $dt->addDays(8)->format('l, F jS'),
				'orders' => $date->orders->count(),
			];
		});

		return View::make('admin.orders', ['model' => $viewmodel]);
	}

	public function getOrder($id)	
	{
		$orders = Order::where('cutoff_date_id', '=', $id)->with('user')->get();
		$pickup = $orders->filter(function($order){ return ! $order->deliverymethod;});
		$mail = $orders->filter(function($order){ return $order->deliverymethod;	});
		return View::make('admin.order', ['pickup'=>$pickup, 'mail'=>$mail]);
	}
}