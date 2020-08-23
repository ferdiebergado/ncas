<?php

namespace Tests\Feature;

use App\Application;
use App\Assessment;
use App\Competency;
use App\Qualification;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApplicationCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function createQualification()
    {
        $qualification = [
            'title' => $this->faker->words(2, true),
            'level_id' => array_rand(Qualification::LEVELS),
            'category_id' => array_rand(Qualification::CATEGORIES)
        ];
        $competencies = [];

        for ($i = 1; $i <= 3; $i++) {
            $competency = [
                'level' => $i,
                'title' => $this->faker->words(6, true)
            ];
            array_push($competencies, $competency);
        }

        $data = array_merge($qualification, compact('competencies'));

        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('qualifications.store'), $data);

        Auth::logout();
    }

    private function getData()
    {
        $this->createQualification();

        $qualification = Qualification::with('competencies')->first();

        return [
            'last_name' => 'Catacutan',
            'first_name' => 'Romeo',
            'middle_name' => 'Dimaandal',
            'sex' => 'M',
            'mobile' => '9876543210',
            'email' => 'awooo@lagim.com',
            'qualification_id' => $qualification->qualification_id,
            'competencies' => [$qualification->competencies[0]->competency_id]
        ];
    }

    /**
     * Test the application form can be viewed.
     *
     * @return void
     */
    public function testTheApplicationFormCanBeViewed()
    {
        $response = $this->get(route('applications.create'));

        $response->assertStatus(200);

        $response->assertViewIs('application.create');
    }

    public function testApplicationIsCreatedWhenInputIsValid()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(route('applications.store'), $this->getData());

        $this->assertCount(1, Application::all());

        // assert a new assessment is also created
        $this->assertCount(1, Assessment::all());

        // assert one to many polymorphic relation with Assessment using custom id, should work as expected
        $this->assertCount(1, Competency::first()->assessments);
        $this->assertEquals(Competency::first()->competency_id, Assessment::first()->assessmentable_id);
        $this->assertEquals('App\Competency', Assessment::first()->assessmentable_type);

        // assert coc_count is set correctly by the ApplicationObserver
        $this->assertEquals(1, Application::first()->coc_count);
    }

    public function testLastNameIsRequiredOnApplicationCreate()
    {
        $data = Arr::except($this->getData(), 'last_name');
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('last_name');

        $this->assertCount(0, Application::all());
    }

    public function testLastNameMustNotExceedMaxCharsOnApplicationCreate()
    {
        $last_name = Str::random(70);
        $data = array_merge($this->getData(), compact('last_name'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('last_name');

        $this->assertCount(0, Application::all());
    }

    public function testFirstNameIsRequiredOnApplicationCreate()
    {
        $data = Arr::except($this->getData(), 'first_name');
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('first_name');

        $this->assertCount(0, Application::all());
    }

    public function testFirstNameMustNotExceedMaxCharsOnApplicationCreate()
    {
        $first_name = Str::random(70);
        $data = array_merge($this->getData(), compact('first_name'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('first_name');

        $this->assertCount(0, Application::all());
    }

    public function testMiddleNameMustNotExceedMaxCharsOnApplicationCreate()
    {
        $middle_name = Str::random(70);
        $data = array_merge($this->getData(), compact('middle_name'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('middle_name');

        $this->assertCount(0, Application::all());
    }

    public function testSexIsRequiredOnApplicationCreate()
    {
        $data = Arr::except($this->getData(), 'sex');
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('sex');

        $this->assertCount(0, Application::all());
    }

    public function testSexMustOnlyBeMorFOnApplicationCreate()
    {
        $sex = 'G';
        $data = array_merge($this->getData(), compact('sex'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('sex');

        $this->assertCount(0, Application::all());
    }

    public function testMobileIsRequiredOnApplicationCreate()
    {
        $data = Arr::except($this->getData(), 'mobile');
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('mobile');

        $this->assertCount(0, Application::all());
    }

    public function testMobileShouldBeInValidFormatOnApplicationCreate()
    {
        $mobile = Str::random(11);
        $data = array_merge($this->getData(), compact('mobile'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('mobile');

        $this->assertCount(0, Application::all());
    }

    public function testEmailIsRequiredOnApplicationCreate()
    {
        $data = Arr::except($this->getData(), 'email');
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('email');

        $this->assertCount(0, Application::all());
    }

    public function testEmailMustBeAnEmailOnApplicationCreate()
    {
        $email = Str::random(11);
        $data = array_merge($this->getData(), compact('email'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('email');

        $this->assertCount(0, Application::all());
    }

    public function testQualificationIdIsRequiredOnApplicationCreate()
    {
        $data = Arr::except($this->getData(), 'qualification_id');
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('qualification_id');

        $this->assertCount(0, Application::all());
    }

    public function testQualificationIdMustExistInTheDatabaseOnApplicationCreate()
    {
        $qualification_id = Str::random(11);
        $data = array_merge($this->getData(), compact('qualification_id'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('qualification_id');

        $this->assertCount(0, Application::all());
    }

    public function testCompetenciesMustBeAnArrayIfPresentOnApplicationCreate()
    {
        $competencies = Str::random(11);
        $data = array_merge($this->getData(), compact('competencies'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('competencies');

        $this->assertCount(0, Application::all());
    }

    public function testCompetencyMustExistInTheDatabaseOnApplicationCreate()
    {
        $competencies = [Str::random(11)];
        $data = array_merge($this->getData(), compact('competencies'));
        $response = $this->post(route('applications.store'), $data);

        $response->assertSessionHasErrors('competencies.*');

        $this->assertCount(0, Application::all());
    }
}
