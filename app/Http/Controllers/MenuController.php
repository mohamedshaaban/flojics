<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function whayWaraMenus()
    {
        $menus = Menu::where('status', '1')
                        ->where('in_why_wara','1')
                        ->orderBy('order', 'asc')
                        ->get();
        return $menus;
    }

    public function headerMenus()
    {
        $menus = Menu::where('status', '1')
                        ->where('in_header','1')
                        ->orderBy('order', 'asc')
                        ->get();
        return $menus;
    }

    public function footerMenus()
    {
        $menus = Menu::where('status', '1')
                        ->where('in_footer','1')
                        ->orderBy('order', 'asc')
                        ->get();
        return $menus;
    }
}
