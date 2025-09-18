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
            <p>
                <a href="{{ route('admin.cheque.deposits') }}">
                    <i class="p-2 rounded-lg fa fa-arrow-circle-left fa-2x bg-light"></i>
                </a>
            </p>

            <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="title1 text-{{ $text }}">Cheque Deposit from {{ $cheque->user->name }}</h1>
                    @if ($cheque->status == 'Processed')
                    <span class="badge badge-success">Processed</span>
                    @elseif ($cheque->status == 'Rejected')
                    <span class="badge badge-danger">Rejected</span>
                    @else
                    <span class="badge badge-warning">{{ $cheque->status }}</span>
                    @endif
                </div>
                @if($cheque->status == 'Pending')
                <a href="#" data-toggle="modal" data-target="#action" class="btn btn-primary btn-sm">Process Cheque</a>
                @endif
            </div>

            <!-- Action Modal -->
            <div id="action" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h3 class="mb-2 d-inline text-{{ $text }}">Process Cheque Deposit</h3>
                            <button type="button" class="close text-{{ $text }}" data-dismiss="modal" aria-h6="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body ">
                            <form action="{{ route('admin.process.cheque') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <select name="action" id="" class="form-control  text-{{ $text }}" required>
                                        <option value="Processed">Accept and process cheque</option>
                                        <option value="Rejected">Reject cheque deposit</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea name="message" placeholder="Enter Message "
                                        class="form-control  text-{{ $text }}"
                                        required>This is to inform you that your cheque deposit of ${{ number_format($cheque->amount, 2) }} has been processed successfully. The funds have been credited to your account.</textarea>
                                </div>
                                <div class="form-group">
                                    <h5 class="text-{{ $text }}">Email subject</h5>
                                    <input type="text" name="subject" id="" class="form-control  text-{{ $text }}"
                                        placeholder="Cheque deposit processed successfully" required>
                                </div>
                                <input type="hidden" name="cheque_id" value="{{ $cheque->id }}">
                                <div class="form-group">
                                    <button type="submit" class="px-4 btn btn-primary"> Confirm </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Action Modal -->

            <x-danger-alert />
            <x-success-alert />

            <div class="mb-5 row">
                <div class="col-md-12">
                    <div class="card p-md-4 p-2 ">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-12 border-bottom">
                                    <small class="text-primary">Cheque Information</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <h2 class="text-{{ $text }}">{{ $cheque->user->name }}</h2>
                                    <small class="text-muted">Account Holder</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <h2 class="text-{{ $text }}">${{ number_format($cheque->amount, 2) }}</h2>
                                    <small class="text-muted">Amount</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <h2 class="text-{{ $text }}">{{ $cheque->cheque_number }}</h2>
                                    <small class="text-muted">Cheque Number</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <h2 class="text-{{ $text }}">{{ $cheque->bank_name }}</h2>
                                    <small class="text-muted">Bank Name</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <h2 class="text-{{ $text }}">{{ $cheque->account_holder }}</h2>
                                    <small class="text-muted">Cheque Account Holder</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <h2 class="text-{{ $text }}">{{ $cheque->created_at->format('M d, Y h:i A') }}</h2>
                                    <small class="text-muted">Submission Date</small>
                                </div>

                                <div class="my-3 border-bottom col-md-12">
                                    <small class="text-primary">Cheque Images</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <img src="{{ asset('storage/app/public/' . $cheque->front_image) }}"
                                        alt="Front of Cheque" class="w-100 img-fluid d-block rounded shadow">
                                    <small class="text-muted">Front of Cheque</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <img src="{{ asset('storage/app/public/' . $cheque->back_image) }}"
                                        alt="Back of Cheque" class="w-100 img-fluid d-block rounded shadow">
                                    <small class="text-muted">Back of Cheque</small>
                                </div>

                                @if($cheque->status != 'Pending')
                                <div class="my-3 border-bottom col-md-12">
                                    <small class="text-primary">Processing Information</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <h2 class="text-{{ $text }}">{{ $cheque->status }}</h2>
                                    <small class="text-muted">Status</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <h2 class="text-{{ $text }}">{{ $cheque->processed_at ?
                                        $cheque->processed_at->format('M d, Y h:i A') : 'N/A' }}</h2>
                                    <small class="text-muted">Processed Date</small>
                                </div>

                                @if($cheque->admin_notes)
                                <div class="mb-3 col-md-12">
                                    <h2 class="text-{{ $text }}">{{ $cheque->admin_notes }}</h2>
                                    <small class="text-muted">Admin Notes</small>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection