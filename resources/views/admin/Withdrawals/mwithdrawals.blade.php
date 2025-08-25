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
                        <a class="btn btn-primary btn-sm" href="{{ route('mdeposits') }}"> <i
                                class="fa fa-arrow-left"></i>
                            back</a>
                    </div>
                </div>
            </div>
            <x-danger-alert />
            <x-success-alert />

            @if($deposit->type == 'bank_transfer')
            <div class="mb-5 row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="card p-4 shadow">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-{{ $text }}">Transfer Details</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="text-{{ $text }}">Reference ID</th>
                                            <td>{{ $deposit->reference_id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">User</th>
                                            <td>{{ $deposit->user->name }} (ID: {{ $deposit->user_id }})</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Amount</th>
                                            <td>${{ number_format($deposit->amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Fee</th>
                                            <td>${{ number_format($deposit->fee, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Net Amount</th>
                                            <td>${{ number_format($deposit->net_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Status</th>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $deposit->status == 'completed' ? 'success' : ($deposit->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($deposit->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Date Submitted</th>
                                            <td>{{ $deposit->created_at->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4 class="text-{{ $text }}">Bank Information</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="text-{{ $text }}">Account Name</th>
                                            <td>{{ $deposit->account_name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Account Number</th>
                                            <td>{{ $deposit->account_number }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Bank Name</th>
                                            <td>{{ $deposit->bank_name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-{{ $text }}">Routing Number</th>
                                            <td>{{ $deposit->routing_number }}</td>
                                        </tr>
                                    </table>
                                </div>

                                @if($deposit->status == 'pending')
                                <div class="mt-4 p-3 border rounded">
                                    <h5 class="text-{{ $text }}">Process Transfer</h5>
                                    <p class="text-muted">Current user balance: ${{
                                        number_format($deposit->user->account_bal, 2) }}</p>

                                    <form action="{{ route('approve-transfer', $deposit->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Approve this transfer? ${{ number_format($deposit->net_amount, 2) }} will be added to user account.')">
                                            <i class="fa fa-check-circle"></i> Approve Transfer
                                        </button>
                                    </form>

                                    <form action="{{ route('decline-transfer', $deposit->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Decline this transfer? This action cannot be undone.')">
                                            <i class="fa fa-times-circle"></i> Decline Transfer
                                        </button>
                                    </form>
                                </div>
                                @else
                                <div class="mt-4 p-3 border rounded">
                                    <h5 class="text-{{ $text }}">Transfer Status</h5>
                                    <p>This transfer has already been processed.</p>
                                    @if($deposit->status == 'completed')
                                    <p class="text-success">Amount was added to user account on: {{
                                        $deposit->processed_at->format('M d, Y H:i:s') }}</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($deposit->description)
                        <div class="mt-4">
                            <h5 class="text-{{ $text }}">Additional Notes</h5>
                            <div class="p-3 border rounded">
                                {{ $deposit->description }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="mb-5 row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="alert alert-danger">
                        <h4>Not a Bank Transfer</h4>
                        <p>This deposit is not a bank transfer. It is a {{ ucfirst(str_replace('_', ' ',
                            $deposit->type)) }} deposit.</p>
                        <a href="{{ route('mdeposits') }}" class="btn btn-primary mt-2">Return to Deposits</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection