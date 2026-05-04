@extends('main')

@section('title', 'Contatos')

@section('content')
    <div class="w-full h-full">
        {{-- CABEÇALHO --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white">
                    {{
                        $contact?->id ? 'Editar Contato' : 'Criar Contato'
                    }}
                </h1>
                <p class="text-white">
                    {{
                        $contact?->id ? 'Edite as informações do contato.' : 'Preencha as informações para criar um novo contato.'
                    }}
                </p>
            </div>
        </div>

        {{-- CAMPOS --}}
        <div class="w-full mb-6 bg-slate-800 p-6 rounded-lg shadow">
            <form action="{{ route('contacts.save') }}" method="post" class="w-full">
                @csrf

                <input type="hidden" name="id" value="{{ $contact?->id ?? '' }}">

                <div class="mb-6 w-full">
                    <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nome</label>
                    <input 
                        type="name" 
                        id="name" 
                        name="name" 
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded px-3 py-2"
                        value="{{ old('name') ?? $contact?->name ?? '' }}"
                    >
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="mb-6 w-full">
                    <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded px-3 py-2"
                        value="{{ old('email') ?? $contact?->email ?? '' }}"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 w-full">
                    <label for="contact" class="block text-gray-300 text-sm font-bold mb-2">Contato</label>
                    <input 
                        type="contact" 
                        id="contact" 
                        name="contact" 
                        class="w-full bg-slate-700 border border-slate-600 text-white rounded px-3 py-2"
                        value="{{ old('contact') ?? $contact?->contact ?? '' }}"
                    >
                    @error('contact')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#contact').mask('00000-0000');
        });
    </script>
@endsection