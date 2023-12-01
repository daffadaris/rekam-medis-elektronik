<?php

namespace Tests\Feature\Fhir;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\FhirTestCase;
use Tests\Traits\FhirTest;

class ObservationDataTest extends FhirTestCase
{
    use DatabaseTransactions;
    use FhirTest;

    /**
     * Test apakah user dapat menlihat data observasi
     */
    public function test_users_can_view_observation_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getExampleData('observation');

        $headers = ['Content-Type' => 'application/json'];
        $response = $this->json('POST', route('observation.store'), $data, $headers);
        $newData = json_decode($response->getContent(), true);

        $response = $this->json('GET', route('resource.show', ['res_type' => 'observation', 'res_id' => $newData['resource_id']]));
        $response->assertStatus(200);
    }


    /**
     * Test apakah user dapat membuat data observasi baru
     */
    public function test_users_can_create_new_observation_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getExampleData('observation');
        $headers = ['Content-Type' => 'application/json'];
        $response = $this->json('POST', route('observation.store'), $data, $headers);
        $response->assertStatus(201);

        $this->assertMainData('observation', $data['observation']);
        $this->assertManyData('observation_based_on', $data['basedOn']);
        $this->assertManyData('observation_part_of', $data['partOf']);
        $this->assertManyData('observation_category', $data['category']);
        $this->assertManyData('observation_focus', $data['focus']);
        $this->assertManyData('observation_performer', $data['performer']);
        $this->assertManyData('observation_interpretation', $data['interpretation']);
        $this->assertManyData('observation_note', $data['note']);
        $this->assertManyData('observation_ref_range', $data['referenceRange']);
        $this->assertManyData('observation_member', $data['member']);
        $this->assertManyData('observation_derived_from', $data['derivedFrom']);
        $this->assertNestedData('observation_component', $data['component'], 'component_data', [
            [
                'table' => 'obs_comp_interpret',
                'data' => 'interpretation'
            ],
            [
                'table' => 'obs_comp_ref_range',
                'data' => 'referenceRange'
            ]
        ]);
        $orgId = env('organization_id');
        $this->assertDatabaseHas('observation_identifier', ['system' => 'http://sys-ids.kemkes.go.id/observation/' . $orgId, 'use' => 'official']);
    }


    /**
     * Test apakah user dapat memperbarui data observasi
     */
    public function test_users_can_update_observation_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getExampleData('observation');
        $headers = ['Content-Type' => 'application/json'];
        $response = $this->json('POST', route('observation.store'), $data, $headers);
        $newData = json_decode($response->getContent(), true);

        $data['observation']['id'] = $newData['id'];
        $data['observation']['resource_id'] = $newData['resource_id'];
        $data['observation']['subject'] = 'Patient/10001';

        $response = $this->json('PUT', route('observation.update', ['res_id' => $newData['resource_id']]), $data, $headers);
        $response->assertStatus(200);

        $this->assertMainData('observation', $data['observation']);
        $this->assertManyData('observation_based_on', $data['basedOn']);
        $this->assertManyData('observation_part_of', $data['partOf']);
        $this->assertManyData('observation_category', $data['category']);
        $this->assertManyData('observation_focus', $data['focus']);
        $this->assertManyData('observation_performer', $data['performer']);
        $this->assertManyData('observation_interpretation', $data['interpretation']);
        $this->assertManyData('observation_note', $data['note']);
        $this->assertManyData('observation_ref_range', $data['referenceRange']);
        $this->assertManyData('observation_member', $data['member']);
        $this->assertManyData('observation_derived_from', $data['derivedFrom']);
        $this->assertNestedData('observation_component', $data['component'], 'component_data', [
            [
                'table' => 'obs_comp_interpret',
                'data' => 'interpretation'
            ],
            [
                'table' => 'obs_comp_ref_range',
                'data' => 'referenceRange'
            ]
        ]);
        $orgId = env('organization_id');
        $this->assertDatabaseHas('observation_identifier', ['system' => 'http://sys-ids.kemkes.go.id/observation/' . $orgId, 'use' => 'official']);
    }
}
