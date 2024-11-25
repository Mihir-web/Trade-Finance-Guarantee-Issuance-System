<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\inventory;
use App\Models\testimonials;
use App\Models\happy_clients;
use Session;

class FrontController extends Controller
{
    public function index()
    {
        $inventory = inventory::where('is_active',1)->orderBy('created_at','asc')->where('is_delete',0)->get();
        $testimonials = testimonials::where('is_active',1)->orderBy('created_at','asc')->where('is_delete',0)->get();
        $happy_clients = happy_clients::where('is_active',1)->orderBy('display_order','asc')->where('is_delete',0)->get();
        return view('welcome',compact('inventory','testimonials','happy_clients'));
    }
}
