<x-layout title="Nova Categoria">
    <x-categorias.elementsform title="Nova Categoria" titleedit=""/>
    <x-categorias.form :action="route('categoria.store')" :nome="old('nome')" :update="false"/>
</x-layout>