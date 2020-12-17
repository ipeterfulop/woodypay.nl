<?php


namespace App\Helpers;


use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;

class UseractionType
{
    use canBeTurnedIntoKeyValueCollection;

    const LOGIN_ID = 1;
    const LOGIN_LABEL = 'Bejelentkezés';
    const FAILED_LOGIN_ID = 2;
    const FAILED_LOGIN_LABEL = 'Sikertelen bejelentkezés';
}