<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobList;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name')->get();
        $list = [];
        foreach ($categories as $key => $category) {
            $list[$key]['id'] = $category['id'];
            $list[$key]['name'] = $category['name'];
            $list[$key]['count'] = JobList::where('category_id', $category['id'])->count(); 
        }
        return view("front.home", compact('list'));
    }

    public function contact()
    {
        return view("front.contact");
    }
}
