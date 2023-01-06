<?php

namespace App\Services\Ad;

use App\Http\Resources\Ad\AdResource;
use App\Models\Ad\Ad;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class AdService extends Service{

    public function all()
    {
        $ads = Ad::where('deleted_at', null)
                ->orderBy('created', 'desc')
                ->paginate(Config::get('pagination.per_page'));

        return AdResource::collection($ads);
    }

    public function get($adId)
    {
        $ad = Ad::where('deleted_at', null)
                ->where('id', $adId)
                ->first();

        if ($ad==null){
            return response()->json(['msg' => 'not found'], 404);
        }
        
        return new AdResource($ad);
    }

    public function create($ad)
    {
        //$exist = $this->exist($ad);
        //if ($exist){ return response()->json(['msg'=> 'conflict'], 409); }

        $ad = Ad::create($ad);

        return new AdResource($ad);
    }

    public function update($ad, $adId)
    {
        //$exist = $this->exist($ad, $adId);
        //if ($exist){ return response()->json(['msg'=> 'conflict'], 409); }

        $adOriginal = Ad::where('deleted_at', null)
                            ->where('id', $adId)
                            ->first();

        if ($adOriginal==null){
            return response()->json(['msg' => 'not found'], 404);
        }

        $adOriginal->update($ad);
        
        return new AdResource($adOriginal);
    }

    public function delete($adId)
    {
        Ad::where('deleted_at', null)
            ->where('id', $adId)
            ->update(['deleted_at' => Carbon::now()]);
    }

    // TODO: Need to realize
    public function exist($ad, $adId = '')
    {
        
        $ad = Ad::where('deleted_at', null)
                    ->when($adId!='', function ($q) use($adId){
                        $q->where('id', '!=', $adId);
                    })
                    ->first();
        if ($ad==null){
            return false;
        }
        return true;
    }

    public function validate($ad)
    {
        $ad = $ad->validate([
            'partner_id' => 'required',
            'category_id' => 'required',
            'text' => 'required',
            'phone1' => 'required',
            'phone2' => '',
            'day' => 'required',
            'bonus' => '',
            'price' => '',
        ]);

        return $ad;
    }

}