<?php

namespace Tests\Feature;

use App\User;
use App\Competency;
use Tests\TestCase;
use App\Qualification;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QualificationCreateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();

        $this->actingAs($user);
    }

    private function getData()
    {
        return [
            'title' => 'Qualification Title 1',
            'level_id' => 1,
            'category_id' => 1,
            'competencies' => [
                [
                    'level' => 1,
                    'title' => 'COC 1 Title'
                ],
                [
                    'level' => 2,
                    'title' => 'COC 2 Title'
                ]
            ]
        ];
    }

    /**
     * Test a logged in user can view the create qualification form
     *
     * @return void
     */
    public function testALoggedInUserCanViewTheCreateQualificationForm()
    {
        $response = $this->get(route('qualifications.create'));

        $response->assertStatus(200);

        $response->assertViewIs('qualification.create');
    }

    public function testALoggedInUserCanCreateAQualification()
    {
        $response = $this->post(route('qualifications.store'), $this->getData());

        $this->assertCount(1, Qualification::all());
        $coc_count = count($this->getData()['competencies']);
        $this->assertCount($coc_count, Competency::all());

        $qualification = Qualification::first();
        $this->assertEquals($coc_count, $qualification->coc_count);

        $response->assertSessionHas('success');
        $response->assertRedirect(route('qualifications.show', $qualification));
    }

    public function testAGuestCantCreateAQualification()
    {
        Auth::logout();

        $response = $this->post(route('qualifications.store'), $this->getData());

        $this->assertCount(0, Qualification::all());

        $response->assertRedirect(route('login'));
    }

    public function testQualificationTitleIsRequiredOnCreate()
    {
        $data = Arr::except($this->getData(), 'title');
        $response = $this->post(route('qualifications.store'), $data);

        $response->assertSessionHasErrors('title');
    }

    public function testQualificationTitleMustNotExceedMaxCharsOnCreate()
    {
        $title = Str::random(200);
        $data = array_merge($this->getData(), compact('title'));
        $response = $this->post(route('qualifications.store'), $data);

        $response->assertSessionHasErrors('title');
    }

    public function testQualificationLevelIsRequiredOnCreate()
    {
        $data = Arr::except($this->getData(), 'level_id');
        $response = $this->post(route('qualifications.store'), $data);

        $response->assertSessionHasErrors('level_id');
    }

    public function testQualificationLevelShouldBeInLevelArrayOnCreate()
    {
        $level_id = 5;

        $data = array_merge($this->getData(), compact('level_id'));

        $response = $this->post(route('qualifications.store'), $data);

        $this->assertCount(0, Qualification::all());

        $response->assertSessionHasErrors('level_id');
    }

    public function testQualificationCategoryShouldBeInCategoryArrayOnCreate()
    {
        $category_id = 99;

        $data = array_merge($this->getData(), compact('category_id'));

        $response = $this->post(route('qualifications.store'), $data);

        $this->assertCount(0, Qualification::all());

        $response->assertSessionHasErrors('category_id');
    }

    public function testQualificationCompetenciesShouldContainAtLeastOneCompetencyIfPresentOnCreate()
    {
        $competencies = [];

        $data = array_merge($this->getData(), compact('competencies'));

        $response = $this->post(route('qualifications.store'), $data);

        $response->assertSessionHasErrors('competencies');

        $this->assertCount(0, Qualification::all());
        $this->assertCount(0, Competency::all());
    }

    public function testQualificationCompetencyTitleIsRequiredOnCreate()
    {
        $competencies = [
            [
                'level' => 1,
                'title' => null
            ]
        ];

        $data = array_merge($this->getData(), compact('competencies'));

        $response = $this->post(route('qualifications.store'), $data);

        $response->assertSessionHasErrors('competencies.*.title');

        $this->assertCount(0, Qualification::all());
        $this->assertCount(0, Competency::all());
    }

    public function testQualificationCompetencyTitleMusNotExceedMaxCharactersOnCreate()
    {
        $competencies = [
            [
                'level' => 1,
                'title' => Str::random(200)
            ]
        ];

        $data = array_merge($this->getData(), compact('competencies'));

        $response = $this->post(route('qualifications.store'), $data);

        $response->assertSessionHasErrors('competencies.*.title');

        $this->assertCount(0, Qualification::all());
        $this->assertCount(0, Competency::all());
    }

    public function testQualificationCompetencyLevelIsRequiredOnCreate()
    {
        $competencies = [
            [
                'level' => null,
                'title' => Str::random(100)
            ]
        ];

        $data = array_merge($this->getData(), compact('competencies'));

        $response = $this->post(route('qualifications.store'), $data);

        $response->assertSessionHasErrors('competencies.*.level');

        $this->assertCount(0, Qualification::all());
        $this->assertCount(0, Competency::all());
    }

    public function testQualificationCompetencyLevelMustNotExceedMaxLevel()
    {
        $competencies = [
            [
                'level' => 5,
                'title' => Str::random(100)
            ]
        ];

        $data = array_merge($this->getData(), compact('competencies'));

        $response = $this->post(route('qualifications.store'), $data);

        $response->assertSessionHasErrors('competencies.*.level');

        $this->assertCount(0, Qualification::all());
        $this->assertCount(0, Competency::all());
    }
}
