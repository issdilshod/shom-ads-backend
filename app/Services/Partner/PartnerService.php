<?php

namespace App\Services\Partner;

use App\Http\Resources\Partner\PartnerResource;
use App\Models\Partner\Partner;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class PartnerService extends Service{

    public function all()
    {
        $partners = Partner::where('deleted_at', null)
                        ->orderBy('name', 'asc')
                        ->paginate(Config::get('pagination.per_page'));

        return PartnerResource::collection($partners);
    }

    public function get($partnerId)
    {
        $partner = Partner::where('deleted_at', null)
                        ->where('id', $partnerId)
                        ->first();

        if ($partner==null){
            return response()->json(['msg' => 'not found'], 404);
        }
        
        return new PartnerResource($partner);
    }

    public function create($partner)
    {
        $exist = $this->exist($partner);
        if ($exist){ return response()->json(['msg'=> 'conflict'], 409); }

        $partner = Partner::create($partner);

        return new PartnerResource($partner);
    }

    public function update($partner, $partnerId)
    {
        $exist = $this->exist($partner, $partnerId);
        if ($exist){ return response()->json(['msg'=> 'conflict'], 409); }

        $partnerOriginal = Partner::where('deleted_at', null)
                            ->where('id', $partnerId)
                            ->first();

        if ($partnerOriginal==null){
            return response()->json(['msg' => 'not found'], 404);
        }

        $partnerOriginal->update($partner);
        
        return new PartnerResource($partnerOriginal);
    }

    public function delete($partnerId)
    {
        Partner::where('deleted_at', null)
            ->where('id', $partnerId)
            ->update(['deleted_at' => Carbon::now()]);
    }

    public function exist($partner, $partnerId = '')
    {
        $partner = Partner::where('deleted_at', null)
                    ->when(isset($user['name']), function($q) use($partner){
                        $q->where('name', $partner['name']);
                    })
                    ->when($partnerId!='', function ($q) use($partnerId){
                        $q->where('id', '!=', $partnerId);
                    })
                    ->first();
        if ($partner==null){
            return false;
        }
        return true;
    }

    public function validate($partner)
    {
        $partner = $partner->validate([
            'user_id' => 'required',
            'name' => 'required',
            'description' => '',
            'phone' => 'required',
            'address' => 'required',
        ]);

        return $partner;
    }

}