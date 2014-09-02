<?php

class AdminController extends BaseController {
	public function getCaft()
	{
		$users = User::where('payment', '=', 0)->orderby('activated_at', 'desc')->get();
		return View::make('admin.caft', ['users'=>$users]); 
	}
}