<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * Class ServiceController
 * @package App\Http\Controllers\Api
 */
class ServiceController extends Controller
{
    /**
     * @return array
     */
    public function status()
    {
        return [
            'date' => now()->toString(),
            'headers' => getallheaders()
        ];
    }
}
