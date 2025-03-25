<a href="{{ $route !== '#' ? route($route) : '#' }}" 
   class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-700 hover:text-white 
          {{ Route::currentRouteName() === ($route !== '#' ? $route : null) ? 'bg-gray-800 text-white' : 'text-gray-300' }}">
    {{ $name }}
</a>
