<?php
namespace App\Traits;

use App\Traits\Responser;
use App\Models\BallContainer;
use Exception;
use Config;

trait BallContainerActivity {
    use Responser;

	protected function getContainer($container_number, $init_quantity=null)
	{
        try {
            $ball_container = BallContainer::where(compact('container_number'))->firstOrFail();
        } catch (Exception $th) {
            $max_ball_container = Config::get('ball_container.container.max_ball');
            
            $quantity = $init_quantity ? $init_quantity : rand(1, $max_ball_container-1);
            $ball_container = BallContainer::create([
                'container_number'  => $container_number,
                'quantity'          => $quantity
            ]);
        }
        
        return $ball_container;
    }

    protected function fullyContainerCheck()
    {
        try {
            $verified_container = BallContainer::where('is_verified', 1)->firstOrFail();

            return true;
        } catch (Exception $th) {
            return false;
        }
    }
    
    protected function putBall($ball_container)
    {
        $max_ball_container = Config::get('ball_container.container.max_ball');

        $quantity = $ball_container->quantity+1;
        $update_data = [
            'quantity'  => $quantity
        ];
        
        if ($quantity == $max_ball_container) {
            $update_data['is_verified'] = 1;
        }

        $ball_container->update($update_data);

        return [
            'container_number'  => $ball_container->container_number,
            'verified'          => $ball_container->is_verified == 1 ? true : false
        ];
    }

    public function clearVerifiedContainer()
    {
        BallContainer::where('is_verified', 1)->delete();
    }
}