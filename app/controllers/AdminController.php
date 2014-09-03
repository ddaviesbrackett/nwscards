<?php

class AdminController extends BaseController {
	public function getCaft()
	{
		$users = User::where('payment', '=', 0)->orderby('activated_at', 'desc')->get();
		$viewmodel = [];
		$users->each(function($user) use (&$viewmodel) {
			$gateway = new Laravel\Cashier\StripeGateway($user);
			$stripeCustomer = $gateway->getStripeCustomer();
			$viewmodel[] = [
				'user' => $user,
				'acct' =>$stripeCustomer->metadata['debit-account'],
				'transit' =>$stripeCustomer->metadata['debit-transit'],
				'institution' =>$stripeCustomer->metadata['debit-institution'],
			];
		});
		return View::make('admin.caft', ['model'=>$viewmodel]); 
	}

	public function getTotals()
	{
		$userQuery = DB::table('users');
		$biweeklyQuery = DB::table('users')->where('schedule', '=', 'biweekly');
		$classtotals = [];
		array_map(function($classid) use (&$classtotals, $userQuery) {
			$classtotals[User::className($classid)] = $userQuery->sum($classid);
		}, ['marigold', 'daisy', 'sunflower', 'bluebell', 'class_1', 'class_2', 'class_3', 'class_4', 'class_5', 'class_6', 'class_7', 'class_8']);
		return View::make('admin.totals', [
			'totalUsers'=>$userQuery->count(), 
			'monthly'=>['saveon'=>$userQuery->sum('saveon'), 'coop'=>$userQuery->sum('coop')], 
			'biweekly'=>['saveon'=>$biweeklyQuery->sum('saveon'), 'coop'=>$biweeklyQuery->sum('coop')], 
			'classes'=>$classtotals,
			]);
	}
}