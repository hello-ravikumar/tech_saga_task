<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark-800 dark:text-dark-200 leading-tight">
            {{__('text.dashboard')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-dark-100">
                    {{__('text.task')}}
                </div>
                <div class="p-6 text-gray-900 dark:text-dark-100">
                    <button class="btn btn-primary" id="addNewTask">Create
                        task</button>
                </div>
            </div>
            <div class="tabe table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Created By</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($tasks) > 0)

                        @foreach ($tasks as $key => $task)
                        <tr>
                            <th scope="row">{{ $key + 1}}</th>
                            <td>{{ $task->title}}</td>
                            <td>{{ $task->userName->name }}</td>
                            <td>{{ $task->description}}</td>
                            <td>
                                @if ($task->status == "Open")
                                <button class="btn btn-secondary">{{ $task->status}}</button>
                                @elseif($task->status == "Inprogress")
                                <button class="btn btn-warning">{{ $task->status}}</button>
                                @else
                                <button class="btn btn-success">{{ $task->status}}</button>
                                @endif

                            </td>
                            <td>
                                <button class="btn btn-info getTaskEditForm"
                                    data-uri="{{ route('tasks.edit', $task->id) }}">Edit</button>
                                @if(Auth::user()->id == $task->user_id)
                                <button class="btn btn-info deletTask"
                                    data-uri="{{ route('tasks.destroy', $task->id) }}">Delete</button>
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
    <div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('tasks.store') }}" method="POST" id="createTaskForm">
                @csrf
                <div class="modal-content" id="createTaskModalBody">

                </div>
            </form>

        </div>
    </div>
    {{-- Edit task modal --}}
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" id="editTaskForm">
                @csrf
                @method('patch')
                <div class="modal-content" id="editTaskModalBody">

                </div>
            </form>

        </div>
    </div>
    {{-- delete task modal --}}
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="deleteTaskModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" id="deleteTaskForm">
                @csrf
                @method('delete')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalHeading">Delete Task</h5>
                    </div>
                    <div class="modal-body">
                        <h1>Are Sure want to delete this task?</h1>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="deleteModalClose">Cancel</button>
                        <button type="submit" class="btn btn-danger text-dark">Delete</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <script>
        $(document).ready(function () {
            // get task create form
            $("#addNewTask").on("click", function() {
                let baseURI = "{{ route('tasks.create')}}";
                $.ajax({
                    url: baseURI,
                    method: "GET",
                    success: function(response) {
                        $('#createTaskModalBody').html(response.html);
                        $('#createTaskModal').modal('show');
                    
                    },
                    error: function(error) {
                        console.error("Error:", error);
                    }
                });
            });

            // create task
            $('#createTaskForm').submit(function (e) {
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
                            $('#createTaskModal').modal('hide')
                        
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            });

            // get edit form
            $(".getTaskEditForm").on("click", function() {
                let baseURI = $(this).attr("data-uri");
                $.ajax({
                    url: baseURI,
                    method: "GET",
                    success: function(response) {
                        $('#editTaskForm').attr("action",response.fromUri);
                        $('#taskModalHeading').html("Edit Task")
                        $('#editTaskModalBody').html(response.html);
                        $('#editTaskModal').modal('show');
                    
                    },
                    error: function(error) {
                        console.error("Error:", error);
                    }
                });
            });

            // update task
            $('#editTaskForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'PATCH',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.status) {
                        toastr.success(response.message);
                        setTimeout(() => {
                        location.reload();
                        }, 2000);
                        $('#createTaskModal').modal('hide')
                        
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            });

            // delete task
            $(".deletTask").on("click", function() {
                let baseURI = $(this).attr("data-uri");
                $('#deleteTaskForm').attr("action",baseURI);
                $('#deleteTaskModal').modal('show');
            });
            
            $("#deleteModalClose").on("click", function() {
                $('#deleteTaskModal').modal('hide');
            })
            $('#deleteTaskForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'DELETE',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.status) {
                            toastr.success(response.message);
                            setTimeout(() => {
                            location.reload();
                        }, 2000);
                        $('#deleteTaskModal').modal('hide')
                        
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            });
        })
        

    </script>
</x-app-layout>