@props(['title' => 'Dashboard'])

<div class="mb-6 pb-4 border-b border-gray-200 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            {{ $title }}
        </h1>
    </div>
    
    @if(isset($actions))
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
            {{ $actions }}
        </div>
    @endif
</div>