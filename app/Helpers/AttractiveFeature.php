<?php


namespace App\Helpers;


use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;

class AttractiveFeature
{
    use canBeTurnedIntoKeyValueCollection;

    const CARD_ID = 1;
    const CARD_LABEL = 'Wooden debit card';
    const CLIMATE_ID = 2;
    const CLIMATE_LABEL = 'Fighting climate change';
    const TRACKING_ID = 3;
    const TRACKING_LABEL = 'Spending tracking';
    const FEES_ID = 4;
    const FEES_LABEL = 'No fees';
    const OTHER_ID = 999;
    const OTHER_LABEL = 'Other';

    const CUSTOM_OPTION_ID = self::OTHER_ID;
}