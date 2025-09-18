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
                <h1 class="title1 d-inline text-{{ $text }}">Manage Card Delivery Requests</h1>
                <div class="d-inline">
                    <div class="float-right btn-group">
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.dashboard') }}"> <i
                                class="fa fa-arrow-left"></i>
                            Dashboard</a>
                    </div>
                </div>
            </div>
            <x-danger-alert />
            <x-success-alert />

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            @if($cardRequests->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Request ID</th>
                                            <th>User</th>
                                            <th>Full Name</th>
                                            <th>Address</th>
                                            <th>Contact Info</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cardRequests as $request)
                                        <tr>
                                            <td>#{{ $request->id }}</td>
                                            <td>
                                                {{ $request->full_name }}<br>
                                                <small>{{ $request->email }}</small>
                                            </td>
                                            <td>{{ $request->full_name }}</td>
                                            <td>
                                                <small>
                                                    {{ $request->address }}<br>
                                                    @if($request->nearest_airport)
                                                    <strong>Nearest Airport:</strong> {{ $request->nearest_airport }}
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <strong>Phone:</strong> {{ $request->phone_number }}<br>
                                                    <strong>Email:</strong> {{ $request->email }}
                                                </small>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $request->status == 'completed' ? 'success' : ($request->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $request->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('view-card-request', $request->id) }}"
                                                    class="btn btn-info btn-sm" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @if($request->status == 'pending')
                                                <div class="btn-group mt-1">
                                                    <form action="{{ route('approve-card-request', $request->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Approve this card delivery request?')">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('decline-card-request', $request->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Decline this card delivery request? This action cannot be undone.')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $cardRequests->links() }}
                                <!-- Pagination links if needed -->
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fa fa-credit-card fa-3x text-muted mb-3"></i>
                                <h4>No Card Delivery Requests</h4>
                                <p>There are currently no card delivery requests to manage.</p>
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