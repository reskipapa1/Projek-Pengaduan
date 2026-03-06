<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex px-4 py-2 bg-green-400 border border-transparent rounded-md text-left font-semibold text-white text-green uppercase tracking-widest hover:bg-white hover:text-green-500 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
