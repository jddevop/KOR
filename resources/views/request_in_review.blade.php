@extends('layouts.app')
@section('title', 'Request in Review')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="btd-box">
			<img src="{{ asset('asset/images/clock.png') }}" class="img-fluid">
			<p>Your request will be reviewed. Approved leave will be scheduled and processed through payroll in accordance with company policy</p>
			<div class="d-grid">
				<a href="{{ route('dashboard') }}" class="blue-btn-link">Back to Dashboard</a>
			</div>						
		</div>
	</div>
</div>
@endsection
		