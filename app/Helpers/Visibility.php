<?php


namespace App\Helpers;


use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;

class Visibility
{
    use canBeTurnedIntoKeyValueCollection;
    const NONE_ID = 0;
    const NONE_LABEL = 'Nobody';
    const ADMIN_ID = 1;
    const ADMIN_LABEL = 'Admin';
    const EVERYONE_ID = 2;
    const EVERYONE_LABEL = 'Everyone';
}