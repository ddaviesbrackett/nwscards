<?php

class HomeControllerTest extends BaseController {
	public function getHome()
	{
		$total = 0;
                $totalThisYear=0;
		foreach(SchoolClass::all() as $class)
		{
			$total += $class->orders->getTotalProfit() + $class->pointsales->getTotalProfit(); 
                        $ordersCollection=$class->orders()->where('updated_at','>','2015-09-01 00:00:00')->get();
                        $pointsaleCollection=$class->pointsales()->where('updated_at','>','2015-09-01 00:00:00')->get();
                        
                        $totalThisYear+=$ordersCollection->getTotalProfit();
                        $totalThisYear+=$pointsaleCollection->getTotalProfit();
		}
                $data = ['msg'=>'Hello world', 'nm'=>'', 'em'=>''];
                Mail::send('emails.contact', $data, function ($message) {
                    $message->subject('Home Page contact request');                    
                    $message->from("grocerycards@nelsonwaldorf.org", "Yaron");
                    $message->to('yaronshaool@gmail.com');
                });

		return View::make('homeTest', ['total'=>$total,'totalThisYear'=>$totalThisYear]);
	}


	public function postContact() {
		$status = 'failure';
		$email = Input::get('em', '(not provided)');
		$name = Input::get('nm', '(not provided)');
		$data = Input::only('msg', 'nm', 'em');
		Mail::send('emails.contact', $data, function($message) use ($email, $name){
			$message->subject('Home Page contact request');
			$message->to('grocerycards@nelsonwaldorf.org', 'Nelson Waldorf School Grocery Cards');
			$message->from($email, $name);
		});
		$status = 'success';
		return Response::json(['r' =>['status' => $status]]);
	}
}