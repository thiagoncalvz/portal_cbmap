<x-layout title="Novo Regulamento" titleedit="">
    <x-regulamentos.form :action="route('regulamentos.store')" :titulo="old('titulo')" :resumo="old('resumo')" :obs="old('obs')" :update="false"/>
</x-layout>