<?php

namespace App\Http\Controllers;


use App\Http\Requests\AlterServerRequested;
use App\Http\Requests\BuildServerRequest;
use App\Http\Requests\ServerRenameRequest;
use App\User;
use Illuminate\Http\Request;
use \hsrtech\catc\Wrapper;
use \App\Server;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psy\Exception\ErrorException;

class ServerController extends Controller
{
    protected $_server,
              $_api;


    public function __construct(Wrapper $api)
    {
        $this->_api = $api;
    }

    public function listServers(Request $request)
    {
        $user = $request->user();
        $data = ['servers' => $user->Servers(), 'user' => $user];
        return view("gentelella.servers.list", $data);
    }


    /**
     * @param BuildServerRequest|Request $request
     * @return static
     */
    public function make(BuildServerRequest $request)
    {
        $param = ['cpu' => $request->input('cpu'),'ram' => $request->input('ram'), 'storage' => $request->input('storage'), 'os' => $request->input('os')];
        if($request->user()->checkResources($param)){
            return response("Not Enough Resources",401);
        }
        $server = ($this->getApiSet()->buildServer($param));
        if($server->status !== 'ok'){
            $log = (array) $server;
            $log['user_id'] = $request->user()->id;
            $log = array_merge($log,$param);
            Log::critical('Server Build Failed',$log);
            return response('Something went wrong. Please try again in a little bit.',504);
        }
        Server::create([
            'cpu' => $param['cpu'],
            'ram' => $param['ram'],
            'storage' => $param['storage'],
            'os' => $param['os'],
            'user_id' => $request->user()->id,
            'sid' => 0,
            'name' => $server->servername,
            'ip' => "0.0.0.0",
        ]);
        $request->user()->update([
            'available_ram' => $request->user()->available_ram - $param['ram'],
            'available_cpu' => $request->user()->available_cpu - $param['cpu'],
            'available_storage' => $request->user()->available_storage - $param['storage'],
        ]);
        return redirect(url('/'));
    }

    public function build(Request $request)
    {
        $data = ['user' => $request->user(), 'templates' => Server::templates()];
        return view('gentelella.servers.build',$data);
    }

    public function changeServerOwner(Request $request,Server $id)
    {
        $data = ['user' => $request->user(),'id' => $id->id,'uid' => $id->user_id,'users' => DB::table('users')->where('role_id','!=',9)->where('role_id','!=',10)->get()];
        return view('gentelella.servers.changeOwner',$data);
    }


    public function changeServerOwnerPost(AlterServerRequested $request, Server $id)
    {
        if(!$id->update(['user_id' => $request->user])){
            return $this->format('Server Transfer Failed.');
        }
        return redirect(action('ServerController@serverView',$id->id));
    }


    public function powerOn(Request $request,Server $id)
    {
        if($this->getApiSet()->powerOnServer($id->sid)->Response()){
            ($id->update(['status' => 'Powered On']));
            return $this->format("Powered On",'Server');
        }return $this->format("API Failed");
    }

    public function reboot(Request $request, Server $id)
    {
        if($this->getApiSet()->rebootServer($id->sid)->Response()){
            $id->update(['status' => 'Powered Off']);
            return $this->format("Reboot",'Server');
        }return $this->format("API Failed");
    }

    public function powerOff(Request $request, Server $id)
    {
        if($this->getApiSet()->powerOffServer($id->sid)->Response()){
            $id->update(['status' => "Powered Off"]);
            return ($this->format("Powered Off",'Server'));
        }return $this->format("API Failed");
    }

    public function delete(Request $request, Server $id)
    {
        if($this->getApiSet()->deleteServer($id->sid)->Response()){
            $id->delete();
            return redirect(route('server::list'));
        }return $this->format("API Failed");
    }

    public function console(Request $request,Server $id)
    {
        return redirect("http://panel.vps-hosting.ca:40181/console.html?servername={$id->name}&hostname=esx1200.cloudatcost.com&sshkey={$id->vnc_port}&sha1hash={$id->vnc_pass}");
    }

    public function rename(ServerRenameRequest $request, Server $id)
    {
        $id->update(['label' => $request->servername]);
        return redirect(action("ServerController@serverView",$id->id));
    }

    public function rdns(ServerRenameRequest $request, Server $id)
    {
        if($this->getApiSet()->setRDNS($id->sid,$request->servername)->Response()){
            $id->update(['rdns' => $request->servername]);
            return redirect(action("ServerController@serverView",$id->id));
        }else return response("Something went wrong.",102);
    }

    public function serverView(Server $id, Request $request)
    {
        $data = [
            'server' => $id,
            'user' => $request->user(),
        ];

        return view('gentelella.servers.display', $data);
    }

    public function addResources(Request $request, User $user = NULL)
    {
        return $user;
        if($user->id)
        {
            return $user;
        }else
        {
                
        }
    }

    public function addResourcesPost(Request $request)
    {
        $user = User::where('id',$request->user_id);
        $u = $user->get();
        $user->update([
            'available_cpu' => $u->available_cpu + $request->cpu,
            'available_ram' => $u->available_ram + $request->ram,
            'available_storage' => $u->available_storage + $request->storage,
        ]);
        return $this->format("Server Updated","Action Status");
    }

    private function format($text = '', $title = 'Server Status', $type = "success")
    {
        return json_encode([
            'title' => $title,
            'text' => $text,
            'type' => $type,
            'styling' => 'bootstrap3',
            'result' => ($type === "success") ? true : false,

        ]);
    }

    /**
     * @return Wrapper
     */
    protected function getApiSet()
    {
        return $this->_api;
    }

}
