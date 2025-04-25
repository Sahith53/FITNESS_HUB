<?php

namespace App\Http\Controllers;

use App\Models\Query;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    /**
     * Contact Page
     * @return view
     */
    public function index()
    {
        return view("contact");
    }

    /**
     * Store User Query
     * @return redirect
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|min:2|max:100",
            "phone" => "required|numeric|digits:10",
            "email" => "required|email|min:5|max:100",
            "message" => "required|min:5|max:250"
        ]);

        Query::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "message" => $request->message
        ]);

        return redirect()->route("contact")->with('alert', 'Our team will reach you soon!');
    }
}
