<?php
namespace App\Http\Controllers\Debug;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class __CONTROLLER_NAME__
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            //
        ]);

        return response()->json(['success' => true, 'data' => $validated]);
    }
}
