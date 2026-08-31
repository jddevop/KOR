@extends('layouts.app')
@section('title', 'Bank Detail')
@section('content')
<div class="row">
	<div class="col-12">
		<form action="{{ route('do_update_bank_detail') }}" method="post" enctype="multipart/form-data">
			 @csrf
			<div class="ubd-box">
				<h2>Bank Account Information</h2>
				
				<div class="mb-3">
					<label class="form-label">Account Holder Name </label> 
					<input type="text" class="form-control" placeholder="Enter beneficiary name" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name') != '' ? old('account_holder_name') : (isset($data['account_holder_name']) ? $data['account_holder_name'] : '') }}">
					@error('account_holder_name')
    					<p id="error_message" class="text-danger">{{ $message }}</p>
    				@enderror
				</div>	

				<div class="mb-3">
					<label class="form-label">Home Address</label>
					<textarea class="form-control"  placeholder="Enter home address" rows="3" id="home_address" name="home_address">{{ old('home_address') != '' ? old('home_address') : (isset($data['home_address']) ? $data['home_address'] : '') }}</textarea>
					@error('home_address')
    					<p id="error_message" class="text-danger">{{ $message }}</p>
    				@enderror
				</div>	
				
				<div class="mb-3">
					<label class="form-label">IBAN (No spaces)</label>
					<input type="text" class="form-control" placeholder="IE29AIBK93115212345678" id="iban" name="iban" value="{{ old('iban') != '' ? old('iban') : (isset($data['iban']) ? $data['iban'] : '') }}">
					<h6 class="mt-2">Enter IBAN without spaces </h6>
					<h6>(Example: IE29AIBK93115212345678)</h6>								
					@error('iban')
    					<p id="error_message" class="text-danger">{{ $message }}</p>
    				@enderror
				</div>	

				<div class="mb-0">
					<label class="form-label">Bank Address</label>
					<textarea class="form-control"  placeholder="Enter bank address" rows="3" id="bank_address" name="bank_address">{{ old('bank_address') != '' ? old('bank_address') : (isset($data['bank_address']) ? $data['bank_address'] : '') }}</textarea>
					@error('bank_address')
    					<p id="error_message" class="text-danger">{{ $message }}</p>
    				@enderror
				</div>								
				
			</div>

			<div class="row mt-3">
				<div class="col-4">
					<a href="{{ route('profile') }}" class="btn btn-secondary ubd-cancel-btn d-flex align-items-center justify-content-center" >cancel</a>
				</div>
				<div class="col-8">
					<button type="submit" class="btn btn-secondary ubd-save-btn">save bank details</button>								
				</div>
			</div>

		</form>
	</div>
</div>
@endsection
		