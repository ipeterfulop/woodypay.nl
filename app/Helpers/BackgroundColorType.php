<?php


namespace App\Helpers;


use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;

class BackgroundColorType
{
    use canBeTurnedIntoKeyValueCollection;

    const SOLID_ID = 1;
    const SOLID_LABEL = 'Solid';
    const GRADIENT_ID = 2;
    const GRADIENT_LABEL = 'Gradient';
}