<?php


namespace App\Models;


interface IHasItemsContainer
{
    public static function getItemsContainerIDField();
    public function getItemsContainer();
    public function deleteItemsContainer();
    public static function getItemsRouteName();
    public static function getItemsForeignKey();
}