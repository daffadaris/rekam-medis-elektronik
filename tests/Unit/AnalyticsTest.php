<?php

namespace Tests\Unit;

use App\Models\Fhir\Encounter;
use App\Models\Fhir\Patient;
use App\Models\Fhir\Resource;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use DatabaseTransactions;


    public function test_get_today_encounters()
    {
        // Create encounters for today
        Encounter::factory()->create([
            'period_start' => Carbon::today(),
            'period_end' => Carbon::today()->addHours(2),
        ]);
        Encounter::factory()->create([
            'period_start' => Carbon::today(),
            'period_end' => Carbon::today()->addHours(4),
        ]);

        // Create encounters for other dates
        Encounter::factory()->create([
            'period_start' => Carbon::yesterday(),
            'period_end' => Carbon::yesterday()->addHours(2),
        ]);
        Encounter::factory()->create([
            'period_start' => Carbon::tomorrow(),
            'period_end' => Carbon::tomorrow()->addHours(2),
        ]);

        // Instantiate the controller
        $response = $this->get(route('analytics.pasien-hari-ini'));

        $response->assertStatus(200);
        $response->assertJson(['count' => 2]);
    }


    public function test_get_this_month_new_patients()
    {
        $patCount = fake()->numberBetween(1, 10);

        // Create a new patient resource
        Resource::factory()->count($patCount)->create([
            'res_type' => 'Patient',
            'created_at' => Carbon::now()->startOfMonth(),
        ]);

        // Create another patient resource from last month
        Resource::factory()->create([
            'res_type' => 'Patient',
            'created_at' => Carbon::now()->subMonth()->startOfMonth(),
        ]);

        // Call the getThisMonthNewPatients method
        $response = $this->get(route('analytics.pasien-baru-bulan-ini'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the response contains the correct count of new patients
        $response->assertJson(['count' => $patCount]);
    }


    public function test_get_total_patient_count()
    {
        $patCount = fake()->numberBetween(1, 10);

        // Create a new patient resource
        Patient::factory()->count($patCount)->create();

        // Call the countPatients method
        $response = $this->get(route('analytics.jumlah-pasien'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the response contains the correct count of new patients
        $response->assertJson(['count' => $patCount]);
    }


    public function test_get_encounters_per_month()
    {
        // Create test data
        $encounter1 = Encounter::factory()->create(['period_start' => now()->subMonths(10)]);
        $encounter2 = Encounter::factory()->create(['period_start' => now()->subMonths(8)]);
        $encounter3 = Encounter::factory()->create(['period_start' => now()->subMonths(6)]);
        $encounter4 = Encounter::factory()->create(['period_start' => now()->subMonths(4)]);
        $encounter5 = Encounter::factory()->create(['period_start' => now()->subMonths(2)]);

        // Call the API endpoint
        $response = $this->get(route('analytics.pasien-per-bulan'));

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the response data
        $response->assertJson([
            'data' => [
                [
                    'month' => $encounter1->period_start->format('Y-m'),
                    'class' => $encounter1->class,
                    'encounter_count' => 1,
                ],
                [
                    'month' => $encounter2->period_start->format('Y-m'),
                    'class' => $encounter2->class,
                    'encounter_count' => 1,
                ],
                [
                    'month' => $encounter3->period_start->format('Y-m'),
                    'class' => $encounter3->class,
                    'encounter_count' => 1,
                ],
                [
                    'month' => $encounter4->period_start->format('Y-m'),
                    'class' => $encounter4->class,
                    'encounter_count' => 1,
                ],
                [
                    'month' => $encounter5->period_start->format('Y-m'),
                    'class' => $encounter5->class,
                    'encounter_count' => 1,
                ],
            ],
        ]);
    }


    public function test_get_patient_age_groups()
    {
        // Create test data
        $babyCount = fake()->numberBetween(1, 10);
        $childCount = fake()->numberBetween(1, 10);
        $teenCount = fake()->numberBetween(1, 10);
        $adultCount = fake()->numberBetween(1, 10);
        $oldCount = fake()->numberBetween(1, 10);

        Patient::factory()->count($babyCount)->create([
            'birth_date' => now()->subYears(1),
        ]);
        Patient::factory()->count($childCount)->create([
            'birth_date' => now()->subYears(5),
        ]);
        Patient::factory()->count($teenCount)->create([
            'birth_date' => now()->subYears(15),
        ]);
        Patient::factory()->count($adultCount)->create([
            'birth_date' => now()->subYears(30),
        ]);
        Patient::factory()->count($oldCount)->create([
            'birth_date' => now()->subYears(70),
        ]);

        // Make the request to the API endpoint
        $response = $this->get(route('analytics.sebaran-usia-pasien'));

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonFragment(['age_group' => 'baby', 'count' => $babyCount]);
        $response->assertJsonFragment(['age_group' => 'child', 'count' => $childCount]);
        $response->assertJsonFragment(['age_group' => 'teen', 'count' => $teenCount]);
        $response->assertJsonFragment(['age_group' => 'adult', 'count' => $adultCount]);
        $response->assertJsonFragment(['age_group' => 'old', 'count' => $oldCount]);
    }
}
