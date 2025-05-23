<?php

namespace Tests\Feature;

use App\Models\BsRecord;
use App\Models\Profile;
use App\Models\SugarSchedule;
use App\Models\SugarUnit;
use App\Models\User;
use App\Models\BloodSugar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BloodSugarTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Profile $profile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->profile = Profile::factory()->create([
            'user_id' => $this->user->id,
        ]);

        Passport::actingAs($this->user);
        SugarSchedule::create([
            'name' => 'After Eating',
        ]);
        SugarUnit::create([
            'name' => 'mg/dL',
        ]);
    }

    public function test_user_can_create_blood_sugar_records(): void
    {
        $response = $this->actingAs($this->user)->postJson("/api/v1/{$this->profile->id}/bs-records", [
            'value' => 120,
            'measured_at' => now()->toDateTimeString(),
            'sugar_schedule_id' => 1,
            'sugar_unit_id' => 1,
            'profile_id' => $this->profile->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bs_records', [
            'profile_id' => $this->user->profile->id,
            'value' => 120,
            'measured_at' => now()->toDateTimeString(),
            'sugar_schedule_id' => 1,
            'sugar_unit_id' => 1,
        ]);
    }


    public function test_user_cannot_create_blood_sugar_record_with_invalid_data(): void
    {
        $response = $this->actingAs($this->user)->postJson("/api/v1/{$this->profile->id}/bs-records", [
            'value' => 'invalid',
            'measured_at' => 'invalid-date',
            'sugar_schedule_id' => 999,
            'sugar_unit_id' => 999,
            'profile_id' => $this->profile->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['value', 'measured_at', 'sugar_schedule_id', 'sugar_unit_id']);
    }

    public function test_user_can_delete_blood_sugar_record(): void
    {
        $record = BsRecord::factory()->create([
            'profile_id' => $this->profile->id
        ]);

        $response = $this->actingAs($this->user)->deleteJson("/api/v1/{$this->profile->id}/bs-records/{$record->id}");

        $response->assertOk();
        $this->assertDatabaseMissing('bs_records', ['id' => $record->id]);
    }
}
