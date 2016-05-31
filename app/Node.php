<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $fillable = [
        'name', 'link', 'api_email', 'api_key', 'total_ram', 'total_cpu', 'total_storage', 'used_ram', 'used_cpu', 'used_storage'
    ];

    public function totalAvailableRam()
    {
        return $this->totalRam() - $this->totalUsedRam();
    }

    public function totalRam()
    {
        return $this->all()->sum('total_ram');
    }

    public function totalUsedRam()
    {
        return $this->all()->sum('used_ram');
    }

    public function totalAvailableCpu()
    {
        return $this->totalCpu() - $this->totalUsedCpu();
    }

    public function totalCpu()
    {
        return $this->all()->sum('total_cpu');
    }

    public function totalUsedCpu()
    {
        return $this->all()->sum('used_cpu');
    }

    public function totalAvailableStorage()
    {
        return $this->totalStorage() - $this->totalUsedStorage();
    }

    public function totalStorage()
    {
        return $this->all()->sum('total_storage');
    }

    public function totalUsedStorage()
    {
        return $this->all()->sum('used_storage');
    }

    public function getNodeRam($node_id)
    {
        return $this->firstOrFail($node_id)->total_ram;
    }

    public function getNodeCpu($node_id)
    {
        return $this->firstOrFail($node_id)->total_cpu;
    }

    public function getNodeStorage($node_id)
    {
        return $this->firstOrFail($node_id)->total_storage;
    }
}
