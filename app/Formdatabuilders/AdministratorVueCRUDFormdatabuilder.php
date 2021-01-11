<?php


namespace App\Formdatabuilders;


use App\Models\Administrator;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\TextVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\VueCRUDFormdatabuilder;

class AdministratorVueCRUDFormdatabuilder extends VueCRUDFormdatabuilder
{
    /**
     * @return Illuminate\Support\Collection;
     * returns a collection of VueCRUDFormfield descendants that
     * define what the edit/create forms will contain
     */
    protected static function getFields()
    {
        $result = [];
        $result['name'] = (new TextVueCRUDFormfield())
            ->setLabel(__('Név'))
            ->setMandatory(true);
        $result['email'] = (new TextVueCRUDFormfield())
            ->setLabel(__('E-mail'))
            ->setMandatory(true);
        $result['password'] = (new TextVueCRUDFormfield())
            ->setOnlyWhenCreating(true)
            ->setLabel(__('Password'))
            ->setMandatory(true);
        return collect($result);
    }

    public function __construct(Administrator $subject = null, $defaults = [])
    {
        $this->subject = $subject;
        $this->defaults = $defaults;
    }
}