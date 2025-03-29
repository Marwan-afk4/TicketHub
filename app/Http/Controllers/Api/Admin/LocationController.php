<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\City;
use App\Models\Country;
use App\Models\Station;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    use Image;

//country
    public function getCountries(){
        $countries = Country::all();
        foreach ($countries as $country){
            if($country->flag){
                $country->flag = url('storage/'.$country->flag);
            }
        }
        $data =[
            'countries' => $countries
        ];
        return response()->json($data);
    }

    public function addCountry(Request $request){
        $validation = Validator::make(request()->all(),[
            'name' => 'required|string',
            'flag' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $country = Country::create([
            'name' => $request->name,
            'flag' =>$this->storeBase64Image($request->flag , 'admin/country/flags'),
            'status' => $request->status,
        ]);
        return response()->json(['message'=>'Country Created Successfully'],200);
    }

    public function updateCountry(Request $request, $id){
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['errors' => 'Country not found'], 404);
        }

        $updatedData = [
            'name' => $request->name ?? $country->name,
            'status' => $request->status ?? $country->status,
        ];

        if ($request->has('flag')) {
            $updatedData['flag'] = $this->storeBase64Image($request->flag, 'admin/country/flags');
        }

        $country->update($updatedData);

        return response()->json(['message' => 'Country Updated Successfully'], 200);

    }

    public function deleteCountry($id){
        $country = Country::find($id);
        if($country){
            $country->delete();
            return response()->json(['message'=>'Country Deleted Successfully'],200);
        }
    }

//city

    public function getCities(){
        $cities = City::all();
        $data =$cities->map(function($city){
            return [
                'id'=> $city->id,
                'country_id' => $city->country_id,
                'country_name' => $city->country->name ?? null,
                'name'=> $city->name,
                'status' => $city->status
            ];
        });
        return response()->json(['cities'=>$data]);
    }

    public function AddCity(Request $request){
        $validation = Validator::make(request()->all(),[
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $city = City::create([
            'country_id' => $request->country_id,
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return response()->json(['message'=>'City Created Successfully'],200);
    }

    public function updateCity(Request $request, $id){
        $city = City::find($id);
        if($city){
            $city->update([
                'country_id' => $request->country_id ?? $city->country_id,
                'name' => $request->name ?? $city->name,
                'flag'=>$request->flag ?? $city->flag,
                'status' => $request->status ?? $city->status,
            ]);
            return response()->json(['message'=>'City Updated Successfully'],200);
        }
    }

    public function deleteCity($id){
        $city = City::find($id);
        if($city){
            $city->delete();
            return response()->json(['message'=>'City Deleted Successfully'],200);
        }
    }

//zone

    public function getZones(){
        $zones = Zone::all();
        $data =$zones->map(function($zone){
            return [
                'id'=> $zone->id,
                'country_id' => $zone->country_id,
                'country_name' => $zone->country->name ?? null,
                'city_id' => $zone->city_id,
                'city_name' => $zone->city->name ?? null,
                'name' => $zone->name,
                'status' => $zone->status
            ];
        });
        return response()->json(['zones'=>$data]);
    }

    public function addZone(Request $request){
        $validation = Validator::make(request()->all(),[
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $zone = Zone::create([
            'country_id'=> $request->country_id,
            'city_id' => $request->city_id,
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return response()->json(['message'=>'Zone Created Successfully'],200);
    }

    public function updateZone(Request $request, $id){
        $zone = Zone::find($id);
        if($zone){
            $zone->update([
                'country_id' => $request->country_id ?? $zone->country_id,
                'city_id' => $request->city_id ?? $zone->city_id,
                'name' => $request->name ?? $zone->name,
                'status' => $request->status ?? $zone->status,
            ]);
            return response()->json(['message'=>'Zone Updated Successfully'],200);
        }
    }

    public function deleteZone($id){
        $zone = Zone::find($id);
        if($zone){
            $zone->delete();
            return response()->json(['message'=>'Zone Deleted Successfully'],200);
        }
    }

// stations

    public function getStation (){
        $pickup = Station::where('pickup',1)->get();
        $dataPickup =$pickup->map(function($station){
            return [
                'id' => $station->id,
                'name' => $station->name,
                'country_id' => $station->country_id,
                'country_name' => $station->country->name,
                'city_id' => $station->city_id,
                'city_name' => $station->city->name,
                'zone_id' => $station->zone_id,
                'zone_name' => $station->zone->name,
                'pickup'=> $station->pickup,
                'dropoff'=> $station->dropoff,
                'basic_station'=> $station->basic_station,
                'status' => $station->status
            ];
        });

        $dropoff = Station::where('dropoff',1)->get();
        $dataDropoff =$dropoff->map(function($station){
            return [
                'id' => $station->id,
                'name' => $station->name,
                'country_id' => $station->country_id,
                'country_name' => $station->country->name,
                'city_id' => $station->city_id,
                'city_name' => $station->city->name,
                'zone_id' => $station->zone_id,
                'zone_name' => $station->zone->name,
                'pickup'=> $station->pickup,
                'dropoff'=> $station->dropoff,
                'basic_station'=> $station->basic_station,
                'status' => $station->status
            ];
        });
        return response()->json([
            'dropoff'=>$dataDropoff,'pickup'=>$dataPickup]);
    }

    public function addStation(Request $request){
        $validation = Validator::make(request()->all(),[
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string',
            'pickup' => 'required|in:0,1',
            'dropoff' => 'required|in:0,1',
            'basic_station' => 'required|in:0,1',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $station = Station::create([
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'zone_id' => $request->zone_id,
            'name' => $request->name,
            'pickup' => $request->pickup,
            'dropoff' => $request->dropoff,
            'basic_station' => $request->basic_station,
        ]);
        return response()->json(['message'=>'Station Created Successfully'],200);
    }

    public function updateStation(Request $request, $id){
        $station = Station::find($id);
        if($station){
            $station->update([
                'country_id' => $request->country_id ?? $station->country_id,
                'city_id' => $request->city_id ?? $station->city_id,
                'zone_id' => $request->zone_id ?? $station->zone_id,
                'name' => $request->name ?? $station->name,
                'pickup' => $request->pickup ?? $station->pickup,
                'dropoff' => $request->dropoff ?? $station->dropoff,
                'basic_station' => $request->basic_station ?? $station->basic_station,
            ]);
            return response()->json(['message'=>'Station Updated Successfully'],200);
        }
    }

    public function deleteStation($id){
        $station = Station::find($id);
        if($station){
            $station->delete();
            return response()->json(['message'=>'Station Deleted Successfully'],200);
        }
    }

}
