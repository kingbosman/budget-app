<x-layout>
    <x-slot:title>Budget</x-slot:title>

    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold underline text-gray-300">
                {{ $budget->name }}
            </h1>
            <div class ="mt-5 mb-3 flex flex-1">
                <div class ="flex flex-1 sm:items-stretch justify-start">
                    <a href="{{ route('costs.create', $budget) }}" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">+ New record</a>
                </div>
                <div class ="flex flex-1 sm:items-stretch justify-end">
                    <a href="{{ route('costs.create', $budget) }}" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Settings</a>
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

                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Eur
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Paid
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($costs as $cost)
                        <form action="{{ route('costs.update', $cost) }}" method="post">
                            @csrf
                            @method('patch')
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $cost->description }}
                                </th>
                                <td class="px-6 py-4">
                                    <input type="text" name="amount" id="amount" class="bg-gray-800 text-gray-100 text-xs hover:border-blue-800" value="{{ number_format($cost->amount / 100, 2, '.', '') }}">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" name="category" id="category" class="bg-gray-800 text-gray-100 text-xs hover:border-blue-800" value="{{ ucfirst($cost->category) }}">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="paid" id="paid" class="bg-gray-800 hover:border-blue-800" @if($cost->paid) checked @endif onChange="this.form.submit()">
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('costs.destroy', $cost) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Delete {{ $cost->description }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </form>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>

    </main>
</x-layout>
