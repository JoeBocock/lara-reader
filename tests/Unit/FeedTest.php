<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A valid RSS feed can be stored.
     *
     * @test
     * @return void
     */
    public function it_can_be_stored()
    {
        $response = $this->postJson('/api/feed', [
            'url' => 'https://feeds.npr.org/510312/podcast.xml',
        ]);

        $response->assertStatus(201);
    }

    /**
     * A normal url cannot be stored.
     *
     * @test
     * @return void
     */
    public function normal_links_are_rejected()
    {
        $response = $this->postJson('/api/feed', [
            'url' => 'https://www.google.com',
        ]);

        $response->assertStatus(422);
    }

    /**
     * Random data cannot be stored.
     *
     * @test
     * @return void
     */
    public function invalid_data_is_rejected()
    {
        $response = $this->postJson('/api/feed', [
            'url' => 'This is not an RSS Feed!',
        ]);

        $response->assertStatus(422);
    }
}
