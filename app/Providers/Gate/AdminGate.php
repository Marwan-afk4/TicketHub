<?php

namespace App\Providers\gates;
use Illuminate\Support\Facades\Gate;

class AdminGates
{
    public static function defineGates()
    {
        // ____________________ User ___________________________________________________
        Gate::define('admin_user_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'User')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_user_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'User')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_user_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'User')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_user_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'User')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_user_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'User')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin ___________________________________________________
        Gate::define('admin_admin_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ wallet_request ___________________________________________________
        Gate::define('admin_wallet_request_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'wallet_request')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_wallet_request_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'wallet_request')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_wallet_request_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'wallet_request')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_wallet_request_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'wallet_request')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_wallet_request_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'wallet_request')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ user_request ___________________________________________________
        Gate::define('admin_user_request_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'user_request')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_user_request_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'user_request')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_user_request_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'user_request')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_user_request_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'user_request')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_user_request_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'user_request')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ point ___________________________________________________
        Gate::define('admin_point_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'point')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_point_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'point')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_point_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'point')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_point_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'point')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_point_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'point')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ currency_point ___________________________________________________
        Gate::define('admin_currency_point_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'currency_point')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_currency_point_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'currency_point')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_currency_point_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'currency_point')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_currency_point_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'currency_point')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_currency_point_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'currency_point')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ countries ___________________________________________________
        Gate::define('admin_countries_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'countries')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_countries_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'countries')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_countries_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'countries')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_countries_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'countries')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_countries_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'countries')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ cities ___________________________________________________
        Gate::define('admin_cities_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'cities')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_cities_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'cities')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_cities_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'cities')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_cities_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'cities')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_cities_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'cities')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ zones ___________________________________________________
        Gate::define('admin_zones_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'zones')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_zones_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'zones')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_zones_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'zones')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_zones_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'zones')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_zones_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'zones')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ stations ___________________________________________________
        Gate::define('admin_stations_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'stations')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_stations_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'stations')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_stations_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'stations')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_stations_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'stations')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_stations_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'stations')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ hiaces ___________________________________________________
        Gate::define('admin_hiaces_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'hiaces')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_hiaces_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'hiaces')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_hiaces_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'hiaces')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_hiaces_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'hiaces')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_hiaces_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'hiaces')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // , , , , , , , payment_methods,
        // complaints, complaint_subjects, currencies, nationalities, operators, booking
        // pending_payments, aminites, trip_request, private_request, trips, car_categories,
        // car_brands, car_models, cars, trainTypes, trainclasses, trainRoutes, trains,
        // Commission, operator_payment_methods, payoutRequest, fees, 
        // ____________________ bus_types ___________________________________________________
        Gate::define('admin_bus_types_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'bus_types')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_bus_types_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'bus_types')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_bus_types_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'bus_types')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_bus_types_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'bus_types')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_bus_types_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'bus_types')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
        // ____________________ admin_role ___________________________________________________
        Gate::define('admin_admin_role_view', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'view'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_status', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'status'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_add', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'add'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_edit', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'edit'])->first())) {
                return true;
            }
            return false;
        });
        Gate::define('admin_admin_role_delete', function ($user) {
            if ($user->position && !empty($user->position->roles->where('module', 'admin_role')->whereIn('action', ['all', 'delete'])->first())) {
                return true;
            }
            return false;
        });
    }
}
