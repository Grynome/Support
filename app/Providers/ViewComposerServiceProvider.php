<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\VW_Notif;
use App\Models\User;
use App\Models\VW_Ticket;
use App\Models\WhatNews;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('Theme.header', function ($view) {
            $nik =  auth()->user()->nik;
            $data['val_notif'] = VW_Notif::where('to_nik', $nik)->where('sts_ticket', 9)->first();
            $data['notif'] = VW_Notif::all()->where('to_nik', $nik)->where('sts_ticket', 9);
            $data['unread'] = VW_Notif::where('to_nik', $nik)->where('sts_ticket', 9)
            ->where('see', 0)
            ->count();
            $data['wn_cn'] = WhatNews::where('created_at', '>=', Carbon::now()->addHours(7)->subHours(2))->count();
            $view->with($data);
        });
        View::composer('Theme.Sub.sidebar', function ($view) {
            $data['not_verif'] = User::where('verify', 0)->count();
            $data['not_closed_ticket'] = VW_Ticket::where('status', '<', 10)->count();
            $view->with($data);
        });
    }
}
