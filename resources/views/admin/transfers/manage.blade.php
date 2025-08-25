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
                <h1 class="title1 d-inline text-{{ $text }}">Manage Bank Transfers</h1>
                <div class="d-inline">
                    <div class="float-right btn-group">
                        <a class="btn btn-primary btn-sm" href="{{ route('mdeposits') }}"> <i
                                class="fa fa-arrow-left"></i>
                            back</a>
                    </div>
                </div>
            </div>
            <x-danger-alert />
            <x-success-alert />

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            @if($transfers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ref ID</th>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Bank Details</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transfers as $transfer)
                                        <tr>
                                            <td>{{ $transfer->reference_id }}</td>
                                            <td>{{ $transfer->user->name }}<br><small>{{ $transfer->user->email
                                                    }}</small></td>
                                            <td>
                                                <strong>${{ number_format($transfer->amount, 2) }}</strong><br>
                                                <small>Fee: ${{ number_format($transfer->fee, 2) }}</small><br>
                                                <small>Net: ${{ number_format($transfer->net_amount, 2) }}</small>
                                            </td>
                                            <td>
                                                <small>
                                                    <strong>{{ $transfer->bank_name }}</strong><br>
                                                    Acct: {{ $transfer->account_number }}<br>
                                                    Name: {{ $transfer->account_name }}
                                                </small>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $transfer->status == 'completed' ? 'success' : ($transfer->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($transfer->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $transfer->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('viewtransfer', $transfer->id) }}"
                                                    class="btn btn-info btn-sm" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @if($transfer->status == 'pending')
                                                <div class="btn-group mt-1">
                                                    <form action="{{ route('approve-transfer', $transfer->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Approve this transfer? ${{ number_format($transfer->net_amount, 2) }} will be deducted from user account.')">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('decline-transfer', $transfer->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Decline this transfer? This action cannot be undone.')">
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
                                {{ $transfers->links() }}
                                <!-- Pagination links if needed -->
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fa fa-exchange-alt fa-3x text-muted mb-3"></i>
                                <h4>No Bank Transfers Found</h4>
                                <p>There are currently no bank transfer deposits to manage.</p>
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