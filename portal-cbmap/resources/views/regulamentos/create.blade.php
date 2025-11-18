<x-layout title="Novo Regulamento">
    <x-regulamentos.elementsform title="Novo Regulamento" titleedit=""/>
    <x-regulamentos.form
        :action="route('regulamentos.store')"
        :titulo="old('titulo')"
        :resumo="old('resumo')"
        :obs="old('obs')"
        :categorias="$categorias"
        :categoria="old('categoria')"
        :update="false"/>
</x-layout>