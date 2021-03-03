@extends('layouts.app')

@section('content')
    <div class="container">
     <customeredit-component :customerdata="{{customer}}"></customeredit-component>
    </div>

@endsection
