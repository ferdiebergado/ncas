<?php

namespace App;

final class Competency extends AbstractBaseModel
{
    /**
     * Prefix for competency_id
     *
     * @var string
     */
    public const PREFIX = 'COC-';

    protected $guarded = [];

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, 'qualification_id', 'qualification_id');
    }

    public function assessments()
    {
        return $this->morphMany(Assessment::class, 'assessmentable', null, null, 'competency_id');
    }
}
