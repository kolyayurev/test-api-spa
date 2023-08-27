<?php

use App\Models\Request;
use App\Repositories\RequestRepository;

it('RequestRepository getByFilters', function () {

    Request::factory()->count(5)->create();

    $filters = ['status' => 'active'];
    $result = (new RequestRepository)->getByFilters($filters);

    expect($result->count())->toBe(5);
});

it('RequestRepository find', function () {

    $request = Request::factory()->create();

    $result = (new RequestRepository)->find($request->id);

    expect($result->name)->toBe($request->name)
        ->and($result->email)->toBe($request->email)
        ->and($result->message)->toBe($request->message);
});
