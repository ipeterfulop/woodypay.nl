<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Block extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['blocktype_id'];

    const SUBJECTTYPE_ID = 1;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return [];
    }

    public static function getBlockTypeTag(): ?string
    {
        $reflect = new ReflectionClass(new static());
        return 'tag_' . $reflect->getShortName();
    }

    public static function createWithTranslations($data)
    {
        $model = null;
        \DB::transaction(function() use ($data, &$model){
            $typeId = BlockType::findByTag(static::getBlockTypeTag())->id;
            $block = Block::create([
                'blocktype_id' => $typeId
            ]);
            $data['id'] = $block->id;
            $model = parent::createWithTranslations($data);
        });

        return $model;
    }

}

