<section>
    <header>
        <h2 class="text-lg font-medium text-dark-900 dark:text-dark-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-dark-600 dark:text-dark-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>
    <div class="form-style">
        <form method="POST" id="editCustomer" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            <!-- Name -->
            <div class="form-group pb-3">
                <label for="name">Name</label>
                <input id="name" class="block mt-1 w-full form-control" type="text" name="name" value="{{$user->name}}"
                    autofocus autocomplete="name" placeholder="Enter Name" />
                <span class="error-message-name text-danger"></span>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- Email -->
            <div class="form-group pb-3">
                <label for="email">Email</label>
                <input id="email" class="form-control block mt-1 w-full" type="email" name="email"
                    value="{{ $user->email }}" autocomplete="email" placeholder="Enter Email" />
                <span class="error-message-email text-danger"></span>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Contact Number -->
                    <div class="form-group pb-3">
                        <label for="contact_number">Contact Number</label>
                        <input id="contact_number" class="form-control block mt-1 w-full" type="text"
                            name="contact_number" value="{{$user->contact_number}}" autocomplete="contact_number"
                            placeholder="Enter Contact Number"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value =this.value.replace(/(\..*)\./g, '$1');"
                            pattern="[6789][0-9]{9}" />
                        <span class="error-message-contact_number text-danger"></span>
                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2 text-danger" />
                    </div>
                </div>

                <!-- Date of Birth -->
                <div class=" col-md-6 form-group pb-3">
                    <label for="date_of_birth">Date of Birth</label>
                    <input id="date_of_birth" class="form-control block mt-1 w-full" type="date" name="date_of_birth"
                        value="{{ $user->date_of_birth }}" autocomplete="date_of_birth" placeholder="Date of birth" />
                    <span class="error-message-date_of_birth text-danger"></span>
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2 text-danger" />
                </div>
                <!-- Gender -->
                <div class=" col-md-6 form-group pb-3">
                    <label for="gender">Gender</label>
                    <select id="gender" class="form-control block mt-1 w-full" type="date" name="gender"
                        aria-label="Default select">
                        <option selected disabled>-- Select Gender --</option>
                        <option value="male" {{$user->gender == 'male' ? 'selected' : ''}}>Male</option>
                        <option value="female" {{$user->gender == 'female' ? 'selected' : ''}}>Female</option>
                    </select>
                    <span class="error-message-gender text-danger"></span>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2 text-danger" />
                </div>

            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="btn btn-info form-control">{{ __('Save') }}</button>

                @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-dark-600 dark:text-dark-400">{{ __('Saved.') }}</p>
                @endif
            </div>

        </form>
    </div>


</section>