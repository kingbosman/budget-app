<x-layout>
    <x-slot:title>Budget</x-slot:title>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold underline text-gray-300">
                Select Budget
            </h1>
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">{{ session('status') }}</span>
                </div>
            @endif
            <div class ="mt-5 mb-3">
                <a href="{{ route('budgets.create') }}" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">+ Add budget</a>
            </div>
            <div role="list" class="divide-y divide-gray-100 pt-3">
                @foreach($budgets as $budget)
                    <a href ="{{ route('budgets.show', ['budget' => $budget]) }}" class="flex justify-between gap-x-6 py-5 hover:bg-gray-200 p-6 group">
                        <div class="flex min-w-0 gap-x-4">
                            <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://cdn0.iconfinder.com/data/icons/content-5/100/bill-512.png" alt="">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-300 group-hover:text-black">{{ $budget->name }}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-gray-500">Created on: {{ date_format($budget->created_at, 'd-m-Y') }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </main>
</x-layout>
