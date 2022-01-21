<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6  border-b border-gray-200 shadow flex flex-col justify-center">



                    <table class="table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-medium text-gray-500 uppercase tracking-wider">
                                    Mobile
                                </th>
                                <th scope="col" class="px-6 py-3  font-medium text-gray-500 uppercase tracking-wider">
                                    Message
                                </th>
                                <th scope="col" class="px-6 py-3  font-medium text-gray-500 uppercase tracking-wider">
                                    SMS Provider
                                </th>
                                <th scope="col" class="px-6 py-3  font-medium text-gray-500 uppercase tracking-wider">
                                    sender
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($reports as $report)
                                <tr class={{ $loop->index % 2 == 0 ? '' : 'bg-gray-100' }}>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $report->mobile }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- <div class="text-sm text-gray-900">Regional Paradigm Technician</div> --}}
                                        {{-- <div class="text-sm text-gray-500">Optimization</div> --}}
                                        {{ $report->message }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $report->sms_provider }}
                                        {{-- <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span> --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $report->sender }}
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>

                    <div class="py-2">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
