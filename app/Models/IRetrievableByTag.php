<?php


namespace App\Models;


interface IRetrievableByTag
{
    public static function findByTag(string $tag);
}
