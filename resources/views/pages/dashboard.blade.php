@extends('layouts.main')

@section('title', 'Dashboard | CMS Template')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary-subtle p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-primary">Welcome Back !</h5>
                        <h6 class="font-size-15 text-truncate mb-0">William</h6>
                        <p class="text-muted mb-0">IT Manager</p>
                    </div>
                    <div>
                        <img src="{{ asset('assets/images/default_profile.png') }}" alt=""
                            class="img-thumbnail rounded-circle" style="width: 60px; height: 60px;">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex flex-wrap">
                        <h4 class="card-title mb-4">Student Data</h4>
                    </div>

                    <div id="student-progress-chart" class="apex-charts"></div>
                </div>
            </div> 
        </div>

        <div class="col-xl-8" style="margin-top: 5%">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex flex-wrap">
                        <h4 class="card-title mb-4">Student Data</h4>
                        <div class="ms-auto d-flex">
                            <select id="yearSelect" class="form-select me-2 mx-5" style="width: 150px; padding: 5px;">
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024" selected>2024</option>
                            </select>
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Year</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="stacked-column-chart" class="apex-charts"></div>
                </div>
                
            </div> 
        </div>

        <div class="col-xl-2">
        </div>

        <div class="col-xl-8">
            <div class="card overflow-hidden">
            <div class="card-body">
                    <div class="d-sm-flex flex-wrap">
                        <h4 class="card-title mb-4">Partner Data</h4>
                    </div>

                    <div id="partner-pie-chart" class="apex-charts"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-2">
        </div>
    </div>
    <!-- end row -->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Data from the database
    var StudentData = @json($StudentData);
    var PartnerData = @json($PartnerData);

    var studentChart;  // Declare chart variable to keep track of the instance

    // Function to update the student chart based on the selected year
    function updateStudentChart(year) {
        var StudentsData = [];
        var categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var monthDataMap = {};

        // Initialize months data with zero
        categories.forEach(function (month, index) {
            monthDataMap[index + 1] = 0;
        });

        // Update data for the selected year
        StudentData.forEach(function (item) {
            if (item.year === year) {
                monthDataMap[item.month] = item.students;
            }
        });

        categories.forEach(function (month, index) {
            StudentsData.push(monthDataMap[index + 1]);
        });

        // Destroy existing chart instance if it exists
        if (studentChart) {
            studentChart.destroy();
        }

        // Chart options
        var options = {
            series: [{
                name: 'Students',
                data: StudentsData
            }],
            chart: {
                type: 'line',
                height: 350,
                stacked: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            markers: {
                size: 4
            },
            xaxis: {
                categories: categories,
            },
            legend: {
                position: 'bottom'
            },
            fill: {
                opacity: 1
            },
            colors: ['#0d6efd'],
            title: {
                text: 'Total of students per month for ' + year,
                align: 'center'
            }
        };

        // Create new chart instance
        studentChart = new ApexCharts(document.querySelector("#stacked-column-chart"), options);
        studentChart.render();
    }

    // Set default year to 2024
    var selectedYear = parseInt(document.getElementById('yearSelect').value) || 2024;
    updateStudentChart(selectedYear);  // Load chart for default year

    // Event listener for year dropdown
    document.getElementById('yearSelect').addEventListener('change', function () {
        var year = parseInt(this.value);
        updateStudentChart(year);  // Update chart for selected year
    });

    // Data for student progress
    var dataStudentStatus = {
        Finished: [100],  // Finished students
        OnProgress: [65]  // Students still in progress
    };

    // Chart for student progress
    var studentProgressOptions = {
        series: [{
            name: 'Finished',
            data: dataStudentStatus.Finished
        }, {
            name: 'On Progress',
            data: dataStudentStatus.OnProgress
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: true,
                columnWidth: '30%',
                endingShape: 'rounded'
            }
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Students'],
        },
        yaxis: {
            title: {
                text: 'Months'
            }
        },
        fill: {
            opacity: 1
        },
        colors: ['#28a745', '#ffc107'],
        legend: {
            position: 'bottom'
        },
        title: {
            text: 'Student Progress Overview (Monthly)',
            align: 'center'
        }
    };

    var studentProgressChart = new ApexCharts(document.querySelector("#student-progress-chart"), studentProgressOptions);
    studentProgressChart.render();

    // Data for partner pie chart
    var PartnerDataArray = [
    (PartnerData[0] && PartnerData[0].universities) ? PartnerData[0].universities : 0,
    (PartnerData[0] && PartnerData[0].companies) ? PartnerData[0].companies : 0,
    (PartnerData[0] && PartnerData[0].governments) ? PartnerData[0].governments : 0
];

console.log('PartnerDataArray:', PartnerDataArray);

    var testData = [30, 50, 20];


    // Pie chart for partner data
    var partnerChartOptions = {
        series: PartnerDataArray,
        chart: {
            type: 'pie',
            height: 400
        },
        labels: ['Universities', 'Companies', 'Governments'],
        colors: ['#28a745', '#ffc107', '#dc3545'],
        legend: {
            position: 'bottom'
        },
        title: {
            text: 'Partner Distribution',
            align: 'center'
        }
    };

    var partnerChart = new ApexCharts(document.querySelector("#partner-pie-chart"), partnerChartOptions);
    partnerChart.render();
});

</script>
