@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">รายงานผลประเมิน (Feedback Report)</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5>จำนวนผู้ตอบแบบประเมินทั้งหมด: {{ $count }}</h5>

            <table class="table table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>หัวข้อ</th>
                        <th>คะแนนเฉลี่ย</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($averageScores as $question => $avg)
                        <tr>
                            <td>{{ $question }}</td>
                            <td>{{ $avg }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">ยังไม่มีข้อมูล Feedback</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <hr>
            <h5 class="mt-4">คำตอบทั้งหมด</h5>
            <ul>
                @foreach($feedbacks as $f)
                @php
                $answers = json_decode($f->answers, true);
            @endphp
            <li>
                <strong>{{ $f->user->name ?? 'ไม่ระบุชื่อ' }}</strong>:
                @if(is_array($answers) && count($answers) > 0)
                    @foreach($answers as $key => $value)
                        <span class="badge bg-primary">{{ $key }}: {{ $value }}</span>
                    @endforeach
                @else
                    <span class="text-muted">ไม่มีข้อมูลคำตอบ</span>
                @endif
            </li>

                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
