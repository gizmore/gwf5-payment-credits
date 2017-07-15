<?php $navbar instanceof GWF_Navbar;
if ($navbar->isRight())
{
	$user = GWF_User::current();
	$link = GDO_Link::make('link_credits')->label('link_credits', [$user->getCredits()])->href(href('PaymentCredits', 'Order'));
	$navbar->addField($link);
}
