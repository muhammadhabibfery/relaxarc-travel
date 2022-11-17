@extends('errors::minimal')

@section('title', __('errors.401.title'))
@section('code', '401')
@section('message', __($exception->getMessage() ?: 'errors.401.text'))
