<?php

class AdminController extends BaseController {
	public function getImpersonate()
	{
		$users = User::orderBy('name')->get();
		return View::make('admin.impersonation', ['users' => $users]);
	}

	public function doImpersonate($id)
	{
		$user = Sentry::findUserById($id);
		if( is_null($user) ) {
			return $this->getImpersonate();
		}
		Session::put('adminUser', Sentry::getUser());
		Sentry::login($user);
		return Redirect::to('/account');
	}

	public function unImpersonate()
	{
		if(Session::has('adminUser'))
		{
			Sentry::login(Session::pull('adminUser'));
		}
		return Redirect::to('/account');
	}

	public function getCaft($cutoffId)
	{
		$orders = Order::join('users as u', 'u.id', '=', 'orders.user_id')
			->where('orders.cutoff_date_id','=',$cutoffId) //only this cutoff
			->where('orders.payment', '=', 0) //only debit
			->orderby('u.updated_at', 'desc') //sort by date
			->select('orders.*') //only select orders, so that the users columns don't confuse eloquent (sigh)
			->with('user') //eagerload user
			->get();
		

		$viewmodel = [
			'New' => [],
			'Updated' => [],
			'Unchanged' => [],
		];
		$total = 0;
		$bicutoff = null;
		$mcutoff = null;
		if($cutoffId > 2) {
			$bicutoff = CutoffDate::find($cutoffId - 1)->cutoffdate()->tz('UTC');
			$mcutoff = CutoffDate::find($cutoffId - 2)->cutoffdate()->tz('UTC');
		}
		foreach($orders as $order) {
			$user = $order->user;
			$gateway = new Laravel\Cashier\StripeGateway($user);
			$stripeCustomer = $gateway->getStripeCustomer();
			$total += $order->totalCards();
			if($cutoffId > 2) {
				$cutoff = $user->schedule == 'biweekly' ? $bicutoff : $mcutoff;
				$bucket = ($cutoff->lt($user->created_at) ? 'New' : ($cutoff->lt($user->updated_at) ? 'Updated' : 'Unchanged'));
			}
			else {
				$bucket = 'New';
			}

			$viewmodel[$bucket][] = [
				'order' => $order,
				'acct' =>$stripeCustomer->metadata['debit-account'],
				'transit' =>$stripeCustomer->metadata['debit-transit'],
				'institution' =>$stripeCustomer->metadata['debit-institution'],
			];
		}

		return View::make('admin.caft', ['model'=>$viewmodel, 'total' => $total, 'cutoff'=>$cutoffId]); 
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
		$dates = CutoffDate::has('orders')->orderby('cutoff', 'desc')->with('orders')->get();
		$dates->each(function($date) use (&$viewmodel) {
			$profits = $this->generateProfits($date);
			$dt = new \Carbon\Carbon($date->cutoff);
			$viewmodel[] = [
				'id' => $date->id,
				'delivery' => (new \Carbon\Carbon($date->delivery))->format('F jS'),
				'orders' => $date->orders->count(),
				'saveon' => $date->orders->sum('saveon') + $date->orders->sum('saveon_onetime'),
				'coop' => $date->orders->sum('coop') + $date->orders->sum('coop_onetime'),
				'saveon_profit' => $profits['saveon'],
				'coop_profit' => $profits['coop'],
			];
		});

		return View::make('admin.orders', ['model' => $viewmodel]);
	}

	public function getOrder($id)	
	{
		$orders = Order::where('cutoff_date_id', '=', $id)->select('orders.*')->join('users', 'users.id', '=', 'orders.user_id')
			->orderBy('users.name', 'asc')->with('user')->get();
		$pickup = $orders->filter(function($order){ return ! $order->deliverymethod;});
		$mail = $orders->filter(function($order){ return $order->deliverymethod;});
		return View::make('admin.order', ['pickup'=>$pickup, 'mail'=>$mail]);
	}

	public function getNewSaleForm()
	{
		return View::make('admin.newsale', ['pointsale'=>null, 'pointsales'=> Pointsale::orderby('saledate', 'desc')->get()]);
	}

	public function postNewSaleForm()
	{
		$in = Input::only(
			'payment',
			'saveon_dollars',
			'coop_dollars',
			'saledate');
		
		$validator = Validator::make($in, [
				'payment'=>'in:0,1',
				'saledate'=>'required'
			]);
		$basicrulespassed = $validator->passes();
		$so = $in['saveon_dollars'];
		$co = $in['coop_dollars'];
		if(filter_var($so, FILTER_VALIDATE_INT) === false || 
			filter_var($co, FILTER_VALIDATE_INT) === false	||
			$so + $co <= 0)  {
				$validator->errors()->add('saletotal', 'Total sales must be greater than 0');
			}
		try {
			$dt = \Carbon\Carbon::parse($in['saledate']);
			$in['saledate'] = $dt;
		}
		catch (Exception $e) {
			$validator->errors()->add('saledate', 'Sale Date must be some kind of date');
		}
		if(count($validator->errors()) > 0) {
			return Redirect::to('/admin/pointsale')
				->withErrors($validator)
				->withInput(Input::all());
		}
		else {
			$profits = $this->generateProfits(CutoffDate::where('saveon_cheque_value','>', 0)->orderby('cutoff', 'desc')->first());
			$saveonProfit = $so * $profits['saveon'] / 100;
			$coopProfit = $co * $profits['coop'] / 100;
			$sale = new Pointsale($in);
			$sale->profit = $saveonProfit + $coopProfit;
			$sale->save();
			$pac = SchoolClass::where('bucketname', '=', 'pac')->first()->id;
			$tr = SchoolClass::where('bucketname', '=', 'tuitionreduction')->first()->id;
			$sale->schoolclasses()->attach([
				$pac => ['profit' => $saveonProfit * 0.25 + $coopProfit * 0.25], 
				$tr => ['profit' => $saveonProfit * 0.75 + $coopProfit * 0.75]]);
		}

		return Redirect::to('/admin/pointsale');
	}

	public function getDeletePointsale($ps)
	{
		return View::make('admin.pointsaledeleteform', ['ps' => $ps]);
	}

	public function postDeletePointsale($ps)
	{
		$ps->schoolclasses()->detach();
		$ps->delete();

		return Redirect::to('/admin/pointsale');
	}

	public function getProfitSettingForm($cutoff) {
		return View::make('admin.profitform', ['cutoff'=>$cutoff]);
	}

	public function postProfitSettingForm($cutoff) {
		
		//update the cutoff with profits
		$in = Input::only(
			'saveon_cheque_value',
			'saveon_card_value',
			'coop_cheque_value',
			'coop_card_value');

		foreach ($in as $k => $v)
		{
			$cutoff[$k] = $v;
		}

		//update order profits for all the orders in the cutoff
		$profits = $this->generateProfits($cutoff);
		$cutoff->orders->load('user')->each(function($order) use ($profits) {
			$saveon = $order->saveon + $order->saveon_onetime;
			$coop = $order->coop + $order->coop_onetime;
			$profit = ($saveon * $profits['saveon']) + ($coop * $profits['coop']);
			
			//stripe takes its cut
			if($order->isCreditCard()) {
				$profit -= ($saveon + $coop) * 2.9;
				$profit -= 0.30;
			}
			$order->profit = $profit;

			$supp = $order->user->classesSupported();
			$buckets = count($supp);
			if($buckets > 0) {
				$perBucket = $profit / $buckets;
				$splits = AdminController::splits();
				$order->pac = 0;
				$order->tuitionreduction = 0;
				foreach($supp as $class)
				{
					$order->{$class} = $perBucket * $splits[$class]['class'];
					$order->pac += $perBucket * $splits[$class]['pac'];
					$order->tuitionreduction += $perBucket * $splits[$class]['tuitionreduction'];
				}
			}
			else
			{
				$order->pac = $profit * 0.25;
				$order->tuitionreduction = $profit * 0.75;
			}
			$order->save();
		});

		$cutoff->save();

		//back to the main order page
		return Redirect::to('/admin/orders');
	}

	public static function splits()
	{
		return [
			'marigold' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'daisy' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'sunflower' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'bluebell' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_1' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_2' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_3' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_4' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_5' => ['class' => 0.5, 'pac' => 0.1, 'tuitionreduction' => 0.4],
			'class_6' => ['class' => 0.6, 'pac' => 0.05, 'tuitionreduction' => 0.35],
			'class_7' => ['class' => 0.7, 'pac' => 0.05, 'tuitionreduction' => 0.25],
			'class_8' => ['class' => 0.8, 'pac' => 0.05, 'tuitionreduction' => 0.15],
		];
	}
}