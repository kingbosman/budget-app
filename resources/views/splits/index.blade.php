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
                    <form method="POST">
                        @csrf
                        <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">+ Create</button>
                    </form>

                </div>
            </div>


            <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Split %
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Minimal amount eur
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Maximum amount eur
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($budget->splits as $split)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">
                                <form method="POST">
                                    @method('patch')
                                    @csrf
                                    <input type="hidden" name="form_type" value="update_name">
                                    <input type="text" name="name" id="name" class="bg-gray-800 text-gray-100 text-xs hover:border-blue-800" value="{{ $split->name }}">
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST">
                                    @method('patch')
                                    @csrf
                                    <input type="hidden" name="form_type" value="update_name">
                                    <input type="text" name="percentage" id="percentage" class="bg-gray-800 text-gray-100 text-xs hover:border-blue-800" value="{{ $split->percentage }}">
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST">
                                    @method('patch')
                                    @csrf
                                    <input type="hidden" name="form_type" value="update_name">
                                    <input type="text" name="minimal" id="minimal" class="bg-gray-800 text-gray-100 text-xs hover:border-blue-800" value="{{ $split->minimal }}">
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST">
                                    @method('patch')
                                    @csrf
                                    <input type="hidden" name="form_type" value="update_name">
                                    <input type="text" name="maximum" id="maximum" class="bg-gray-800 text-gray-100 text-xs hover:border-blue-800" value="{{ $split->maximum }}">
                                </form>
                            </td>
                            <td>
{{--                                split route--}}
                                <form action="#" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete {{ $split->name }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
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
