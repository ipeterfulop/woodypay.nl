<?php


namespace App\Helpers;


use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;

class Spendingcategory
{
    use canBeTurnedIntoKeyValueCollection;

    const C1_ID = 1;
    const C1_LABEL = '<$100';
    const C2_ID = 2;
    const C2_LABEL = '$100-$300';
    const C3_ID = 3;
    const C3_LABEL = '$300-$600';
    const C4_ID = 4;
    const C4_LABEL = '$600-$1000';
    const C5_ID = 5;
    const C5_LABEL = '>$1000';
}