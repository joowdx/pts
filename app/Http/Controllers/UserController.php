<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
class UserController extends Controller
{
  public static function index()
  {
    return User::where('id', '!=', '1')->get();
  }

  public function create()
  {
    return abort(404);
  }

  public function store(Request $request)
  {
    $request->validate([
      'type' => 'required|in:admin,moderator,general',
      'icon' => 'nullable|mimes:png,jpg,jpeg|max:2048',
      'name' => 'required|string|min:3|max:30',
      'description' => 'nullable|string|max:60',
      'sex' => 'required|in:male,female',
      'username' => 'required|string|alpha_dash|min:6|max:12|unique:users',
      'email' => 'required|string|email|max:60|unique:users',
      'password' => 'required|string|min:8|confirmed',
    ]);
    $data = $request->toArray();
    $data['name'] = ucwords($data['name']);
    $data['sex'] = strtolower($data['sex']);
    $data['username'] = strtolower($data['username']);
    $data['email'] = strtolower($data['email']);
    $data['password'] = Hash::make($data['password']);
    $data['added_by'] = Auth()->user()->id;
    unset($data['icon']);
    $user = new User($data);
    $user->save();
    if($request->hasFile('icon')){
      $fn = str_pad($user->id,5,'0',STR_PAD_LEFT).'-'.time().'.'.$request->file('icon')->getClientOriginalExtension();
      $request->file('icon')->storeAs('/public/img/user/avatars/', $fn);
      $user->icon = '/storage/img/user/avatars/'.$fn;
    } else {
      $user->icon = '/storage/img/user/avatars/00000-000000000'.substr($data['sex'], 0, 1).'.png';
    }
    $user->save();
  }

  public function show($id)
  {
  }

  public function edit($id)
  {
  }

  public function update(Request $request, $id)
  {
  }

  public function destroy($id)
  {
  }
}
