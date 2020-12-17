<?php


namespace App\Traits;


trait HasDisabledTimestamp
{
    public function isDisabled()
    {
        return $this->disabled_at != null;
    }

    public function getDisabledAtLabel()
    {
        return $this->disabled_at == null
            ? __('Aktív')
            : __('Inaktív (deaktiválva: '.$this->disabled_at->format('Y-m-d H:i:s'));
    }

    public function scopeEnabled($query)
    {
        return $query->where('disabled_at', '=', null);
    }

    public function scopeDisabled($query)
    {
        return $query->where('disabled_at', '!=', null);
    }
}