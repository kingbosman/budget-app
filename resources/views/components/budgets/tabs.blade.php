@props([
    'budget' => false
])
@php
        $active = 'inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500';
        $idle = 'inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300';
@endphp
<ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
    <li class="me-2">
        <a href="{{ route('budgets.show', $budget) }}" aria-current="{{ request()->is('budgets*') ? 'page' : 'false' }}" class="{{ request()->is('budgets*') ? $active : $idle}}">Budget</a>
    </li>
    <li class="me-2">
        <a href="{{ route('incomes.index', $budget) }}" aria-current="{{ request()->is('income*') ? 'page' : 'false' }}" class="{{ request()->is('income*') ? $active : $idle}}">Income</a>
    </li>
    <li class="me-2">
        <a href="{{ route('reduce.index', $budget) }}" aria-current="{{ request()->is('reduce*') ? 'page' : 'false' }}" class="{{ request()->is('reduce*') ? $active : $idle}}">Reduced</a>
    </li>
</ul>
