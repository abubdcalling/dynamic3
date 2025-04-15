<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Home;
use App\Models\Possible;
use App\Models\WhyChooseUs;
use App\Models\About;
use App\Models\AboutSec2;
use App\Models\Address;
use App\Models\Banner;
use App\Models\Body1;
use App\Models\Body2;
use App\Models\Contact;
use App\Models\Hero;
use App\Models\Menu;
use App\Models\Navbar;
use App\Models\OurCoreValue;
use App\Models\Service;

class FrontendController extends Controller
{
    public function getAllData()
    {
        $data = [
            'home' => Home::all(),
            'aboutsec2=' => AboutSec2::all(),
            'address' => Address::all(),
            'banner' => Banner::all(),
            'body1'=>Body1::all(),
            'body2'=>Body2::all(),
            'hero' => Hero::all(),
            'navbar' => Navbar::all(), 
            'possible' => Possible::all(),
            'whychooseus' => WhyChooseUs::all(),
            'about' => About::all(),
            'contact' => Contact::all(),
            'menu' => Menu::all(),
            'ourcorevalue' => OurCoreValue::all(),
            'service' => Service::all(),
            'whychooseus' => WhyChooseUs::all(),
        ];

        return response()->json($data);
    }
}
