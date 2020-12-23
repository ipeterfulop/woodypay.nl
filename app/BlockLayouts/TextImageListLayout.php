<?php

namespace App\BlockLayouts;

use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;

class TextImageListLayout
{
    use canBeTurnedIntoKeyValueCollection;

    const FEATURE_LIST_ID = 41;
    const FEATURE_LIST_LABEL = 'Feature list';
    const COLLAPSIBLE_ITEM_LIST_ID = 42;
    const COLLAPSIBLE_ITEM_LIST_LABEL = 'List of collapsible items';
}
