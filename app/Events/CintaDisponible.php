<?php
namespace App\Events;

use App\Models\Cinta;
use Illuminate\Foundation\Events\Dispatchable;

class CintaDisponible
{
    use Dispatchable;
    public function __construct(public Cinta $cinta) {}
}