<x-layout title="Editar Regulamento '{!!$regulamento->titulo!!}'">
    <x-regulamentos.form :action="route('regulamentos.update', $regulamento->id)" :titulo="$regulamento->titulo" :update="true"/>
</x-layout>