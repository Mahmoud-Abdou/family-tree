{{--@extends('errors::minimal')--}}
@extends('errors.custom-layout')

@section('title', 'خطأ في الخادم')
@section('code', '500')
@section('message', 'يوجد خطأ في الخادم، أعد المحاولة.')
