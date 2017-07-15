<?php
/**
 * Order own credits and pay with another payment processor.
 * @author gizmore
 */
final class GWF_CreditsOrder extends GDO implements GWF_Orderable
{
	public function paymentCredits() { return Module_PaymentCredits::instance(); }
	public function getOrderCancelURL(GWF_User $user) { return url('CreditsOrder', 'Order'); }
	public function getOrderSuccessURL(GWF_User $user) { return url('CreditsOrder', 'Order'); }
	
	public function getOrderTitle(string $iso) { return t('card_title_credits_order', [$this->getCredits()]); }
	public function getOrderPrice() { return $this->paymentCredits()->creditsToPrice($this->getCredits()); }
	public function displayPrice() { return $this->paymentCredits()->displayPrice($this->getOrderPrice()); }
	public function canPayOrderWith(GWF_PaymentModule $module) { return true; }
	
	public function onOrderPaid()
	{
		$user = $this->getUser();
		$credits = $this->getCredits();
		$oldCredits = $user->getCredits();
		$user->increase('user_credits', $credits);
		$newCredits = $user->getCredits();
		return GWF_Message::message('msg_credits_purchased', [$credits, $oldCredits, $newCredits]);
	}
	
	###########
	### GDO ###
	###########
	public function gdoColumns()
	{
		return array(
			GDO_AutoInc::make('co_id'),
			GDO_User::make('co_user')->notNull(),
			GDO_Int::make('co_credits')->unsigned()->notNull()->min($this->paymentCredits()->cfgMinPurchaseCredits())->label('credits'),
		);
	}
	
	##############
	### Getter ###
	##############
	/**
	 * @return GWF_User
	 */
	public function getUser() { return $this->getValue('co_user'); }
	public function getUserID() { return $this->getVar('co_user'); }
	public function getCredits() { return $this->getVar('co_credits'); }
	
	##############
	### Render ###
	##############
	public function renderCard() { return GWF_Template::modulePHP('PaymentCredits', 'card/credits_order.php', ['gdo' => $this]); }

}
