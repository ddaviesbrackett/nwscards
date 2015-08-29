<?php

use Illuminate\Database\Eloquent\Collection;

class Orders extends Collection {
	public function getTotalProfit()
	{
		return $this->reduce(function($total, $order) {
			$current = $order->pivot? $order->pivot->profit : 0;
			return $total + $current;
		});
	}
}