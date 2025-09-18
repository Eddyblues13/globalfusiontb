@extends('layouts.dash2')
@section('title', 'Card Delivery Requests')

@section('content')
<!-- Breadcrumbs + Page Title -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-primary-600">Dashboard</a>
                <i data-lucide="chevron-right" class="h-4 w-4 mx-2 text-gray-400"></i>
                <span class="text-sm font-medium text-gray-700">Card Delivery Requests</span>
            </div>

        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="p-5 flex items-center">
            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                <i data-lucide="inbox" class="h-6 w-6 text-blue-600"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-500 truncate">Total Requests</p>
                <h3 class="text-lg font-semibold text-gray-900">{{ $requests->total() }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="p-5 flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                <i data-lucide="clock" class="h-6 w-6 text-yellow-600"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-500 truncate">Pending Requests</p>
                <h3 class="text-lg font-semibold text-gray-900">{{ $pendingCount }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="p-5 flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                <i data-lucide="truck" class="h-6 w-6 text-green-600"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-500 truncate">Delivered</p>
                <h3 class="text-lg font-semibold text-gray-900">{{ $deliveredCount }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Filters</h2>
    </div>
    <div class="p-6">
        <form action="" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
            <div class="w-full md:w-1/4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <option value="">All</option>
                    <option value="pending" {{ request()->get('status') == 'pending' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="processing" {{ request()->get('status') == 'processing' ? 'selected' : ''
                        }}>Processing</option>
                    <option value="shipped" {{ request()->get('status') == 'shipped' ? 'selected' : '' }}>Shipped
                    </option>
                    <option value="delivered" {{ request()->get('status') == 'delivered' ? 'selected' : '' }}>Delivered
                    </option>
                    <option value="completed" {{ request()->get('status') == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                </select>
            </div>
            <div class="w-full md:w-1/4">
                <label for="date_start" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                <input type="date" id="date_start" name="date_start" value="{{ request()->get('date_start') }}"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md sm:text-sm">
            </div>
            <div class="w-full md:w-1/4">
                <label for="date_end" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                <input type="date" id="date_end" name="date_end" value="{{ request()->get('date_end') }}"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md sm:text-sm">
            </div>
            <div class="flex space-x-2">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                    <i data-lucide="filter" class="h-4 w-4 mr-2"></i> Filter
                </button>
                <a href=""
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <i data-lucide="x" class="h-4 w-4 mr-2"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="border-b border-gray-200 px-6 py-4">
        <h2 class="text-lg font-medium text-gray-900">Delivery Requests</h2>
    </div>
    @if($requests->count())
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nearest Airport</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($requests as $req)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($req->created_at)->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $req->full_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($req->address, 40) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $req->nearest_airport ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $req->phone_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $req->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-0.5 text-xs font-medium rounded-full
                                    @if($req->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($req->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($req->status == 'shipped') bg-indigo-100 text-indigo-800
                                    @elseif($req->status == 'delivered') bg-green-100 text-green-800
                                    @elseif($req->status == 'completed') bg-gray-100 text-gray-800
                                    @endif">
                            {{ ucfirst($req->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $requests->appends(request()->query())->links() }}
    </div>
    @else
    <div class="py-12 flex flex-col items-center justify-center text-center px-6">
        <div class="bg-gray-50 rounded-full p-3 mb-4">
            <i data-lucide="inbox" class="h-8 w-8 text-gray-400"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900">No Requests Found</h3>
        <p class="text-gray-500 text-sm mt-2">No card delivery requests available at this time.</p>
    </div>
    @endif
</div>
@endsection