<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * Class ServiceController
 * @package App\Http\Controllers\Api
 */
class ServiceController extends Controller
{
    /**
     * @return array
     */
    public function status(): array
    {
        return [
            'date' => now()->toString(),
            'headers' => getallheaders()
        ];
    }
}
