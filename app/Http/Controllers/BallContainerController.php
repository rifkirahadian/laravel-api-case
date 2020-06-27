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
        $this->fullyContainerCheck();
        
        $ball_container = $this->getContainer($container_number, $request->init_quantity);
        $container = $this->putBall($ball_container);

        $this->successResponse($container, 'Success');
    }

    
}
