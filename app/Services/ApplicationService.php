<?php

namespace App\Services;

use App\Assessment;
use App\Competency;
use App\Qualification;
use App\Repositories\ApplicationCachedRepository;
use Illuminate\Support\Facades\DB;

class ApplicationService extends BaseService
{
    public function __construct(ApplicationCachedRepository $application)
    {
        parent::__construct($application);
    }

    public function create($data)
    {
        DB::beginTransaction();

        try {
            $application = $this->repository->create($data);

            if (isset($data['competencies'])) {
                // the assessment is for a competency/group of competencies
                // create a new assessment for each competency
                foreach ($data['competencies'] as $competency) {
                    $assessment = new Assessment;
                    $application->assessments()->save($assessment);
                    // update the polymorphic relation
                    $c = Competency::whereCompetencyId($competency)->firstOrFail();
                    $c->assessments()->save($assessment->fresh());
                }
            } else {
                // the assessment is for a full qualification
                $assessment = new Assessment;
                $application->assessments()->save($assessment);
                // update the polymorphic relation
                $q = Qualification::whereQualificationId($data['qualification_id'])->firstOrFail();
                $q->assessments()->save($assessment->fresh());
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            // return back()->withErrors($e->getMessage());
        }

        DB::commit();

        return $application->fresh();
    }
}
