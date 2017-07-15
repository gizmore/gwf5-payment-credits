<?php
/**
 * Pay with own credits.
 * Buy own credits.
 * @author gizmore
 * @license MIT
 * @since 4.0
 */
final class Module_PaymentCredits extends GWF_PaymentModule
{
	 #########################
	### GWF_PaymentModule ###
	########################
	public function makePaymentButton(string $href)
	{
		$button = parent::makePaymentButton($href);
		return $button->label('buy_paymentcredits', [GWF5::instance()->getSiteName()]);
	}
	
	##################
	### GWF_Module ###
	##################
	public function getClasses() { return ['GWF_CreditsOrder']; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/credits'); }
	public function payment() { return Module_Payment::instance(); }

	##############
	### Config ###
	##############
	public function getConfig()
	{
		return array_merge(parent::getConfig(), array(
			GDO_Checkbox::make('paycreds_guests')->initial('0'),
			GDO_Decimal::make('paycreds_min_purchase')->digits(6, 2)->initial('5.00'),
			GDO_Decimal::make('paycreds_rate')->digits(1, 4)->initial('0.01'),
		));
	}
	public function cfgAllowGuests() { return $this->getConfigValue('paycreds_guests'); }
	public function cfgMinPurchasePrice() { return $this->getConfigValue('paycreds_min_purchase'); }
	public function cfgMinPurchaseCredits() { return $this->priceToCredits($this->cfgMinPurchasePrice()); }
	public function cfgConversionRate() { return $this->getConfigValue('paycreds_rate'); }
	public function cfgConversionRateToCurrency() { return $this->cfgConversionRate(); }
	public function cfgConversionRateToCredits() { return 1 / $this->cfgConversionRate(); }
	
	###############
	### Convert ###
	###############
	public function priceToCredits($price) { return floor($this->cfgConversionRateToCredits() * $price); }
	public function creditsToPrice($credits) { return round($this->cfgConversionRateToCurrency() * $credits, 2); }
	public function displayPrice($price) { return sprintf('%.02f %s', $price, GDO_Money::$CURR); }
	public function displayCreditsPrice($credits) { return $this->displayPrice($this->creditsToPrice($credits)); }
	
	###############
	### Sidebar ###
	###############
	public function onRenderFor(GWF_Navbar $navbar)
	{
		$this->templatePHP('sidebar.php', ['navbar' => $navbar]);
	}
}
