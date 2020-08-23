<?php
namespace

use App\Repositories\QualificationCachedRepository;

/**
  * QualificationComposer
  */
 class QualificationComposer
 {
    private $repository;

     public function __construct(QualificationCachedRepository $repository)
     {
         $this->repository = $repository;
     }
 } ?>
