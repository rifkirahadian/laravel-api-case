<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Traits\BallContainerActivity;
use Config;

class PuttBallToContainerTest extends TestCase
{
    use BallContainerActivity;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccess()
    {
        $this->clearVerifiedContainer();
        $response = $this->post('/api/container/put-ball');

        $response->assertStatus(200);
    }

    public function testFull()
    {
        $container_number =  rand();
        
        $max_ball_container = Config::get('ball_container.container.max_ball');
        $ball_container = $this->getContainer($container_number, $max_ball_container-1);
        $this->putBall($ball_container);

        $response = $this->post('/api/container/put-ball');

        $response->assertStatus(400);
        $this->clearVerifiedContainer();
    }
}
