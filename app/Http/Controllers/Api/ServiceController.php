<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class ServiceController extends Controller
{
    public function status()
    {
        return [
            'date' => now()->toString(),
            'headers' => getallheaders()
        ];
    }
}
