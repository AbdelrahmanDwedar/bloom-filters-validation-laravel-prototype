<?php

use App\Models\User;

test('can get list of users', function () {
    $users = User::factory(3)->create();

    $response = $this->getJson('/api/users');

    $response->assertStatus(200)
             ->assertJsonCount(3)
             ->assertJsonStructure([
                 '*' => ['id', 'name', 'email', 'created_at', 'updated_at']
             ]);
});

test('can create a user', function () {
    $userData = User::factory()->raw([
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);

    $response = $this->postJson('/api/users', $userData);

    $response->assertStatus(201)
             ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at']);
});

test('can show a user', function () {
    $user = User::factory()->create();

    $response = $this->getJson("/api/users/{$user->id}");

    $response->assertStatus(200)
             ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at']);
});

test('can update a user', function () {
    $user = User::factory()->create();

    $updateData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com'
    ];

    $response = $this->putJson("/api/users/{$user->id}", $updateData);

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'name' => 'Updated Name',
                 'email' => 'updated@example.com'
             ]);
});

test('can delete a user', function () {
    $user = User::factory()->create();

    $response = $this->deleteJson("/api/users/{$user->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
