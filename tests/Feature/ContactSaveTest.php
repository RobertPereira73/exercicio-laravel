<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactSaveTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an unauthenticated user cannot save a contact.
     */
    public function test_unauthenticated_user_cannot_save_contact()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
        $contactData = [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'contact' => '123456789',
        ];

        $response = $this->post(route('contacts.save'), $contactData);

        $response->assertRedirect(route('login.index'));
    }

    /**
     * Test that an authenticated user can save a new contact.
     */
    public function test_authenticated_user_can_save_new_contact()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
        $user = User::factory()->create();
        $this->actingAs($user);

        $contactData = [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'contact' => '123456789',
        ];

        $response = $this->post(route('contacts.save'), $contactData);

        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('success', 'Contato salvo com sucesso!');

        $this->assertDatabaseHas('contacts', $contactData);
    }

    /**
     * Test that an authenticated user can update an existing contact.
     */
    public function test_authenticated_user_can_update_existing_contact()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::factory()->create([
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'contact' => '123456789',
        ]);

        $updatedData = [
            'id' => $contact->id,
            'name' => 'João Silva Atualizado',
            'email' => 'joao@example.com',
            'contact' => '123456789',
        ];

        $response = $this->post(route('contacts.save'), $updatedData);

        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('success', 'Contato salvo com sucesso!');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'João Silva Atualizado',
            'email' => 'joao@example.com',
            'contact' => '123456789',
        ]);
    }

    /**
     * Test validation errors for invalid data.
     */
    public function test_validation_errors_for_invalid_data()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = [
            'name' => 'Jo', // Too short
            'email' => 'invalid-email',
            'contact' => '123', // Too short
        ];

        $response = $this->post(route('contacts.save'), $invalidData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['name', 'email', 'contact']);
    }

    /**
     * Test that email must be unique.
     */
    public function test_email_must_be_unique()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
        $user = User::factory()->create();
        $this->actingAs($user);

        Contact::factory()->create(['email' => 'joao@example.com']);

        $contactData = [
            'name' => 'João Silva',
            'email' => 'joao@example.com', // Duplicate
            'contact' => '123456789',
        ];

        $response = $this->post(route('contacts.save'), $contactData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test that contact must be unique.
     */
    public function test_contact_must_be_unique()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
        $user = User::factory()->create();
        $this->actingAs($user);

        Contact::factory()->create(['contact' => '123456789']);

        $contactData = [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'contact' => '123456789', // Duplicate
        ];

        $response = $this->post(route('contacts.save'), $contactData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('contact');
    }
}