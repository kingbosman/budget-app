<x-layout>
    <x-slot:title>Budget</x-slot:title>

    <main>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold underline text-gray-300 mb-5">
                {{ $budget->name }}
            </h1>
            <x-budgets.tabs :$budget />
            <div class ="mt-5 mb-3 flex flex-1">
                <div class="flex flex-1 sm:items-stretch justify-start">
                    <a href="{{ route('incomes.create', $budget) }}" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">+ Create income</a>
                </div>
                <div class="flex flex-1 sm:items-stretch justify-end">
                    <a href="{{ route('splits.index', $budget) }}" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Split settings</a>
                </div>
            </div>

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
                @if ($income_percentages > 100)
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-orange-500" role="alert">
                        <span class="font-medium">Split percentages are at {{ round($income_percentages, 2) }}%, consider lowering minimum amounts</span>
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
                        <th scope="col" class="px-6 py-3">
                            Received
                        </th>
                        <th scope="col" class="px-6 py-3 text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($incomes as $income)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $income->name }}
                                </th>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('incomes.update', $income) }}">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="form_type" value="update_amount">
                                        <input type="text" name="amount" id="amount" class="bg-gray-800 text-gray-100 text-xs hover:border-blue-800" value="{{ number_format($income->amount / 100, 2, thousands_separator: '') }}">
                                        <button class="hidden" type="submit"></button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('incomes.update', $income) }}">
                                        @method('patch')
                                        @csrf
                                        <input type="hidden" name="form_type" value="update_is_received">
                                        <input type="checkbox" name="is_received" id="is_received" class="bg-gray-800 hover:border-blue-800" @if($income->is_received) checked @endif onChange="this.form.submit()">
                                    </form>

                                </td>
                                <td>
                                    <form method="POST" action="{{ route('incomes.destroy', $income) }}">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete {{ $income->name }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        <tr class="border-t-2 border-black odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="col" class="px-6 py-3 text-xl"> Total income </th>
                            <td class="font-bold text-lg"> &euro; {{ number_format($total['income'] ,2) }}</td>
                            <td class="font-bold text-lg"> {{ round($total['percentage']['income'],2) }} % </td><td colspan="2">
                            <td></td>
                        </tr>
                        <tr class="border-t-2 border-black odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="col" class="px-6 py-3 text-xl"> Total bills </th>
                            <td class="font-bold text-lg"> &euro; {{ number_format($total['cost'] ,2) }}</td>
                            <td class="font-bold text-lg"> {{ round($total['percentage']['cost'],2) }} % </td><td colspan="2">
                            <td></td>
                        </tr>
                        <tr class="border-t-2 border-black odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="col" class="px-6 py-3 text-xl"> Remainder </th>
                            <td class="font-bold text-lg"> &euro; {{ number_format($total['remainder'], 2) }}</td>
                            <td class="font-bold text-lg"> {{ round($total['percentage']['remainder'],2) }} % </td><td colspan="2">
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Split %
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($splits as $key => $split)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $key }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ round($split['percentage'], 2) }} %
                                </td>
                                <td class="px-6 py-4">
                                    &euro; {{ number_format($split['amount'],2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </main>
</x-layout>
