<?php $navbar instanceof GWF_Navbar;
$user = GWF_User::current();
if ($navbar->isRight())
{
	$link = GDO_Link::make('link_credits')->label('link_credits', [$user->getCredits()])->href(href('PaymentCredits', 'Order'));
	$navbar->addField($link);
}
