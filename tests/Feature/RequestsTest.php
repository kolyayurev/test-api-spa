<?php

it('requests.index', function () {
    $response = $this->get('/api/requests');

    $response->assertStatus(200);
});
