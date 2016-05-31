<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use App\Log;
use Faker\Factory;
use \hsrtech\catc\Wrapper;
use \App\Server;
use Illuminate\Support\Facades\Auth;

class ServerController extends Controller
{
    protected $_server,
        $_api;


    public function __construct(Wrapper $api)
    {
        $this->middleware(['auth']);
        $this->_api = $api;

    }

    public function listServers(Request $request)
    {
        $user = $request->user();
        $data = ['servers' => $user->getUserServers(), 'user' => $user];
        return view("gentelella.servers.list", $data);
    }

    public function create(Request $data)
    {
        $params = [
            'cpu' => $data['cpu'],
            'ram' => $data['ram'],
            'storage' => $data['storage'],
            'os' => $data['os'],
        ];
        $task = $this->getApiSet()->buildServer($params);
        if ($task->status === 'ok') {
            $data['sid'] = $task->data->sid;
            Server::create($data);
        }
        $params = [
            'name' => 'Reboot Server',
            'desc' => 'Creating a server.',
            'data' => $task,
            'action_code' => 2701,
            'status' => $task->status,
            'type' => 2,
        ];
        Log::make($params);

    }

    /**
     * @return Wrapper
     */
    protected function getApiSet()
    {
        return $this->_api;
    }

    public function make()
    {
        $faker = Factory::create();

        return Server::create([
            'cpu' => 1,
            'ram' => 1024,
            'storage' => 100,
            'os' => $faker->randomNumber(2, true),
            'ip' => ip2long($faker->ipv4),
            'user_id' => 1,
            'sid' => $faker->randomNumber(6, true),
            'used_ram' => $this->randomVales(10),
            'used_cpu' => $this->randomVales(10),
            'used_storage' => $this->randomVales(10),
            'root_pass' => $faker->password,
            'rdns' => $faker->domainName,
            'label' => $faker->userName,
            'vnc_port' => $faker->randomNumber(4, true),
            'vnc_pass' => $faker->password,
            'status' => 1,
            'mode' => 1,
            'desc' => $faker->realText()
        ]);
    }

    private function randomVales($num)
    {
        $i = 1;
        $str = array();
        while ($i <= $num) {
            $str[] = rand(0, 100);
            $i++;
        }
        return json_encode($str);
    }

    public function serverView(Server $id, Request $request)
    {
        $data = [
            'server' => $id,
            'user' => $request->user(),
        ];

        return view('gentelella.servers.display', $data);
    }

}
