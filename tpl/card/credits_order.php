<?php $gdo instanceof GWF_CreditsOrder; $user = $gdo->getUser(); ?>
<md-card class="gwf-credits-order">
  <md-card-title>
    <md-card-title-text>
      <span class="md-headline">
        <div><?php l('card_title_credits_order', [$gdo->getCredits()]); ?></div>
        <div class="gwf-card-subtitle"><?php l('card_title_credits_price', [$gdo->getCredits(), $gdo->displayPrice()]); ?></div>
      </span>
    </md-card-title-text>
  </md-card-title>
  <gwf-div></gwf-div>
  <md-card-content flex>
    <div><?php l('card_info_credits_price', [$gdo->getCredits(), $gdo->displayPrice()]); ?></div>
  </md-card-content>
</md-card>
