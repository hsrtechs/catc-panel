<?php

namespace App\Console\Commands;

use App\Server;
use hsrtech\catc\Wrapper;
use Illuminate\Console\Command;

class GetServersFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:getServers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the Servers from the API.';

    protected $table;

    protected $wrapper;

    /**
     * Create a new command instance.
     * @param Wrapper $wrapper
     */
    public function __construct(Wrapper $wrapper)
    {
        parent::__construct();

        $this->wrapper = $wrapper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $servers = $this->wrapper->getServers()->result();
        $updated_servers = 0;
        $new_servers = 0;
        $server_list = "( Sid: ";
        foreach ($servers as $server)
        {
            $s = Server::where('sid',$server->sid);


            if($s->count())
            {
                $status = [-1 => 'Installing', 0 => "Powered Off", 1 => "Powered On"];
                $server->status = array_flip($status)[$server->status];

                $server->mode = ($server->mode === 'Normal') ? 1 : 0;

              $data = $s->first();

                $cpu = is_array($data->used_cpu) ? $data->used_cpu : [];
                $ram = is_array($data->used_ram) ? $data->used_ram : [];
                $storage = is_array($data->used_storage) ? $data->used_storage : [];

                if(count($cpu) >= 10)
                {
                    unset($cpu[0]);
                    $cpu = array_values($cpu);
                }
                if(count($ram) >= 10)
                {
                    unset($ram[0]);
                    $ram = array_values($ram);
                }
                if(count($storage) >= 10){
                    unset($storage[0]);
                    $storage = array_values($storage);
                }

                array_push($cpu,number_format($server->cpuusage*100/(2000*$server->cpu),2));
                array_push($ram,number_format($server->ramusage*100/$server->ram,2));
                array_push($storage,number_format($server->hdusage*100/$server->storage,2));

                ($s->update([
                    'rdns' => $server->rdns,
                    'used_cpu' => json_encode($cpu),
                    'used_ram' => json_encode($ram),
                    'used_storage' => json_encode($storage),
                    'status' => $server->status,
                ]));

                $updated_servers++;
            }elseif(Server::where('name',$server->vmname)->count())
            {
                $status = [-1 => 'Installing', 0 => "Powered Off", 1 => "Powered On"];
                $server->status = array_flip($status)[$server->status];

                $server->mode = ($server->mode === 'Normal') ? 1 : 0;

                $data = Server::templates();
                $server->template = array_flip($data)[$server->template];

                ($s->update([
                    'sid' => $server->sid,
                    'ip' => ip2long($server->ip),
                    'os' => $server->template,
                    'cpu' => $server->cpu,
                    'ram' => $server->ram,
                    'storage' => $server->storage,
                    'used_cpu' => json_encode([ number_format($server->cpuusage*100/(2000*$server->cpu),2) ]),
                    'used_ram' => json_encode([ number_format($server->ramusage*100/$server->ram,2) ]),
                    'used_storage' => json_encode([ number_format($server->hdusage*100/$server->storage,2) ]),
                    'label' => $server->lable,
                    'rdns' => $server->hostname,
                    'status' => $server->status,
                    'root_pass' => $server->rootpass,
                    'vnc_port' => $server->vncport,
                    'vnc_pass' => $server->vncpass,
                    'mode' => $server->mode,
                    'desc' => '',
                ]));
            }else
            {
                Server::create([
                    'user_id' => 0,
                    'sid' => $server->sid,
                    'ip' => ($server->ip),
                    'os' => $server->template,
                    'cpu' => $server->cpu,
                    'ram' => $server->ram,
                    'storage' => $server->storage,
                    'used_cpu' => ([ number_format($server->cpuusage*100/2000*$server->cpu,2) ]),
                    'used_ram' => ([ number_format($server->ramusage*100/$server->ram,2) ]),
                    'used_storage' => ([ number_format($server->hdusage*100/$server->storage,2) ]),
                    'label' => $server->lable,
                    'rdns' => $server->hostname,
                    'status' => $server->status,
                    'root_pass' => $server->rootpass,
                    'vnc_port' => $server->vncport,
                    'vnc_pass' => $server->vncpass,
                    'mode' => $server->mode,
                    'desc' => '',
                    'name' => $server->vmname,
                ]);
                $new_servers++;
                $server_list .= $server->sid.', ';
                \Log::critical('New Server created without any user',['sid' => $server->sid]);
            }
        }
        $server_list = ($new_servers > 0) ? substr($server_list,0,strlen($server_list)-2).' )': '';

        $this->info('Total Servers Updated: '. $updated_servers . "\n" . 'Total New Servers Created: ' . $new_servers.$server_list);
    }
}
