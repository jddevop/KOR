@extends('admin.layouts.main')
@section('title')
    Dashboard 
@endsection
@section('content')

            <div class="container-fluid">
                <div class="row colorbox-group-widget">
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-primary">
                                <div class="media-body">
                                    <h3 class="info-count"><?php echo $userCount; ?> <span class="pull-right"><i class="icon-user"></i></span></h3>
                                    <p class="info-text font-12">Users</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-success">
                                <div class="media-body">
                                    <h3 class="info-count"><?php echo $tagsCount; ?> <span class="pull-right"><i class="icon-tag"></i></span></h3>
                                    <p class="info-text font-12">Tags</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-danger">
                                <div class="media-body">
                                    <h3 class="info-count"><?php echo $cityCount; ?> <span class="pull-right"><i class="icon-location-pin"></i></span></h3>
                                    <p class="info-text font-12">City</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-warning">
                                <div class="media-body">
                                    <h3 class="info-count"><?php echo $occupationsCount; ?> <span class="pull-right"><i class="ti-briefcase"></i></span></h3>
                                    <p class="info-text font-12">Occupations</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php /*<div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-primary">
                                <div class="media-body">
                                    <h3 class="info-count">0 <span class="pull-right"><i class="icon-wallet"></i></span></h3>
                                    <p class="info-text font-12">Payroll</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 info-color-box">
                        <div class="white-box">
                            <div class="media bg-success">
                                <div class="media-body">
                                    <h3 class="info-count">0 <span class="pull-right"><i class="icon-plane"></i></span></h3>
                                    <p class="info-text font-12">Annual Leave</p>
                                </div>
                            </div>
                        </div>
                    </div>*/?>
                </div>
            </div>

@endsection