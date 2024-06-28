@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))

<script>
    window.location.href = '{{route("home_page")}}'; //using a named route
</script>