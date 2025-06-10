<?php

namespace Kartikey\PanelPulse\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Kartikey\PanelPulse\Services\GetCountry;

class AjaxController extends Controller
{
    public function getStateByCountry(Request $request)
    {
        $state = (new GetCountry)->StateList($request->country);
        return (['state' => $state]);
    }
}
