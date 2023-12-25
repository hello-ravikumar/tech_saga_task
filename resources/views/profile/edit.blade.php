<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 dark:text-dark-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
                $('#editCustomer').submit(function (e) {
                    e.preventDefault();
                
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        success: function (response) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                            
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
</x-app-layout>