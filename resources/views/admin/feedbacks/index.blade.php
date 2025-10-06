@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Feedbacks Report</h1>
        <a href="{{ route('admin.feedbacks.export', $session ?? 'all') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Export to Excel
        </a>
    </div>

    {{-- Summary Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Responses</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $feedbacks->total() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Avg Overall</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($averages->overall ?? 0, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Avg Pre-Knowledge</h3>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ number_format($averages->pre_knowledge ?? 0, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Avg Post-Knowledge</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ number_format($averages->post_knowledge ?? 0, 2) }}</p>
        </div>
    </div>

    {{-- Detailed Averages --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-3">Speaker Ratings</h3>
            <div class="space-y-2">
                @if(isset($averages->speakers_detailed))
                    @foreach($averages->speakers_detailed as $key => $value)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Item {{ $key + 1 }}</span>
                            <span class="font-semibold">{{ number_format($value, 2) }}</span>
                        </div>
                    @endforeach
                @endif
                <div class="border-t pt-2 mt-2 flex justify-between font-bold">
                    <span>Average:</span>
                    <span class="text-blue-600">{{ number_format($averages->speakers ?? 0, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-3">Content Ratings</h3>
            <div class="space-y-2">
                @if(isset($averages->content_detailed))
                    @foreach($averages->content_detailed as $key => $value)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Item {{ $key + 1 }}</span>
                            <span class="font-semibold">{{ number_format($value, 2) }}</span>
                        </div>
                    @endforeach
                @endif
                <div class="border-t pt-2 mt-2 flex justify-between font-bold">
                    <span>Average:</span>
                    <span class="text-green-600">{{ number_format($averages->content ?? 0, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-3">Staff Ratings</h3>
            <div class="space-y-2">
                @if(isset($averages->staff_detailed))
                    @foreach($averages->staff_detailed as $key => $value)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Item {{ $key + 1 }}</span>
                            <span class="font-semibold">{{ number_format($value, 2) }}</span>
                        </div>
                    @endforeach
                @endif
                <div class="border-t pt-2 mt-2 flex justify-between font-bold">
                    <span>Average:</span>
                    <span class="text-orange-600">{{ number_format($averages->staff ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Demographics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-3">Gender Distribution</h3>
            @if(isset($demographics->sex))
                <div class="space-y-2">
                    @foreach($demographics->sex as $sex => $count)
                        <div class="flex justify-between items-center">
                            <span>{{ $sex }}</span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 bg-gray-200 rounded-full h-4">
                                    <div class="bg-blue-500 h-4 rounded-full" style="width: {{ ($count / $feedbacks->total()) * 100 }}%"></div>
                                </div>
                                <span class="text-sm font-semibold">{{ $count }} ({{ number_format(($count / $feedbacks->total()) * 100, 1) }}%)</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="font-semibold text-lg mb-3">Age Distribution</h3>
            @if(isset($demographics->age))
                <div class="space-y-2">
                    @foreach($demographics->age as $age => $count)
                        <div class="flex justify-between items-center">
                            <span>{{ $age }}</span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 bg-gray-200 rounded-full h-4">
                                    <div class="bg-green-500 h-4 rounded-full" style="width: {{ ($count / $feedbacks->total()) * 100 }}%"></div>
                                </div>
                                <span class="text-sm font-semibold">{{ $count }} ({{ number_format(($count / $feedbacks->total()) * 100, 1) }}%)</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Future Topics Interest --}}
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="font-semibold text-lg mb-3">Future Topics Interest</h3>
        @if(isset($futureTopicsCount) && count($futureTopicsCount) > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($futureTopicsCount as $topic => $count)
                    <div class="border rounded p-3">
                        <p class="text-sm text-gray-600">{{ $topic }}</p>
                        <p class="text-xl font-bold text-blue-600">{{ $count }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Top Keywords from Comments --}}
    @if(isset($topWords) && count($topWords) > 0)
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="font-semibold text-lg mb-3">Top Keywords in Comments</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($topWords as $word => $count)
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    {{ $word }} <span class="font-bold">({{ $count }})</span>
                </span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Feedback Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Demographics</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ratings</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Knowledge</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($feedbacks as $f)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm">{{ $f->id }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="font-medium">{{ $f->trainingSession->title ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $f->session_id }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="font-medium">{{ $f->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $f->user->email ?? '' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div><strong>Sex:</strong> {{ $f->sex ?? '-' }}</div>
                                <div><strong>Age:</strong> {{ $f->age ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div><strong>Speakers:</strong> {{ is_array($f->speakers) ? number_format(array_sum($f->speakers) / count($f->speakers), 2) : '-' }}</div>
                                <div><strong>Content:</strong> {{ is_array($f->content) ? number_format(array_sum($f->content) / count($f->content), 2) : '-' }}</div>
                                <div><strong>Staff:</strong> {{ is_array($f->staff) ? number_format(array_sum($f->staff) / count($f->staff), 2) : '-' }}</div>
                                <div><strong>Overall:</strong> {{ $f->overall ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div><strong>Pre:</strong> {{ $f->pre_knowledge ?? '-' }}</div>
                                <div><strong>Post:</strong> {{ $f->post_knowledge ?? '-' }}</div>
                                @if($f->pre_knowledge && $f->post_knowledge)
                                    <div class="text-xs {{ ($f->post_knowledge - $f->pre_knowledge) > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        ({{ $f->post_knowledge - $f->pre_knowledge > 0 ? '+' : '' }}{{ $f->post_knowledge - $f->pre_knowledge }})
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm max-w-xs">
                                <p class="truncate">{{ $f->comment ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">{{ $f->created_at ? $f->created_at->format('Y-m-d H:i') : '-' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('admin.feedbacks.show', $f->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">No feedback data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 py-3 border-t">
            {{ $feedbacks->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
