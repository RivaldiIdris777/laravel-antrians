<?php

namespace App\Events;

use App\Models\Antrian;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianDipanggil implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $antrian;

    public function __construct(Antrian $antrian)
    {
        $this->antrian = $antrian;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('antrian-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'antrian.dipanggil';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->antrian->id,
            'nomor_antrian' => $this->antrian->nomor_antrian,
            'layanan' => $this->antrian->layanan->nama_layanan ?? '',
            'suara_panggilan' => $this->antrian->layanan->suara_panggilan ?? '',
            'loket' => $this->antrian->loket->nama_loket ?? '',
            'loket_id' => $this->antrian->loket_id,
        ];
    }
}