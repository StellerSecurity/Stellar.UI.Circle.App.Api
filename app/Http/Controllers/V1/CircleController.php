<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\WipeService;
use App\WipedBy;
use App\WipeStatus;
use Illuminate\Http\Request;

class CircleController extends Controller
{

    private WipeService $wipeService;

    public function __construct(WipeService $wipeService)
    {
        $this->wipeService = $wipeService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateToWiped(Request $request) {
        $wipe_token = $request->input('wipe_token');

        if($wipe_token === null) {
            return response()->json(['response_code' => 400, 'message' => 'No Token Provided.']);
        }

        $wipe = $this->wipeService->findbytoken($request->input('wipe_token'))->object();

        if($wipe === null) {
            return response()->json(['response_code' => 400, 'message' => 'Token Not Found']);
        }

        $patch = $this->wipeService->patch([
            'id' => $wipe->id,
            'status' => WipeStatus::WIPED->value,
            'wiped_by' => WipedBy::CIRCLE->value
        ])->object();

        return response()->json($patch);

    }


    public function add(Request $request): \Illuminate\Http\JsonResponse
    {

        $wipe_token = $request->input('wipe_token');

        if($wipe_token === null) {
            return response()->json(['response_code' => 400, 'message' => 'No Token Provided.']);
        }

        $wipe = $this->wipeService->findbytoken($wipe_token)->object();

        if(!isset($wipe->id)) {
            return response()->json(['response_code' => 400, 'message' => 'Token Not Found']);
        }

        return response()->json(['response_code' => 200]);
    }

}
