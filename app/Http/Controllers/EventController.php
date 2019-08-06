<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Event::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->has('delete')) {
        Event::find($request->input('active'))->categories()->delete();
        Event::find($request->input('active'))->delete();
        return redirect()->back();
      }
      if($request->input('advanced_option') == 'on') {
        if($request->input('set_active') != null) {
          \DB::table('events')->update(['active' => 0]);
          if($request->input('set_active') == '0') {
          return redirect()->back();
          }
          Event::find($request->input('set_active'))->update(['active' => 1]);
        }
        return redirect()->back();
      }
      if($request->input('active') != null) {
        $request->validate([
          'name' => 'required|string|min:3|unique:events,name,'.$request->input('active'),
          'scoring' => 'required|string|numeric|in:1,2,3',
        ]);
        Event::find($request->input('set_active'))->update($request->all());
        return redirect()->back();
      }
      $request->validate([
        'name' => 'required|string|min:3|unique:events',
        'scoring' => 'required|string|numeric|in:1,2,3',
      ]);
      Event::create($request->all());
      return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Event::find($id)->delete();
      return redirect()->back();
    }
}
