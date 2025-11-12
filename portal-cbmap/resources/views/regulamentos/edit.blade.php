<x-layout title="Editar Regulamento: " titleedit="'{!!$regulamento->titulo!!}'">
    <x-regulamentos.form :action="route('regulamentos.update', $regulamento->id)" :titulo="$regulamento->titulo" :resumo="$regulamento->resumo" :obs="$regulamento->obs" :update="true"/>
</x-layout>