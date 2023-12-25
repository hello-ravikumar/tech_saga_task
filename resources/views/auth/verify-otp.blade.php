<div class="alert alert-success" role="alert">
    {{ $message }}
</div>
@csrf
<x-text-input type="hidden" value="{{ $user_id }}" name="user_id" />

<div class="form-group pb-3">
    <x-input-label for="otp" :value="__('Enter OTP')" /><span class="mt-2 text-danger">*</span>
    <x-text-input id="otp" class="form-control block mt-1 w-full" type="text" name="otp" :value="old('otp')"
        autocomplete="otp" placeholder="Enter OTP"
        oninput="this.value = this.value.replace(/[^0-9.]/g,''); this.value =this.value.replace(/(\..*)\./g, '$1');"
        maxlength="6" maxlength="6" />
    <span class="error-message-otp text-danger"></span>
    <x-input-error :messages="$errors->get('otp')" class="mt-2 text-danger" />
</div>

<div class="pb-2">
    <button type="submit" class="btn btn-info w-100 font-weight-bold mt-2">Verify and Login</button>
</div>