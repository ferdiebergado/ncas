<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Repositories\QualificationCachedRepository;

class QualificationService extends BaseService
{
    public function __construct(QualificationCachedRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create($data)
    {
        if (empty($data['competencies'])) {
            return $this->repository->create($data);
        }

        DB::beginTransaction();

        try {
            $qualification = $this->repository->create(Arr::except($data, 'competencies'));
            $competencies = $data['competencies'];
            $qualification->competencies()->createMany($competencies);
            $qualification->update(['coc_count' => count($competencies)]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            // return back()->withErrors($e->getMessage());
        }

        DB::commit();

        return $this->repository->with('competencies')->whereQualificationId($qualification->qualification_id)->first();
    }
}
