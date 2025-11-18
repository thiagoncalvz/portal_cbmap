<x-layout title="Editar Categoria:">
    <x-categorias.elementsform title="Editar Categoria: " titleedit="'{!!$categoria->nome!!}'"/>
    <x-categorias.form :action="route('categoria.update', $categoria->id)" :nome="$categoria->nome" :update="true"/>
</x-layout>