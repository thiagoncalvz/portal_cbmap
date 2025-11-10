<x-layout title="Novo Regulamento">
    <x-regulamentos.form :action="route('regulamentos.store')" :titulo="old('titulo')" :update="false"/>
</x-layout>