<?php $order instanceof GWF_Order; ?>
<?php
$user = $order->getUser();
$bar = GDO_Bar::make();
$price = $order->getPrice();
$module = Module_PaymentCredits::instance();
$button = GDO_Button::make()->label('btn_pay_credits', [$module->priceToCredits($price), $user->getCredits()]);
$button->href(href('PaymentCredits', 'Pay', '&order='.$order->getID()));
$button->icon('attach_money');
$bar->addField($button);
echo $bar->renderCell();
