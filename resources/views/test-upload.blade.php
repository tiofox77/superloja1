@extends('layouts.app')

@section('title', 'Teste de Upload Livewire')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Teste isolado de Upload com Livewire</h1>
    <p class="text-gray-600 mb-8">Use o botão abaixo para abrir a modal e verificar o comportamento do upload temporário.</p>
    <livewire:test-upload-modal />
</div>
@endsection
