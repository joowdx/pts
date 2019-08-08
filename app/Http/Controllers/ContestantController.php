<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contestant;

class ContestantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contestant::all();
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
    public function store(Request $request) {
      if($request->has('generate')) {
        if($request->input('generate_count') == null || $request->input('generate_count') == 0) {
          return redirect()->back();
        }
        $count = $this->fixnumber();
        for($i = 1; $i <= $request->input('generate_count'); $i++) {
          factory(Contestant::class, $request->input('generate'))->create()->update(['number' => $i + $count]);
        }
        return redirect()->back();
      }
      $request->validate([
        'category_id' => 'nullable|array|min:1',
        'name' => 'required|string',
        'number' => 'required|string|numeric',
      ]);
      $new = Contestant::create($request->except('category_id'));
      $new->categories()->sync($request->input('category_id'));
      $this->fixnumber();
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
      $request->validate([
        'category_id' => 'nullable|string|min:1',
        'name' => 'required|string',
        'number' => 'required|string|numeric',
      ]);
      $update = Contestant::find($id);
      $update->update($request->all());
      $update->category_id = $request->input('category_id');
      $update->save();
      $this->fixnumber();
      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contestant::find($id)->delete();
        $this->fixnumber();
        return redirect()->back();
    }

    private function fixnumber() {
      foreach (\App\Category::all()->sortBy('number') as $category) {
        $count = 0;
        foreach($category->contestants as $contestant) {
          $contestant->update(['number' => ++$count]);
        }
      }
      return $count;
    }
}
