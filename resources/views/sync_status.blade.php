@extends('layouts.app')
@section('title', 'Sync Status & History')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="shift-dark-info">
			<span class="concluded mb-3">online</span>
			<h3>Current Sync</h3>
			<p class="mb-0">Last synced: 2/10/2026, 12:18:16</p>
		</div>

		<div class="d-block mb-4">
			<button type="button" class="btn btn-primary blue-btn text-capitalize">sync Now</button>
		</div>					

		<div class="sync-history">
			<p class="sh-title">Sync History</p>
			<div class="sh-single">
				<p class="sh-time">2/10/2026, 12:18:16</p>
				<p class="sh-success">Success</p>
			</div>
			<div class="sh-single">
				<p class="sh-time">2/10/2026, 12:17:29</p>
				<p class="sh-failed">Failed</p>
			</div>	
			<div class="sh-single">
				<p class="sh-time">10 Feb 2026, 09:42</p>
				<p class="sh-success">Success</p>
			</div>	
			<div class="sh-single">
				<p class="sh-time">09 Feb 2026, 06:11</p>
				<p class="sh-success">Success</p>
			</div>	
			<div class="sh-single no-border">
				<p class="sh-time">09 Feb 2026, 01:20</p>
				<p class="sh-success">Success</p>
			</div>																								
		</div>					
	</div>
</div>
@endsection
		