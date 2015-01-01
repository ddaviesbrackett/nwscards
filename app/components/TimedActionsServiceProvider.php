<?php namespace NWSCards\components;
use Illuminate\Support\ServiceProvider;

class TimedActionsServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerNightlies();
	}

	private function registerNightlies() {
		\Event::listen('timed.nightly', 'NWSCards\eventHandlers\OrderGenerationHandler');
		\Event::listen('timed.nightly', 'NWSCards\eventHandlers\DeadlineReminderHandler');
		\Event::listen('timed.nightly', 'NWSCards\eventHandlers\PickupReminderHandler');
		\Event::listen('timed.nightly', 'NWSCards\eventHandlers\CreditOrderHandler');
	}
}
