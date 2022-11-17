@extends('errors::minimal')

@section('title', __('errors.403.title'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'errors.403.text'))
{{-- @section('message', __($exception->getMessage() ?: 'Forbidden')) --}}
