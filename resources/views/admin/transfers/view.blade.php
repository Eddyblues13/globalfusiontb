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
                <h1 class="title1 d-inline text-{{ $text }}">Bank Transfer Details</h1>
                <div class="d-inline">
                    <div class="float-right btn-group">
                        <a class="btn btn-primary btn-sm" href="{{ route('manage-transfers') }}"> <i
                                class="fa fa-arrow-left"></i>
                            back</a>
                    </div>
                </div>
            </div>
            <x-danger-alert />
            <x-success-alert />

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-{{ $text }}">Transfer Information</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="text-{{ $text }}">Reference ID</th>
                                            <td>{{ $transfer->reference_id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">User</th>
                                            <td>{{ $transfer->user->name }} (ID: {{ $transfer->user_id }})</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Amount</th>
                                            <td>${{ number_format($transfer->amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Fee</th>
                                            <td>${{ number_format($transfer->fee, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Net Amount</th>
                                            <td>${{ number_format($transfer->net_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Status</th>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $transfer->status == 'completed' ? 'success' : ($transfer->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($transfer->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Date</th>
                                            <td>{{ $transfer->created_at->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="text-{{ $text }}">Bank Details</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="text-{{ $text }}">Account Name</th>
                                            <td>{{ $transfer->account_name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Account Number</th>
                                            <td>{{ $transfer->account_number }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Bank Name</th>
                                            <td>{{ $transfer->bank_name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Routing Number</th>
                                            <td>{{ $transfer->routing_number }}</td>
                                        </tr>
                                    </table>

                                    @if($transfer->status == 'pending')
                                    <div class="mt-3 p-3 border rounded">
                                        <h6 class="text-{{ $text }}">Process Transfer</h6>
                                        <p class="text-muted">Current user balance: ${{
                                            number_format($transfer->user->account_bal, 2) }}</p>

                                        <form action="{{ route('approve-transfer', $transfer->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirm('Approve this transfer? ${{ number_format($transfer->net_amount, 2) }} will be added to user account.')">
                                                <i class="fa fa-check-circle"></i> Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('decline-transfer', $transfer->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Decline this transfer? This action cannot be undone.')">
                                                <i class="fa fa-times-circle"></i> Decline
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if($transfer->description)
                            <div class="mt-4">
                                <h5 class="text-{{ $text }}">Additional Notes</h5>
                                <div class="p-3 border rounded">
                                    {{ $transfer->description }}
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