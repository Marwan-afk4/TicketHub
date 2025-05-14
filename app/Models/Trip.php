<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Trip extends Model
{
    protected $fillable = [
        'trip_name',
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
        'to_country_id',
        'country_id',
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
        'cancelation_pay_value',
        'min_cost',
        'trip_type',
        'currency_id',
        'cancelation_hours',
        'train_id',
        'start_date',
        'request_status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['image_link'];

    public function gettripTypeAttribute($data){
        if ($data == 'hiace') {
            return 'MiniVan';
        }
        return $data;
    }

    public function getImageLinkAttribute(){
        if (isset($this->attributes['image'])) {
            return url('storage/' . $this->attributes['image']);
        }

        return null;
    }

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function bus(){
        return $this->belongsTo(Bus::class);
    }

    public function train(){
        return $this->belongsTo(Train::class, 'train_id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function to_country(){
        return $this->belongsTo(Country::class, 'to_country_id');
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function to_city(){
        return $this->belongsTo(City::class, 'to_city_id');
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function to_zone(){
        return $this->belongsTo(Zone::class);
    }

    public function stations(){
        return $this->belongsToMany(Station::class);
    }

    public function pickup_station(){
        return $this->belongsTo(Station::class, 'pickup_station_id');
    }

    public function dropoff_station(){
        return $this->belongsTo(Station::class, 'dropoff_station_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function days(){
        return $this->hasMany(TripDays::class, 'trip_id');
    }

    public function fees(){
        return $this->hasMany(ServiceFees::class);
    }
}
