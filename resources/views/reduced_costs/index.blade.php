<x-layout>
    <x-slot:title>Reduced costs</x-slot:title>

    <main>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold underline text-gray-300 mb-5">
                Reduced costs for {{ $budget->name }}
            </h1>
            <x-budgets.tabs :$budget />


            <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
                @if (session('status'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="font-medium">{{ session('status') }}</span>
                    </div>
                @endif


                <div class ="mt-5 mb-3 flex flex-1">

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">
                                amount
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $record)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $record->cost->description }}
                                </th>
                                <td class="px-6 py-4">
                                    <span class="text-red-600">&euro; - {{ number_format($record->amount/100,2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span> {{ date_format($record->created_at,'d-m-Y H:i') }} </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('reduce.destroy', $record->id) }}">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" onclick="return confirm('Are you sure you want to delete {{ $record->cost->description }} from {{ $record->created_at }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>
</x-layout>
