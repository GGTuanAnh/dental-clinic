@extends('layouts.admin')
@section('page-title','Lịch hẹn')
@section('page-description')
  Điều phối lịch khám, cập nhật ghi chú và trạng thái thanh toán cho từng ca điều trị.
@endsection
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Lịch hẹn']
  ]" />
@endsection
@section('content')
    @include('admin.appointments.index-partial')
@endsection
