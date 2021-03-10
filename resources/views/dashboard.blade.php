@extends('layout')
@section('title')
    Dashboard
@endsection
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-users fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">{{ DB::table('users')->get()->count() }}</div>
                            <div>Total Registered User</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-tasks fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">{{ DB::table('f_d_r_tables')->get()->count() }}</div>
                            <div>Total FDRs</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-success">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-check-circle fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">{{ DB::table('f_d_r_tables')->where('status', 'verified')->get()->count() }}</div>
                            <div>Total Verified FDRs</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div>
                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-user fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">12</div>
                            <div>Total Pending User</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-vcard fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">13</div>
                            <div>Total Email Verified User</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-calendar fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">14</div>
                            <div>Total Session Scheduled</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-calendar fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">15</div>
                            <div>Total Archived Session</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-success">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-calendar fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">16</div>
                            <div>Total Original Session</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-info">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-calendar fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">17</div>
                            <div>Total Recurring Session</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-calendar fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">18</div>
                            <div>Total Test Session</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-calendar fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">19</div>
                            <div>Schedule Created today</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-clock-o fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">{{ DB::table('f_d_r_tables')->where('status', 'pending')->get()->count() }}</div>
                            <div>Total Pending FDRs</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div>
                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0">
                            <div class="btn-group float-right">
                                <i class="fa fa-university fa-4x" aria-hidden="true"></i>
                            </div>
                            <div class="text-value">21</div>
                            <div>Total Listed University</div>
                        </div>
                        <div class="chart-wrapper mt-3 px-3" style="height:5px;">
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
    </div>
@endsection
