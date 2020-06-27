<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BallContainer;
use App\Traits\BallContainerActivity;

class BallContainerController extends Controller
{
    use BallContainerActivity;
    public function putBallToContainer(Request $request)
    {
        $container_number =  rand();
        
        $ball_container = $this->getContainer($container_number, $request->init_quantity);
        $this->fullyContainerCheck($ball_container);
        $container = $this->putBall($ball_container);

        return $this->successResponse($container, 'Success');
    }

    
}
