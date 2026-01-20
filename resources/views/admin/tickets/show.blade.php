@extends('layouts.admin')

@section('title', 'Ticket #' . $ticket->id)

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Ticket #{{ $ticket->id }}</h1>
            <p class="text-gray-600 mt-1">View and manage ticket details</p>
        </div>
        <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Ticket Details</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Subject</label>
                    <p class="text-gray-900 text-lg">{{ $ticket->subject }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-900 whitespace-pre-wrap">{{ $ticket->description }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        @php
                            $statusColors = [
                                'new' => 'bg-yellow-100 text-yellow-800',
                                'in_progress' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                            ];
                        @endphp
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$ticket->status->value] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $ticket->status }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Created</label>
                        <p class="text-gray-900">{{ $ticket->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    @if($ticket->manager_responded_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Manager Responded</label>
                        <p class="text-gray-900">{{ $ticket->manager_responded_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($ticket->getMedia('attachments')->count() > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Attachments ({{ $ticket->getMedia('attachments')->count() }})</h2>
            
            <div class="space-y-3">
                @foreach($ticket->getMedia('attachments') as $media)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $media->file_name }}</p>
                            <p class="text-xs text-gray-500">{{ number_format($media->size / 1024, 2) }} KB</p>
                        </div>
                    </div>
                    <a href="{{ $media->getUrl() }}" target="_blank" download class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Customer Information</h2>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Name</label>
                    <p class="text-gray-900 font-medium">{{ $ticket->customer->name }}</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Phone</label>
                    <a href="tel:{{ $ticket->customer->phone }}" class="text-blue-600 hover:text-blue-800">
                        {{ $ticket->customer->phone }}
                    </a>
                </div>

                @if($ticket->customer->email)
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Email</label>
                    <a href="mailto:{{ $ticket->customer->email }}" class="text-blue-600 hover:text-blue-800">
                        {{ $ticket->customer->email }}
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Change Status</h2>
            
            <form method="POST" action="{{ route('admin.tickets.update-status', $ticket->id) }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Status</label>
                    <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ $ticket->status->value === $status->value ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection