<x-guest-layout>

    <center>
        <h3 class="pb-3">Customer Login</h3>
    </center>

    <div class="form-style">
        <form method="POST" action="{{ route('otp.generate') }}" id="sendOtpForm">
            @csrf
            <div class="form-group pb-3">
                <x-input-label for="mobile_number" :value="__('Mobile Number')" /><span
                    class="mt-2 text-danger">*</span>
                <x-text-input id="mobile_number" class="form-control block mt-1 w-full" type="text" name="mobile_number"
                    :value="old('mobile_number')" autocomplete="mobile_number" placeholder="Enter Mobile Number"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value =this.value.replace(/(\..*)\./g, '$1');"
                    pattern="[6789][0-9]{9}" />
                <span class="error-message-mobile_number text-danger"></span>
                <x-input-error :messages="$errors->get('mobile_number')" class="mt-2 text-danger" />
            </div>

            <div class="pb-2" id="sendOtpButton">
                <button type="submit" class="btn btn-info w-100 font-weight-bold mt-2">Send OTP</button>
            </div>
        </form>

        <form method="POST" action="{{ route('otp.getlogin') }}" id="verifyOtpForm">
            <div id="verifyOtp">

            </div>
            <div id="OtpError">
            </div>
        </form>


        <div class="pt-4 text-center">
            Don't have account. <a href="{{ route('register') }}">Register</a>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#sendOtpForm').submit(function (e) {
                e.preventDefault();
            
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#sendOtpButton').remove();
                            $('#mobile_number').attr('readonly');
                            $('#verifyOtp').html(response.data);
                        }
                    },
                    error: function (data) {
                    
                        try {
                            let errorData = JSON.parse(data.responseText);
                            $.each(errorData.errors, function (field, messages) {
                                let input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                $(`.error-message-${field}`).html(messages[0])
                            });
                        } catch (e) {
                            console.error('Error parsing JSON response:', e);
                    }
                    }
                });
            });

            
        });

        $('#verifyOtpForm').submit(function (e) {
            e.preventDefault();
        
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status) {
                        window.location.href = response.redirect_uri;
                    }
                },
                error: function (data) {
                    
                
                    try {
                        let errorData = JSON.parse(data.responseText);
                        if (errorData.errors) {
                            $.each(errorData.errors, function (field, messages) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            $(`.error-message-${field}`).html(messages[0])
                            
                            });
                        } else {
                            let message = `<div class="alert alert-danger" role="alert">${errorData.message}</div>`;
                            $('#OtpError').html(message);
                        }
                        
                    } catch (e) {
                        console.error('Error parsing JSON response:', e);
                    }
                }
             });
        });
    </script>
</x-guest-layout>