@extends('layouts.main')

@section('title', 'Blog')

@section('content')
    <!-- begin page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Data Overview</h4>

                <!-- begin breadcrumb -->
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                        <li class="breadcrumb-item active">Company</li>
                    </ol>
                </div>
                <!-- end breadcrumb -->
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- begin content -->
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Company</h4>
                <p class="card-title-desc">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, quae.
                </p>

                <!-- Dropdown filter for company name -->
                <div class="mb-3">
                    <label for="companyFilter" class="form-label">Filter by Company Name</label>
                    <select id="companyFilter" class="form-select">
                        <option value="">Select Company</option>
                        @foreach ($students as $student)
                                <option value="{{ $student->m_partner->name }}">{{ $student->m_partner->name }}</option>
                            @endforeach
                    </select>
                </div>

                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="data-medium">Name</th>
                            <th class="data-long">Company</th>
                            <th>Report</th>
                            <th>Status</th>
                            <th>Grade</th>
                            <th>Note</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td> <!-- Nomor urut -->
                            <td>{{ $student->user->name ?? '' }}</td> <!-- Nama User dari relasi, jika null tampilkan kosong -->
                            <td>{{ $student->m_partner->name ?? '' }}</td>
                            <td>{{ $student->laporan ?? '' }}</td>
                            <td>
                                @if ($student->status == 'PENDING')
                                    <span class="badge bg-warning">PENDING</span>
                                @elseif ($student->status == 'VERIFIED')
                                    <span class="badge bg-success">VERIFIED</span>
                                @elseif ($student->status == 'UNVERIFIED')
                                    <span class="badge bg-danger">UNVERIFIED</span>
                                @else
                                    <span class="badge bg-secondary">{{ $student->status ?? 'Unknown' }}</span>
                                @endif
                            </td>
                            <td>{{ $student->grade ?? ''}}</td>
                            <td> {{ $student->note ?? ''}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Modal for inputting grade -->
    <div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradeModalLabel">Input Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="gradeForm" action="{{ route('update-grade') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="gradeInput" class="form-label">Grade</label>
                        <input type="text" class="form-control" id="gradeInput" name="grade" required>
                        <input type="hidden" id="studentId" name="id" value="{{ $student->id }}"> <!-- Pastikan value ini diisi dengan ID yang valid -->
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- end content -->

    <!-- FAB add starts -->
    <div id="floating-add-button">
        <a href="{{ route('getAddCompany') }}" target="_blank">
            <i class="fas fa-plus"></i>
        </a>
    </div>
    <!-- FAB add ends -->
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Include Bootstrap JS -->

<script>
    $(document).ready(function() {
        // Fungsi untuk memfilter tabel berdasarkan dropdown
        $('#companyFilter').on('change', function() {
            var selectedCompany = this.value.toLowerCase();
            var rowIndex = 1; // Inisialisasi nomor urut

            $('#datatable tbody tr').each(function() {
                var companyName = $(this).find('td').eq(2).text().toLowerCase(); // Kolom "Company" berada di indeks ke-2
                if (selectedCompany === '' || companyName.includes(selectedCompany)) {
                    $(this).show(); // Tampilkan baris jika cocok
                    $(this).find('td').eq(0).text(rowIndex++); // Perbarui nomor urut
                } else {
                    $(this).hide(); // Sembunyikan baris jika tidak cocok
                }
            });
        });

        // Fungsi untuk menangani klik pada kolom Grade dan menampilkan modal
        $('#datatable').on('click', 'td', function() {
            var columnIndex = $(this).index();
            var gradeCell = $(this);

            if (columnIndex === 5) { // Kolom "Grade" adalah kolom ke-5
                var currentGrade = gradeCell.text();
                var studentId = gradeCell.closest('tr').find('td').eq(0).text(); // Ambil ID student dari kolom No
                
                $('#gradeInput').val(currentGrade);
                $('#studentId').val(studentId);

                var gradeModal = new bootstrap.Modal(document.getElementById('gradeModal'));
                gradeModal.show();
            }
        });
    });
</script>
@endsection
