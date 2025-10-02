@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="h2">Dashboard</h1>
    <p class="text-muted mb-4">Welcome back, {{ auth()->user()->name }} 👋</p>

    <!-- Stat Cards Row -->
    <div class="row">
        {{-- โค้ด Stat Cards 4 ใบของคุณ (ไม่มีการเปลี่ยนแปลง) --}}
        <!-- Card 1: Total Trainees -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Trainees</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_trainees'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 2: Upcoming Sessions -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Upcoming Sessions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['upcoming_sessions'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 3: Pending Payments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Payments to Verify</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_payments'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 4: Completed This Month -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Completed ({{ now()->format('F') }})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed_this_month'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">

        <!-- Left Column (2/3) -->
        <div class="col-lg-8">
            {{-- โค้ดคอลัมน์ซ้ายทั้งหมดของคุณ (ไม่มีการเปลี่ยนแปลง) --}}
            <!-- Registration Trend Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Registration Trend (Last 12 Months)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="registrationTrendChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Upcoming Sessions Table -->
            <div class="card shadow mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Upcoming Sessions (Next 14 Days)</h6>
                    <a href="{{ route('admin.attendance.overview') }}">View All &rarr;</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($upcomingSessions as $session)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $session->program->title }}</div>
                                            <small class="text-muted">{{ $session->title ?? ('รอบที่ ' . $session->session_number) }}</small>
                                        </td>
                                        <td><i class="far fa-calendar-alt mr-1 text-gray-400"></i> {{ $session->start_at->format('d M Y') }}</td>
                                        <td>
                                            @if($session->status === 'scheduled')
                                                <span class="badge bg-primary">Scheduled</span>
                                            @elseif($session->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($session->status) }}</span>
                                            @endif
                                        </td>

                                        <td><i class="fas fa-users mr-1 text-gray-400"></i> {{ $session->registrations->count() }} / {{ $session->capacity ?? 'N/A' }}</td>
                                        <td class="text-right"><a href="{{ route('admin.registrations.index', $session) }}" class="btn btn-sm btn-outline-secondary">View Registrations</a></td>
                                    </tr>
                                @empty
                                    <tr><td class="p-4 text-center text-muted">No upcoming sessions.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Sessions Awaiting Action Table -->
            <div class="card border-left-danger shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Sessions Awaiting Action</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($sessionsToComplete as $session)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $session->program->title }}</div>
                                            <small class="text-muted">Ended on {{ $session->end_at->format('d M Y') }}</small>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.attendance.overview') }}" class="btn btn-sm btn-info">Attendance</a>
                                            <form action="{{-- route('admin.sessions.complete', $session) --}}" method="POST" class="d-inline ml-1" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Mark as Complete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                     <tr><td class="p-4 text-center text-muted">All caught up! No sessions are waiting.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (1/3) (ส่วนที่เพิ่มเข้ามา) -->
        <div class="col-lg-4">
            
            <!-- Feedback Rating Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Overall Feedback Rating</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="feedbackPieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Sessions at Risk -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Sessions at Risk</h6>
                </div>
                <div class="card-body">
                    @if($lowEnrollmentSessions->isEmpty() && $nearingCapacitySessions->isEmpty())
                        <p class="text-center text-muted small py-3">No sessions at risk currently.</p>
                    @else
                        @foreach($lowEnrollmentSessions as $session)
                            <div class="alert alert-warning small p-2 mb-2">
                                <strong>Low Enrollment:</strong> {{ $session->program->title }} ({{ $session->registrations->count() }}/{{$session->capacity}})
                            </div>
                        @endforeach
                        @foreach($nearingCapacitySessions as $session)
                            <div class="alert alert-info small p-2 mb-2">
                                <strong>Nearing Capacity:</strong> {{ $session->program->title }} ({{ $session->registrations->count() }}/{{$session->capacity}})
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            
            <!-- Recent Activity Feed -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    @forelse($recentActivities as $activity)
                        <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                            <div class="mr-3">
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                            <div>
                                <div class="small text-gray-600">{{ $activity->created_at->diffForHumans() }}</div>
                                <span class="font-weight-bold">{{ $activity->user->name }}</span> registered for {{ $activity->session->program->title }}.
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted small py-3">No recent activity.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
{{-- โค้ด JavaScript ทั้งหมดของคุณ (รวมทั้งสองกราฟ) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Line Chart
        const lineChartElement = document.getElementById('registrationTrendChart');
        if (lineChartElement) {
            const lineCtx = lineChartElement.getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: {!! isset($chartData) ? json_encode($chartData['labels']) : '[]' !!},
                    datasets: [{
                        label: 'Registrations',
                        data: {!! isset($chartData) ? json_encode($chartData['data']) : '[]' !!},
                        borderColor: 'rgba(78, 115, 223, 1)',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
            });
        }

        // Pie Chart
        const pieChartElement = document.getElementById('feedbackPieChart');
        if(pieChartElement) {
            const pieCtx = pieChartElement.getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! isset($feedbackChartData) ? json_encode($feedbackChartData['labels']) : '[]' !!},
                    datasets: [{
                        data: {!! isset($feedbackChartData) ? json_encode($feedbackChartData['data']) : '[]' !!},
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: true, position: 'bottom' },
                    cutoutPercentage: 80,
                },
            });
        }
    });
</script>
@endpush