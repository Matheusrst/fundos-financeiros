<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithBroadcasting;

class AssetPriceUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    public $asset;

    public function __construct($asset)
    {
        $this->asset = $asset;
    }

    public function broadcastOn()
    {
        return new Channel('asset-price-updated');
    }

    public function broadcastWith()
    {
        return[
            'asset' => $this->asset->id,
            'price' => $this->asset->price,
            'asset_type' => $this->asset instanceof \App\Models\Stock ? 'stock' : 'fund', 
        ];
    }
}