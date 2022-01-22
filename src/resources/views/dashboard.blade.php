<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col">

                    <div
                        class="p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md
                                              dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Number of messages in queue: {{ $num_jobs }}
                        </h5>
                    </div>


                    <div
                        class="p-6 mt-2 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md
                                              dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Sent Messages: {{ $sent_messages_count }}
                        </h5>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
