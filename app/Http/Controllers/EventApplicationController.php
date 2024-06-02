<?php

namespace App\Http\Controllers;

class EventApplicationController extends Controller
{
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('EventApplicationForm');
    }
}
