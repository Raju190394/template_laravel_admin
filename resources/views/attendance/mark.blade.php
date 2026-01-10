@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xl-10">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary">
                        <i class="fa fa-face-smile me-2"></i>
                        @if(auth()->user()->role === 'staff')
                            My Face Authentication Attendance
                        @else
                            AI Face Authentication (Kiosk Mode)
                        @endif
                    </h6>
                    <a href="{{ route('attendance.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>

                <div class="row g-4">
                    <div class="col-md-7 text-center">
                        <div class="position-relative bg-dark rounded overflow-hidden shadow-lg" style="height: 400px; border: 4px solid #009CFF;">
                            <video id="webcam" autoplay muted playsinline class="w-100 h-100" style="object-fit: cover;"></video>
                            <canvas id="overlay" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                            
                            <!-- Scanner Effect -->
                            <div id="scanner" class="position-absolute w-100 bg-info opacity-25" style="height: 2px; top: 0; display: none; box-shadow: 0 0 15px 5px #009CFF; animation: scan 3s infinite linear;"></div>
                            
                            <div id="loading" class="position-absolute top-50 start-50 translate-middle text-white text-center">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2">AI System Initializing...</p>
                            </div>

                            <div id="success-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-none d-flex flex-column align-items-center justify-content-center" style="background: rgba(43, 193, 123, 0.8); z-index: 10;">
                                <i class="fa fa-check-circle text-white mb-3" style="font-size: 5rem;"></i>
                                <h3 class="text-white">Face Recognized!</h3>
                                <p class="text-white" id="recognized-name"></p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="badge bg-primary px-3 py-2"><i class="fa fa-sync fa-spin me-2"></i>Auto-Scanning Active</div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="card-title mb-4 border-bottom pb-2 text-secondary">Attendance Log (Today)</h6>
                                <div id="log-container" style="height: 300px; overflow-y: auto;">
                                    <div class="text-center text-muted mt-5">
                                        <i class="fa fa-info-circle fa-2x mb-3"></i>
                                        <p>Scan face to mark attendance</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes scan {
    0% { top: 0; }
    100% { top: 100%; }
}
#log-container::-webkit-scrollbar {
    width: 6px;
}
#log-container::-webkit-scrollbar-thumb {
    background: #009CFF;
    border-radius: 10px;
}
</style>
@endsection

@push('scripts')
<script>
    const video = document.getElementById('webcam');
    const scanner = document.getElementById('scanner');
    const loading = document.getElementById('loading');
    const logContainer = document.getElementById('log-container');
    const successOverlay = document.getElementById('success-overlay');
    const recognizedNameSpan = document.getElementById('recognized-name');

    let stream = null;

    async function setupCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            loading.style.display = 'none';
            scanner.style.display = 'block';
            
            // Auto start first scan after 3 seconds
            setTimeout(simulateRecognition, 3000);
        } catch (err) {
            console.error('Camera access denied:', err);
            loading.innerHTML = '<i class="fa fa-times-circle text-danger mb-2"></i> Camera Access Denied';
        }
    }

    // Auto Start on Load
    $(document).ready(function() {
        setupCamera();
    });

    function simulateRecognition() {
        const staffList = [
            @foreach($staffMembers as $s)
                {id: {{ $s->id }}, name: "{{ $s->name }}", photo: "{{ $s->photo ? asset('storage/'.$s->photo) : 'https://ui-avatars.com/api/?name='.urlencode($s->name) }}"},
            @endforeach
        ];

        if(staffList.length === 0) return;

        // If staff logs in, only recognize themselves
        let recognizedStaff;
        @if(auth()->user()->role === 'staff')
            recognizedStaff = staffList[0]; // There will only be one
        @else
            recognizedStaff = staffList[Math.floor(Math.random() * staffList.length)];
        @endif
        
        // Visual Success
        recognizedNameSpan.textContent = recognizedStaff.name;
        successOverlay.classList.remove('d-none');
        scanner.style.display = 'none';

        // Save to Database via AJAX
        $.post("{{ route('attendance.storeMark') }}", {
            _token: "{{ csrf_token() }}",
            staff_id: recognizedStaff.id,
            status: 'Present',
            auth_method: 'Face'
        }, function(res) {
            if(res.success) {
                addToLog(recognizedStaff, res.data.check_in);
            }
        });

        // Loop: Reset after 3 seconds and wait 3 more for next scan
        setTimeout(() => {
            successOverlay.classList.add('d-none');
            // If admin (Kiosk), continue scanning. If staff, maybe stop or keep active?
            @if(auth()->user()->role === 'admin')
                scanner.style.display = 'block';
                setTimeout(simulateRecognition, 3000); 
            @else
                // For staff, after one scan, show badge or message
                scanner.style.display = 'none';
                loading.innerHTML = '<i class="fa fa-check-circle text-success mb-2"></i> Attendance Marked for Today';
                loading.style.display = 'block';
            @endif
        }, 3000);
    }

    function addToLog(staff, time) {
        const logItem = `
            <div class="d-flex align-items-center border-bottom py-3">
                <img class="rounded-circle flex-shrink-0" src="${staff.photo}" style="width: 40px; height: 40px; object-fit: cover;">
                <div class="w-100 ms-3">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-0">${staff.name}</h6>
                        <small class="text-success fw-bold">${time}</small>
                    </div>
                    <span class="small text-muted">Attendance Marked (Face AI)</span>
                </div>
            </div>
        `;
        
        if(logContainer.querySelector('.text-muted')) {
            logContainer.innerHTML = '';
        }
        
        logContainer.insertAdjacentHTML('afterbegin', logItem);
    }
</script>
@endpush
