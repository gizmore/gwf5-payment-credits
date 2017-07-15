<?php
/**
 * Order more gwf credits.
 * @author gizmore
 */
final class PaymentCredits_Order extends Payment_Order
{
	public function getOrderable()
	{
		return GWF_CreditsOrder::blank(array(
			'co_user' => GWF_User::current()->getID(),
			'co_credits' => $this->getForm()->getVar('co_credits'),
		));
	}
	
	public function createForm(GWF_Form $form)
	{
		$module = Module_PaymentCredits::instance();
		$gdo = GWF_CreditsOrder::table();
		$form->addFields(array(
			$gdo->gdoColumn('co_credits')->initial($module->cfgMinPurchaseCredits()),
			GDO_Submit::make(),
			GDO_AntiCSRF::make(),
		));
	}

}
