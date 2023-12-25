<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{__('text.customer')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-dark dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mbile Nunber</th>
                                <th>Email</th>
                                <th>Date Of Birth</th>
                                <th>Gender</th>
                                <th>Verification Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($customers) > 0)
                            @foreach($customers as $key => $customer)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{$customer->name}}</td>
                                <td>
                                    <a href="tel:{{$customer->contact_number}}"
                                        class="btn btn-secondary">{{$customer->contact_number}}</a>

                                </td>
                                <td><a href="mailto:{{$customer->email}}" target="blank"
                                        class="btn btn-secondary">{{$customer->email}}</a></td>
                                <td>{{$customer->date_of_birth}}</td>
                                <td>{{$customer->gender}}</td>
                                <td>
                                    @if ($customer->verification == "pending")
                                    <button class="btn btn-info verifyCustomer"
                                        data-id={{$customer->id}}>{{$customer->verification}}</button>
                                    @elseif($customer->verification == "approve")
                                    <button class="btn btn-success verifyCustomer"
                                        data-id={{$customer->id}}>{{$customer->verification}}</button>
                                    @else
                                    <button class="btn btn-danger verifyCustomer"
                                        data-id={{$customer->id}}>{{$customer->verification}}</button>
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bg-dark" id="customerVrificationModal" tabindex="-1" role="dialog"
        aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" id="customerVerificationForm">
                <div class="modal-content" id="customerModalBody">


                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".verifyCustomer").on("click", function() {
                let customerId = $(this).attr("data-id");
                let baseURI = "{{ url('admin/get-customer')}}";
                $.ajax({
                    url: `${baseURI}/${customerId}`, 
                    method: "GET",
                    success: function(response) {
                        $('#customerVerificationForm').attr("action",response.fromUri);
                        $('#customerModalBody').html(response.html);
                        $('#customerName').html(response.data.name);
                        $('#customerVrificationModal').modal('show');
                        
                    },
                    error: function(error) {
                        
                        console.error("Error:", error);
                    }
                });
            });

           
        })
        $("#customerModalClose").on("click", function() {
            $('#customerVrificationModal').modal('hide')
        })
        $('#customerVerificationForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                        $('#customerVrificationModal').modal('hide')
                        
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
    </script>
</x-admin-layout>