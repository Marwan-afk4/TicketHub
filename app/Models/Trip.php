<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{


    protected $fillable = [
        'bus_id',
        'pickup_station_id',
        'station_1',
        'station_2',
        'station_3',
        'station_4',
        'dropoff_station_id',
        'city_id',
        'zone_id',
        'deputre_time',
        'arrival_time',
        'avalible_seats',
        'country_id',
        'to_country_id',
        'to_city_id',
        'to_zone_id',
        'date',
        'price',
        'status',
        'agent_id',
        'max_book_date',
        'type',
        'fixed_date',
        'cancellation_policy',
        'cancelation_pay_amount',
        'cancelation_pay_value'
    ];

    public function bus(){
        return $this->belongsTo(Bus::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function stations(){
        return $this->belongsToMany(Station::class);
    }

    public function pickup_station(){
        return $this->belongsTo(Station::class);
    }

    public function dropoff_station(){
        return $this->belongsTo(Station::class);
    }
}
