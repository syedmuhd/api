<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseHelper
{
    public function responseOk(array $data)
    {
        return response()->json($data, Response::HTTP_OK);
    }
}
