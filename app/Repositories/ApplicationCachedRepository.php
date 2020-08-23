<?php
namespace App\Repositories;

use App\Application;

class ApplicationCachedRepository extends BaseRepository
 {
     public function __construct(Application $application)
     {
         parent::__construct($application);
     }
 }

