<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }} {{__('text.dashboard')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-dark dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="heading">
                        <h2>{{__('text.task')}}</h2>
                    </div>
                    <div class="tabe table-responsive">
                        <table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Status</th>
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

                                </tr>
                                @endforeach
                                @endif


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-admin-layout>