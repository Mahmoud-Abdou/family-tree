{{--@extends('errors::minimal')--}}
@extends('errors.custom-layout')

@section('title', 'ممنوع')
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'نحتوى ممنوع.'))
