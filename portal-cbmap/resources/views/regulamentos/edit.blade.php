<x-layout title="Editar Regulamento:">
    <x-regulamentos.elementsform title="Editar Regulamento: " titleedit="'{!!$regulamento->titulo!!}'"/>
    <x-regulamentos.form
        :action="route('regulamentos.update', $regulamento->id)"
        :titulo="$regulamento->titulo"
        :resumo="$regulamento->resumo"
        :obs="$regulamento->obs"
        :categorias="$categorias"
        :categoria="$regulamento->categoria"
        :update="true"/>
</x-layout>