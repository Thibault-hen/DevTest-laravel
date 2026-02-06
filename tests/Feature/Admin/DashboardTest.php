<?php

declare(strict_types=1);

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('admin.dashboard'));
    $response->assertRedirect(route('login'));
});

test('non-admin users get forbidden access', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('admin.dashboard'));
    $response->assertForbidden();
});

test('authenticated users with admin role can visit the dashboard', function () {
    $user = User::factory()->setAdmin()->create();
    $this->actingAs($user);

    $response = $this->get(route('admin.dashboard'));
    $response->assertStatus(200);
});
