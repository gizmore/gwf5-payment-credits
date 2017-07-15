<?php
/**
 * Pay with own gwf credits.
 * @author gizmore
 * @version 5.0
 */
final class PaymentCredits_Pay extends GWF_Method
{
	public function isAlwaysTransactional() { return true; }
	
	public function execute()
	{
		$user = GWF_User::current();
		$module = Module_PaymentCredits::instance();

		# Check
		if ( (!($order = GWF_Order::getById(Common::getRequestString('order')))) ||
			 ($order->isPaid()) || (!$order->isCreator($user)) )
		{
			return $this->error('err_order')->add($order->redirectFailure());
		}
		
		# Pay?
		$price = $order->getPrice();
		$credits = $module->priceToCredits($price);
		if ($user->getCredits() < $credits)
		{
			$response = $this->error('err_no_credits', [$order->displayPrice(), $credits, $user->getCredits()]);
			return $response->add($order->redirectFailure());
		}
		
		# Pay and Exec
		$user->increase('user_credits', -$credits);
		return $order->executeOrder();
	}
}
