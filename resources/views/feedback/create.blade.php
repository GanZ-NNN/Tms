@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold">Feedback for: {{ $session->title ?? 'Session' }}</h1>

    <form method="POST" action="{{ route('feedback.store', $session) }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach(['speakers','content','staff','overall','pre_knowledge','post_knowledge'] as $field)
                <div>
                    <label class="font-semibold capitalize">{{ str_replace('_',' ', $field) }}</label>
                    <select name="{{ $field }}" class="block mt-1 w-full border rounded">
                        <option value="">-- Select --</option>
                        @for($i=1;$i<=5;$i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <label class="font-semibold">Comment</label>
            <textarea name="comment" rows="4" class="block w-full border rounded mt-1"></textarea>
        </div>

        <div class="mt-4">
            <label class="font-semibold">Future topics (choose any)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">
                @foreach($topics as $topic)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="future_topics[]" value="{{ $topic }}" class="mr-2"> {{ $topic }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="mt-6">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Submit Feedback</button>
        </div>
    </form>
</div>
@endsection
