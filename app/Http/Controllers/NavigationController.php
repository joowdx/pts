<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use TheSeer\Tokenizer\Exception;

class NavigationController extends Controller
{

  private static $url;
  private static $crumbs;

  public static function sidemenu() {
    return json_decode(
      json_encode(
        [
          [
            'url' => url('/dashboard'),
            'icon' => 'far fa-analytics',
            'label' => 'Dashboard',
          ],
          [
            'url' => url('/events'),
            'icon' => 'far fa-star',
            'label' => 'Events',
          ],
          [
            'url' => url('/judges'),
            'icon' => 'far fa-gavel',
            'label' => 'Judges',
          ],
          [
            'url' => url('/contestants'),
            'icon' => 'far fa-hashtag',
            'label' => 'Contestants',
          ],
          [
            'url' => url('/evaluation'),
            'icon' => 'far fa-badge-percent',
            'label' => 'Evaluation',
          ],
          [
            'url' => url('/users'),
            'icon' => 'far fa-users-cog',
            'label' => 'Users',
          ],
          [
            'url' => url('/settings'),
            'icon' => 'far fa-cogs',
            'label' => 'Settings',
          ],
          [
            'url' => url('/about'),
            'icon' => 'far fa-info-circle',
            'label' => 'About',
          ],
        ]
      )
    );
  }

  public static function url() {
    return NavigationController::$url;
  }

  public static function crumbs() {
    return NavigationController::$crumbs;
  }

  public static function set($tab = null, $crumbs = []) {
    NavigationController::$url = ucfirst($tab);
    NavigationController::$crumbs = json_decode(json_encode($crumbs ? [$crumbs] : []));
  }

  public function index() {
    NavigationController::set('Home');
    return view('home');
  }

  public function profile() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-user',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__);
  }

  public function dashboard() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-analytics',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__);
  }

  public function events() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-star',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__)->with([
      'events' => \App\Event::all(),
      'active' => \App\Event::where('active', 1)->get()->first(),
    ]);
  }

  public function judges() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-gavel',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__)->with([
      'active' => \App\Event::where('active', 1)->get()->first(),
      'judges' => \App\Judge::orderBy('number')->orderBy('updated_at')->get(),
    ]);
  }

  public function categories() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-layer-group',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__)->with('events', \App\Event::all());;
  }

  public function contestants() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-hashtag',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__)->with([
      'events' => \App\Event::all(),
      'active' => \App\Event::where('active', 1)->get()->first(),
      'contestants' => \App\Contestant::all(),
    ]);;
  }

  public function evaluation() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-badge-percent',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__)->with([
      'active' => \App\Event::where('active', 1)->get()->first(),
      'category' => \App\Category::get()->first(),
      'judges' => \App\Judge::all(),
    ]);
  }

  public function users() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-users-cog',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__);
  }

  public function settings() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-cogs',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__);
  }

  public function about() {
    NavigationController::set(__FUNCTION__, [
      'link' => false,
      'icon' => 'far fa-info-circle',
      'value' => ucfirst(__FUNCTION__),
    ]);
    return view(__FUNCTION__);
  }

  public function x() {
    return view('judge.login')->with([
      'active' => \App\Event::where('active', 1)->get()->first(),
      'judges' => \App\Judge::all()->sortBy('number'),
    ]);
  }

  public function xj($j) {
    $judge = \App\Judge::find($j);
    if($judge == null) {
      return redirect('/x');
    }
    return view('judge.login')->with([
      'active' => \App\Event::where('active', 1)->get()->first(),
      'judge' => $judge,
    ]);
  }

  public function xt($t, $j) {
    $judge = \App\Judge::find(@explode('$',$j)[1]);
    if($judge==null||$judge->token!=$t||$judge->pin!=@explode('$',$j)[0]) {
      return redirect('/x');
    } else {
      NavigationController::set(\App\Event::where('active', 1)->get()->first()->name,[]);
      return view('judge.judge')->with([
        'active' => \App\Event::where('active', 1)->get()->first(),
        'judge' => $judge,
        'contestants' => \App\Contestant::all()->sortBy('number'),
      ]);
    }
  }

  public function xc($t, $j, $c) {
    $judge = \App\Judge::find(@explode('$',$j)[1]);
    if($judge==null||$judge->token!=$t||$judge->pin!=@explode('$',$j)[0]) {
      return redirect('/x');
    } else if(!\App\Category::find($c) || !$judge->categories->contains($c)) {
      return abort(404);
    } else {
      $category = \App\Category::find($c);
      NavigationController::set($category->name, [
        'link' => false,
        'icon' => 'far fa-star',
        'value' => ucfirst($category->name),
      ]);
      return view('judge.category')->with([
        'active' => \App\Event::where('active', 1)->get()->first(),
        'judge' => $judge,
        'contestants' => \App\Contestant::all()->sortBy('number'),
        'category' => \App\Category::find($c),
        'final' => \App\Subcategory::where(['type' => 'final', 'category_id' => $c])->get()->first(),
      ]);
    }
  }
}
