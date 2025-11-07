<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_index()
    {
        $this->get(route('contacts.index'))->assertRedirect(route('login'));
    }

    public function test_user_sees_only_his_own_contacts()
    {
        $me = User::factory()->create();
        $other = User::factory()->create();

        $mine = Contact::factory()->count(2)->create(['user_id' => $me->id]);
        $others = Contact::factory()->count(2)->create(['user_id' => $other->id]);

        $this->actingAs($me);
        $response = $this->get(route('contacts.index'))->assertOk();

        foreach ($mine as $c) {
            $response->assertSee($c->name);
        }
        foreach ($others as $c) {
            $response->assertDontSee($c->name);
        }
    }
}
