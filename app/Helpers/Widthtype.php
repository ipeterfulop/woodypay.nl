<?php


namespace App\Helpers;


use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;

class Widthtype
{
    use canBeTurnedIntoKeyValueCollection;

    const USE_LABEL_AS_TRANSLATION_KEY = true;
    const CENTERED_ID = 1;
    const CENTERED_LABEL = 'Centered';
    const FULL_ID = 2;
    const FULL_LABEL = 'Fullscreen';

    const ROADBLOCK_CLASSNAME = '.roadblock';
}