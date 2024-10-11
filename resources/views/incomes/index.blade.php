<x-layout>
    <x-slot:title>Budget</x-slot:title>

    <main>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold underline text-gray-300 mb-5">
                {{ $budget->name }}
            </h1>
            <x-budgets.tabs :$budget />

            <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
                @if (session('status'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="font-medium">{{ session('status') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-500" role="alert">
                        <span class="font-medium">{{ $errors->first() }}</span>
                    </div>
                @endif

                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Income name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Eur
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($incomes as $income)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $income->name }}
                                </th>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('income.update', $income) }}">
                                        @csrf
                                        @method('patch')
                                        <input type="text" name="amount" id="amount" class="bg-gray-800 text-gray-100 text-xs hover:border-blue-800" value="{{ $income->amount / 100 }}">
                                        <button class="hidden" type="submit"></button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('income.destroy', $income) }}">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>

    </main>
</x-layout>
