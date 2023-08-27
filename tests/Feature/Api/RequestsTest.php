<?php

use App\Models\Request;

it('api requests index', function () {
    $response = $this->get('/api/v1/requests');

    $response->assertStatus(200);
});

it('api requests index with filters', function () {
    $request = Request::factory()->create();

    $response = $this->getJson('/api/v1/requests?page=1&status='.$request->status.'&created_at='.$request->created_at->format('Y-m-d'));

    $data = [
        'status' => 'success',
        'data' => [
            'data' => [
                [
                    'id' => $request->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'message' => $request->message,
                ],
            ],
        ],
    ];

    $response->assertStatus(200)->assertJson($data);
});

it('api requests show', function () {
    $request = Request::factory()->create();

    $response = $this->getJson("/api/v1/requests/{$request->id}");

    $data = [
        'status' => 'success',
        'data' => [
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ],
    ];

    $response->assertStatus(200)->assertJson($data);
});

it('api requests store', function () {
    $attributes = Request::factory()->raw();

    $response = $this->postJson('/api/v1/requests', $attributes);

    $response->assertStatus(200)->assertJson(['status' => 'success']);

    $this->assertDatabaseHas('requests', $attributes);
});

it('api request update', function () {
    $request = Request::factory()->create();
    $updatedRequest = ['name' => 'Updated Name'];
    $response = $this->putJson("/api/v1/requests/{$request->id}", $updatedRequest);

    $response->assertStatus(200)->assertJson(['status' => 'success']);

    $this->assertDatabaseHas('requests', $updatedRequest);
});

it('api request change status', function () {
    $request = Request::factory()->create();
    $updatedRequest = ['status' => 'resolved', 'comment' => 'comment text'];
    $response = $this->putJson("/api/v1/requests/{$request->id}/change-status", $updatedRequest);

    $response->assertStatus(200)->assertJson(['status' => 'success']);
});

it('api request delete', function () {
    $request = Request::factory()->create();
    $response = $this->deleteJson("/api/v1/requests/{$request->id}");
    $response->assertStatus(200)->assertJson(['status' => 'success']);
    $this->assertCount(0, Request::all());
});
