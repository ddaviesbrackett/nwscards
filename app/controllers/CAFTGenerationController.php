<?php

class CAFTGenerationController extends BaseController {
	
	private function spaces($width)
	{
		$spc = '';
		for($i = 0; $i < $width; $i++)
		{
			$spc .= ' ';
		}
		return $spc;
	}

	private function zeroes($width)
	{
		$spc = '';
		for($i = 0; $i < $width; $i++)
		{
			$spc .= '0';
		}
		return $spc;
	}

	private function stripAndTrim($stringOfNumbers)
	{
		return trim(preg_replace("/[^\d]*/", "", $stringOfNumbers));
	}

	public function getResult($cutoff)
	{
		$originatorID = $_ENV['caft_originator_id']; // originator ID from CAFT
		$filenumber = sprintf('%04.4d', Input::get('filenum'));
		$originatorinfo = $originatorID . $filenumber;
		//caft magic
		$content = 'A000000001' . $originatorinfo . Carbon\Carbon::now('America/Los_Angeles')->formatLocalized('0%y%j') . '86900' . $this->spaces(20) . 'CAD' . $this->spaces(1406);
		$total = 0;
		$skipped = 0;

		$totalDollarValue = 0; // in cents
		$debitOrders = $cutoff->orders()->where('payment', '=', 0)->get();
		foreach($debitOrders as $order)
		{
			$user = $order->user;
			$gateway = new Laravel\Cashier\StripeGateway($user);
			$stripeCustomer = $gateway->getStripeCustomer();
			$acct = $this->stripAndTrim($stripeCustomer->metadata['debit-account']);
			if(is_numeric($acct) && $acct != 0){
				$linenum = ($total / 6) + 2; //1-indexed, starting with 2 because the A record is 1
				if ($total % 6 == 0)
				{
					$content .= "\r\nD" . sprintf('%09d', $linenum) . $originatorinfo;
				}


				$orderAmount = $order->totalCards() * 10000;
				$totalDollarValue += $orderAmount;

				$content .= '450'; //transaction type code
				$content .=  sprintf('%010.10d', $orderAmount); //amount
				$content .=  $cutoff->chargedate()->formatLocalized('0%y%j'); //due date
				$content .=  '0' . sprintf('%03.3d', $this->stripAndTrim($stripeCustomer->metadata['debit-institution'])) . sprintf('%05.5d', $this->stripAndTrim($stripeCustomer->metadata['debit-transit']));
				$content .= sprintf('%-12.12s', $acct);
				$content .=  $this->spaces(22); //internal use
				$content .= $this->zeroes(3); //internal use
				$content .= 'NWS GROC CARDS '; //our short name
				$content .= sprintf("%30.30s", $order->user->name); //payor name - $order->user->name, but formatted
				$content .= 'NWS Grocery Card Fundraiser   '; //our long name
				$content .= $originatorID;
				$content .= sprintf('%19.19s', 'User:' . $user->id . ' Order:' . $order->id); // originator cross reference
				$content .= $_ENV['caft_return_institution_id']; //institutional id number for returns = 0 . institution . transit
				$content .= $_ENV['caft_return_account_id']; //account for returns LEFT JUSTIFIED OMIT BLANKS AND DASHES
				$content .= 'NWS GROC CARDS '; // information to identify transaction to recipient
				$content .= $this->spaces(24);
				$content .= $this->zeroes(11);
				$total++;
			}
			else {
				$skipped++;
			}
		}

		// pad record with extra spaces
		if ($total % 6 != 0)
		{
			$numBlankSegments = 6 - ($total % 6);
			$content .= $this->spaces($numBlankSegments * 240);
			$total += $numBlankSegments; //so the line number calculations line up
		}

		$content .= "\r\n";

		// send Z record indicating end of file
		$content .= 'Z' . sprintf('%09d', $total / 6 + 2) . $originatorinfo . sprintf('%014d', $totalDollarValue) . sprintf('%08d', $debitOrders->count() - $skipped) . $this->zeroes(66) . $this->spaces(1352) . "\r\n";

		$resp = Response::make($content);

		$resp->header('Content-Disposition', 'attachment;filename=caft-' . $cutoff->cutoffdate() . '.aft');

		return $resp;
	}
}