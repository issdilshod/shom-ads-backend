<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Services\Partner\PartnerService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    
    private $partnerService;

    public function __construct()
    {
        $this->partnerService = new PartnerService();
    }

    public function index(Request $request)
    {
        // permission

        $partners = $this->partnerService->all();

        return $partners;
    }

    public function show(Request $request, $partnerId)
    {
        // permission

        $partner = $this->partnerService->get($partnerId);

        return $partner;
    }

    public function store(Request $request)
    {
        // permission

        $partnerValidated = $this->partnerService->validate($request);

        $partner = $this->partnerService->create($partnerValidated);

        return $partner;
    }

    public function update(Request $request, $partnerId)
    {
        // permission

        $partnerValidated = $this->partnerService->validate($request);

        $partner = $this->partnerService->update($partnerValidated, $partnerId);

        return $partner;
    }

    public function destroy($partnerId)
    {
        // permission

        $this->partnerService->delete($partnerId);

        return response()->json(['msg' => 'success'], 200);
    }

}
