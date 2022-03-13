{{--@extends('errors::minimal')--}}
@extends('errors.custom-layout')

@section('title', 'ممنوع')
@section('code', '403')
@section('message', 'المستخدم ليس لديه الأذونات الصحيحة.'))
{{--@section('message', __($exception->getMessage() ?: 'المستخدم ليس لديه الأذونات الصحيحة.'))--}}
