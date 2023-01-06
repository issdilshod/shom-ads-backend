<?php

namespace App\Http\Controllers\Ad;

use App\Http\Controllers\Controller;
use App\Services\Ad\AdService;
use Illuminate\Http\Request;

class AdController extends Controller
{

    private $adService;

    public function __construct()
    {
        $this->adService = new AdService();
    }
    
    public function index(Request $request)
    {
        // permission

        $ads = $this->adService->all();

        return $ads;
    }

    public function show(Request $request, $adId)
    {
        // permission

        $ad = $this->adService->get($adId);

        return $ad;
    }

    public function store(Request $request)
    {
        // permission

        $adValidated = $this->adService->validate($request);

        $ad = $this->adService->create($adValidated);

        return $ad;
    }

    public function update(Request $request, $adId)
    {
        // permission

        $adValidated = $this->adService->validate($request);

        $ad = $this->adService->update($adValidated, $adId);

        return $ad;
    }

    public function delete(Request $request, $adId)
    {
        // permission

        $this->adService->delete($adId);

        return response()->json(['msg' => 'success'], 200);
    }

}
