<?php
namespace App\Http\Controllers\Debug;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class __CONTROLLER_NAME__
{
    public function __invoke(Request $request): JsonResponse
    {
        // Simple debug response — replace with real logic
        return response()->json(['success' => true, 'message' => '__CONTROLLER_NAME__ active']);
    }
}
