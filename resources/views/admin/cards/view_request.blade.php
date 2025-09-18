<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.app')
@section('content')
@include('admin.topmenu')
@include('admin.sidebar')
<div class="main-panel ">
    <div class="content ">
        <div class="page-inner">
            <div class="mt-2 mb-5">
                <h1 class="title1 d-inline text-{{ $text }}">Card Delivery Request Details</h1>
                <div class="d-inline">
                    <div class="float-right btn-group">
                        <a class="btn btn-primary btn-sm" href="{{ route('manage-card-requests') }}"> <i
                                class="fa fa-arrow-left"></i>
                            back</a>
                    </div>
                </div>
            </div>
            <x-danger-alert />
            <x-success-alert />

            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-{{ $text }}">Request Information</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="text-{{ $text }}">Request ID</th>
                                            <td>#{{ $request->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">User</th>
                                            <td>
                                                {{ $request->user->name }} (ID: {{ $request->user_id }})<br>
                                                <small>{{ $request->user->email }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Status</th>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $request->status == 'approved' ? 'success' : ($request->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Date Submitted</th>
                                            <td>
                                            <td>{{ $request->created_at?->toDayDateTimeString() ?? 'N/A' }}</td>
                                            </td>
                                        </tr>
                                        @if($request->status != 'pending')
                                        <tr>
                                            <th class="text-{{ $text }}">Processed Date</th>
                                            <td>
                                            <td>{{ $request->updated_at?->toDayDateTimeString() ?? 'N/A' }}</td>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="text-{{ $text }}">Delivery Information</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="text-{{ $text }}">Full Name</th>
                                            <td>{{ $request->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Address</th>
                                            <td>{{ $request->address }}</td>
                                        </tr>
                                        @if($request->nearest_airport)
                                        <tr>
                                            <th class="text-{{ $text }}">Nearest Airport</th>
                                            <td>{{ $request->nearest_airport }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th class="text-{{ $text }}">Phone Number</th>
                                            <td>{{ $request->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Email</th>
                                            <td>{{ $request->email }}</td>
                                        </tr>
                                    </table>

                                    @if($request->status == 'pending')
                                    <div class="mt-3 p-3 border rounded">
                                        <h6 class="text-{{ $text }}">Process Request</h6>

                                        <form action="{{ route('approve-card-request', $request->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirm('Approve this card delivery request?')">
                                                <i class="fa fa-check-circle"></i> Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('decline-card-request', $request->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Decline this card delivery request? This action cannot be undone.')">
                                                <i class="fa fa-times-circle"></i> Decline
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Additional actions for approved requests -->
                            @if($request->status == 'approved')
                            <div class="mt-4 p-3 border rounded bg-light">
                                <h6 class="text-{{ $text }}">Shipping Actions</h6>
                                <p class="text-muted">This request has been approved. You can now:</p>
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-truck"></i> Mark as Shipped
                                    </button>
                                    <button class="btn btn-outline-info btn-sm">
                                        <i class="fa fa-envelope"></i> Send Tracking Info
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fa fa-print"></i> Print Shipping Label
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection