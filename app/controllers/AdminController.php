<?php

class AdminController extends BaseController {
	public function getCaft($cutoffId)
	{
		$users = User::where('payment', '=', 0)->whereHas('cutoffdates', function($q) use ($cutoffId) {
			$q->where('cutoffdates.id', '=', $cutoffId);
		})->orderby('activated_at', 'desc')->get();
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
		}, $this->classIds);
		return View::make('admin.totals', [
			'totalUsers'=>$userQuery->count(), 
			'monthly'=>['saveon'=>$userMonthlyQuery->sum('saveon'), 'coop'=>$userMonthlyQuery->sum('coop')], 
			'monthlySecond'=>['saveon'=>$userMonthlySecondQuery->sum('saveon'), 'coop'=>$userMonthlySecondQuery->sum('coop')], 
			'biweekly'=>['saveon'=>$biweeklyQuery->sum('saveon'), 'coop'=>$biweeklyQuery->sum('coop')], 
			'classes'=>$classtotals,
			]);
	}

	private function generateProfits($date) {
		$saveon = 0.0;
		$coop = 0.0;

		if( ! empty($date->saveon_cheque_value) && ! empty($date->saveon_card_value))
		{
			$saveon = ($date->saveon_card_value - $date->saveon_cheque_value) / $date->saveon_card_value;
		}

		if( ! empty($date->coop_cheque_value) && ! empty($date->coop_card_value))
		{
			$coop = ($date->coop_card_value - $date->coop_cheque_value) / $date->coop_card_value;
		}

		return ['saveon'=>$saveon * 100, 'coop' => $coop * 100];
	}

	public function getOrders()
	{
		$viewmodel = [];
		$dates = CutoffDate::has('orders')->orderby('cutoff', 'desc')->get();
		$dates->each(function($date) use (&$viewmodel) {
			$profits = $this->generateProfits($date);
			$dt = new \Carbon\Carbon($date->cutoff);
			$viewmodel[] = [
				'id' => $date->id,
				'delivery' => $dt->addDays(7)->format('F jS'),
				'orders' => $date->orders->count(),
				'saveon' => $date->orders->sum('saveon'),
				'coop' => $date->orders->sum('coop'),
				'saveon_profit' => $profits['saveon'],
				'coop_profit' => $profits['coop'],
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

	public function getProfitSettingForm($cutoff) {
		return View::make('admin.profitform', ['cutoff'=>$cutoff]);
	}

	public function postProfitSettingForm($cutoff) {
		
		$in = Input::only(
			'saveon_cheque_value',
			'saveon_card_value',
			'coop_cheque_value',
			'coop_card_value');

		foreach ($in as $k => $v)
		{
			$cutoff[$k] = $v;
		}
		$cutoff->save();

		//back to the main order page
		return Redirect::to('/admin/orders');
	}
}