@extends('layouts.home_page_base')
@section('function_page')
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Hi, {{Auth::user()->name}}, welcome to HarbourLink's Home!</h4>
						<!--
                        <p class="card-text">The functions in this group are good for H/L control options</p>
						-->
                    </div>
                </div>
@endsection
