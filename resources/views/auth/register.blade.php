<x-guest-layout>
    <center>
        <h3 class="pb-3">Customer {{__('text.registertext')}}</h3>
    </center>
    <div class="form-style">
        <form method="POST" id="createCustomer" action="{{ route('register') }}">
            @csrf
            <!-- Name -->
            <div class="form-group pb-3">
                <x-input-label for="name" :value="__('Name')" /><span class="mt-2 text-danger">*</span>
                <x-text-input id="name" class="block mt-1 w-full form-control" type="text" name="name"
                    :value="old('name')" autofocus autocomplete="name" placeholder="Enter Name" />
                <span class="error-message-name text-danger"></span>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- Email -->
            <div class="form-group pb-3">
                <x-input-label for="email" :value="__('Email')" /><span class="mt-2 text-danger">*</span>
                <x-text-input id="email" class="form-control block mt-1 w-full" type="email" name="email"
                    :value="old('email')" autocomplete="email" placeholder="Enter Email" />
                <span class="error-message-email text-danger"></span>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Contact Number -->
                    <div class="form-group pb-3">
                        <x-input-label for="contact_number" :value="__('Contact Number')" /><span
                            class="mt-2 text-danger">*</span>
                        <x-text-input id="contact_number" class="form-control block mt-1 w-full" type="text"
                            name="contact_number" :value="old('contact_number')" autocomplete="contact_number"
                            placeholder="Enter Contact Number"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value =this.value.replace(/(\..*)\./g, '$1');"
                            pattern="[6789][0-9]{9}" />
                        <span class="error-message-contact_number text-danger"></span>
                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2 text-danger" />
                    </div>
                </div>

                <!-- Date of Birth -->
                <div class=" col-md-6 form-group pb-3">
                    <x-input-label for="date_of_birth" :value="__('Date of Birth')" /><span
                        class="mt-2 text-danger">*</span>
                    <x-text-input id="date_of_birth" class="form-control block mt-1 w-full" type="date"
                        name="date_of_birth" :value="old('date_of_birth')" autocomplete="date_of_birth"
                        placeholder="Email" />
                    <span class="error-message-date_of_birth text-danger"></span>
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2 text-danger" />
                </div>
                <!-- Gender -->
                <div class=" col-md-6 form-group pb-3">
                    <x-input-label for="gender" :value="__('Gender')" /><span class="mt-2 text-danger">*</span>
                    <select id="gender" class="form-control block mt-1 w-full" type="date" name="gender"
                        aria-label="Default select">
                        <option selected disabled>-- Select Gender --</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <span class="error-message-gender text-danger"></span>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2 text-danger" />
                </div>

            </div>


            <!-- Password -->
            <div class="form-group pb-3">
                <x-input-label for="password" :value="__('Password')" /><span class="mt-2 text-danger">*</span>
                <input type="password" placeholder="Enter Password" class="form-control block mt-1 w-full" id="password"
                    type="password" name="password" autocomplete="current-password" />
                <span class="error-message-password text-danger"></span>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
            </div>
            <!-- Confirm Password -->
            <div class="form-group pb-3">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" /><span
                    class="mt-2 text-danger">*</span>

                <x-text-input id="password_confirmation" class="form-control block mt-1 w-full" type="password"
                    name="password_confirmation" autocomplete="new-password" placeholder="Enter Confirm Password" />
                <span class="error-message-password_confirmation text-danger"></span>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
            </div>
            <div class="pb-2">
                <button type="submit"
                    class="btn btn-info w-100 font-weight-bold mt-2">{{__('text.registertext')}}</button>
            </div>
        </form>
        <div class="pt-4 text-center">{{__('text.login_account')}} <a
                href="{{ route('login') }}">{{__('text.logintext')}}</a>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#createCustomer').submit(function (e) {
                e.preventDefault();
            
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (response) {
                        window.location.href = response.redirect_uri;
                    },
                    error: function (data) {
                    
                        try {
                            var errorData = JSON.parse(data.responseText);
                            $.each(errorData.errors, function (field, messages) {
                                var input = $('[name="' + field + '"]');
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
    </script>
</x-guest-layout>