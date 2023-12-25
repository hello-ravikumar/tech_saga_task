<x-guest-layout>

    <center>
        <h3 class="pb-3">Customer {{__('text.logintext')}}</h3>
    </center>
    <div class="form-style">
        <form method="POST" action="{{ route('login') }}" id="LoginForm">
            @csrf
            <div class="form-group pb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="form-control block mt-1 w-full" type="email" name="email"
                    :value="old('email')" autocomplete="username" placeholder="Email" />
                <span class="error-message-email text-danger"></span>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
            </div>
            <div class="form-group pb-3">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input type="password" placeholder="Password" class="form-control block mt-1 w-full"
                    id="password" type="password" name="password" autocomplete="current-password" />
                <span class="error-message-password text-danger"></span>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger err" />
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center cala"><input name="" type="checkbox" value="" />&nbsp;
                    <span class="pl-2 font-weight-bold">Remember Me</span>
                </div>
            </div>
            <div class="pb-2">
                <button type="submit" class="btn btn-info w-100 font-weight-bold mt-2">{{__('text.logintext')}}</button>
            </div>
        </form>

        <div class="pt-4 text-center">
            <div class="pb-2">
                <a href="{{ route('otp.login') }}"
                    class="btn btn-success w-100 font-weight-bold mt-2">{{__('text.otp_login')}}</a>
            </div>{{__('text.create_account')}}. <a href="{{ route('register') }}">{{__('text.registertext')}}</a>
        </div>
    </div>

    <script>
        $('#LoginForm').submit(function (e) {
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