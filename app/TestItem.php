<?php

namespace App;

class TestItem extends AbstractBaseModel
{
    /**
     * Test item types
     *
     * @var array
     */
    public const TYPES = [
        'M' => 'Multiple Choice',
        'T' => 'True or False',
        'I' => 'Identification'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array'
    ];

    public function competency()
    {
        return $this->belongsTo(Competency::class, 'competency_uuid', 'uuid');
    }

    public function getPathAttribute()
    {
        return '/testitems/' . $this->attributes['id'];
    }
}
