<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $bg = 'dark';
    $text = 'light';
}
?>
@extends('layouts.app')
@section('content')
@include('admin.topmenu')
@include('admin.sidebar')
<div class="main-panel ">
    <div class="content ">
        <div class="page-inner">
            <div class="mt-2 mb-4">
                <h1 class="title1 text-{{ $text }}">Cheque Deposits Management</h1>
            </div>

            <x-danger-alert />
            <x-success-alert />

            <div class="mb-5 row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Cheque #</th>
                                            <th>Bank</th>
                                            <th>Status</th>
                                            <th>Submitted</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cheques as $cheque)
                                        <tr>
                                            <td>{{ $cheque->user->name }}</td>
                                            <td>${{ number_format($cheque->amount, 2) }}</td>
                                            <td>{{ $cheque->cheque_number }}</td>
                                            <td>{{ $cheque->bank_name }}</td>
                                            <td>
                                                @if($cheque->status == 'Processed')
                                                <span class="badge badge-success">Processed</span>
                                                @elseif($cheque->status == 'Rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                                @else
                                                <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $cheque->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.view.cheque', $cheque->id) }}"
                                                    class="btn btn-primary btn-sm">View</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No cheque deposits found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $cheques->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection