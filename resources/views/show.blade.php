@extends('layouts.app')

@section('title', 'View shortened link')

@section('content')
    <h1>Link Shortened Successfully!</h1>
    <p>Your shortened link is:</p>
    <a href="{{ route('url.redirect', ['shortCode' => $url->short_code]) }}">
        {{ route('url.redirect', ['shortCode' => $url->short_code]) }}
    </a>
    <p>You can now share this link!</p>
@endsection
