<style>
 .btn-primary{
    background-color: #E3D924;
    color: #2E282A;
    border: none;
    margin: 0.5%;
}
</style>
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest  focus:outline-none   btn-primary p-2 text-white']) }}>
    {{ $slot }}
</button>
