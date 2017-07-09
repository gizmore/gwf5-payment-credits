<?php
/**
 * Pay with own gwf credits.
 * @author gizmore
 * @version 5.0
 */
final class PaymentCredits_InitPayment extends GWF_MethodPayment
{
	public function execute()
	{
		if (!($order = $this->getOrderPersisted()))
		{
			return $this->error('err_order');
		}
		return $this->renderOrder($order);
	}
}
