<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeValueSetValue extends TranslatableModel
{
    use HasFactory;

    const SUBJECTTYPE_ID = 104;

    const YES_ID = 1001;
    const NO_ID = 1002;

    protected $table = 'attribute_value_set_values';
    protected $fillable = [
        "id",
        "attribute_set_id",
        "value",
        "label",
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function attribute_value_set(): BelongsTo
    {
        return $this->belongsTo(AttributeValueSet::class);
    }

    public static function getSubjecttypeId(): int
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['label'];
    }
}
