<?php

namespace App\Http\Controllers\backend\operator;

use App\Http\Controllers\Controller;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use App\Http\Middleware\OperatorAuthenticationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class MoodEntriesController extends Controller implements HasMiddleware
{
      public static function middleware(): array
  {
    return [
      BackendAuthenticationMiddleware::class,
      OperatorAuthenticationMiddleware::class
    ];
  }

  public function MoodEntries(){
    return view('backend.operator.pages.mood_entries');
  }
}
