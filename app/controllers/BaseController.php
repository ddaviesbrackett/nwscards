<?php

class BaseController extends Controller {
	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	protected function dumpQueries() {
		var_dump(DB::getQueryLog());
	}
	protected function dumpLastQuery() {
		$queries = DB::getQueryLog();
		$last_query = end($queries);
		var_dump($last_query);
	}

	public static function getFormattedDates() {
		return array_map(function(array $dts){
			return array_map(function($d){
				return $d->format('l, F jS');
			}, $dts);
		}, BaseController::getCutoffsNew());
	}

	/*
	* cutoff dates are the last day on which we can accept an order
	*/
	public static function getCutoffs( $target = NULL ) {;
		if(is_null($target)){
			$target = (new \Carbon\Carbon('America/Los_Angeles'))->format('Y-m-d');
		}
		$ret = array();

		$cutoffs = CutoffDate::where('cutoff','>=',$target)->orderBy('cutoff','asc')->take(2)->get();
		$cutoff = $cutoffs[0];
		$ret['biweekly'] = ['cutoff' => $cutoff->cutoffdate(), 'charge' => $cutoff->chargedate(), 'delivery' => $cutoff->deliverydate()];
		if($cutoff->first) {
			$ret['monthly-second'] = ['cutoff' => $cutoffs[1]->cutoffdate(), 'charge' => $cutoffs[1]->chargedate(), 'delivery' =>  $cutoffs[1]->deliverydate()];
			$ret['monthly'] = ['cutoff' => $cutoff->cutoffdate(), 'charge' => $cutoff->chargedate(), 'delivery' =>  $cutoff->deliverydate()];
		}
		else
		{
			$ret['monthly-second'] = ['cutoff' => $cutoff->cutoffdate(), 'charge' => $cutoff->chargedate(), 'delivery' =>  $cutoff->deliverydate()];
			$ret['monthly'] = ['cutoff' => $cutoffs[1]->cutoffdate(), 'charge' => $cutoffs[1]->chargedate(), 'delivery' =>  $cutoffs[1]->deliverydate()];
		}
                 
		return $ret;
	}
	/*
	* cutoff dates are the last day on which we can accept an order
	*/
	public static function getCutoffsNew( $target = NULL ) {
            $ret = array();
           
		if(is_null($target)){
			$target = (new \Carbon\Carbon('America/Los_Angeles'))->format('Y-m-d');
		}
                
                    $cutoffs = CutoffDate::where('cutoff','>=',$target)->orderBy('cutoff','asc')->take(3)->get();

		$cutoffUpcoming = $cutoffs[0];
                $cutoffNext = $cutoffs[1];
                $cutoffNextNext = $cutoffs[2];
                
		$ret['biweekly'] = ['cutoff' => $cutoffUpcoming->cutoffdate(), 'charge' => $cutoffUpcoming->chargedate(), 'delivery' => $cutoffUpcoming->deliverydate()];
                
		if($cutoffUpcoming->first) {
			$ret['monthly'] = ['cutoff' => $cutoffUpcoming->cutoffdate(), 'charge' => $cutoffUpcoming->chargedate(), 'delivery' =>  $cutoffUpcoming->deliverydate()];
                        if (!$cutoffNext->first)
                            $ret['monthly-second'] = ['cutoff' => $cutoffNext->cutoffdate(), 'charge' => $cutoffNext->chargedate(), 'delivery' =>  $cutoffNext->deliverydate()];
                        else
                            $ret['monthly-second'] = ['cutoff' => $cutoffNextNext->cutoffdate(), 'charge' => $cutoffNextNext->chargedate(), 'delivery' =>  $cutoffNextNext->deliverydate()];
		}
		else
		{
			$ret['monthly-second'] = ['cutoff' => $cutoffUpcoming->cutoffdate(), 'charge' => $cutoffUpcoming->chargedate(), 'delivery' =>  $cutoffUpcoming->deliverydate()];
                        if ($cutoffNext->first)
                            $ret['monthly'] = ['cutoff' => $cutoffNext->cutoffdate(), 'charge' => $cutoffNext->chargedate(), 'delivery' =>  $cutoffNext->deliverydate()];
                        else
                           $ret['monthly'] = ['cutoff' => $cutoffNextNext->cutoffdate(), 'charge' => $cutoffNextNext->chargedate(), 'delivery' =>  $cutoffNextNext->deliverydate()]; 
		}
		return $ret;
	}        
}
