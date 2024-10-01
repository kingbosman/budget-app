<x-layout>
    <x-slot:title>Budget</x-slot:title>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold underline">
                Select Budget
            </h1>


            <ul role="list" class="divide-y divide-gray-100 pt-3">
                @foreach($budgets as $budget)
                    <a href ="#"><li class="flex justify-between gap-x-6 py-5 hover:bg-gray-200 p-6">
                        <div class="flex min-w-0 gap-x-4">
                            <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://cdn0.iconfinder.com/data/icons/content-5/100/bill-512.png" alt="">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">{{ $budget->name }}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-gray-500">Created on: {{ date_format($budget->created_at, 'd-m-Y') }}</p>
                            </div>
                        </div>
                        </li></a>
                @endforeach
            </ul>


        </div>

    </main>







</x-layout>
