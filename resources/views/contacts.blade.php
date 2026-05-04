@extends('main')

@section('title', 'Contatos')

@section('content')
    <div class="w-full h-full">
        {{-- CABEÇALHO --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white">Contatos</h1>
                <p class="text-white">Aqui você pode gerenciar seus contatos.</p>
            </div>

            @auth
                <div class="flex justify-end">
                    <a href="{{ route('login.logout') }}">
                        <button type="button" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Sair
                        </button>
                    </a>
                </div>
            @else
                <div class="flex justify-end">
                    <a href="{{ route('login.index') }}">
                        <button type="button" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Login
                        </button>
                    </a>
                </div>
            @endauth
        </div>

        {{-- FILTROS --}}
        <div class="mb-6">
            <form action="{{ route('contacts.index') }}" method="get" class="flex">
                <input 
                    name="search" 
                    type="text" 
                    placeholder="Pesquisar contatos..." 
                    class="w-full bg-slate-700 border border-slate-600 text-white rounded px-3 py-2"
                    value="{{ request()->input('search') }}"
                >
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                </button>
            </form>
        </div>

        {{-- TABELA --}}
        <div>
            @auth
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('contacts.show') }}">
                        <button type="button" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Novo contato
                        </button>
                    </a>
                </div>
            @endauth

            <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                <table class="min-w-full text-sm text-left text-gray-300">
                    <!-- HEADER -->
                    <thead class="bg-slate-700 text-gray-200 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 font-bold">#</th>
                            <th class="px-6 py-3 font-bold">Nome</th>
                            <th class="px-6 py-3 font-bold">Email</th>
                            <th class="px-6 py-3 font-bold">Contato</th>
                            <th class="px-6 py-3 font-bold">Ações</th>
                        </tr>
                    </thead>
    
                    <!-- BODY -->
                    <tbody class="divide-y divide-slate-700">
                        @if ($contacts->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-400">Nenhum contato encontrado.</td>
                            </tr>
                        @else
                            @foreach ($contacts as $contact)
                                <tr class="hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 font-medium text-white">{{ $contact->id }}</td>
                                    <td class="px-6 py-4">{{ $contact->name }}</td>
                                    <td class="px-6 py-4">{{ $contact->email }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $value = preg_replace('/\D/', '', $contact->contact);
                                            echo(substr($value, 0, 5) . '-' . substr($value, 5, 4));
                                        @endphp
                                    </td>
                                    <td class="px-6 py-4">
                                        @auth
                                            <a href="{{ route('contacts.show', ['id' => $contact->id]) }}">
                                                <button class="cursor-pointer bg-emerald-600/20 text-emerald-400 px-2 py-1 rounded text-xs">Editar</button>
                                            </a>
                                            <form action="{{ route('contacts.delete', ['id' => $contact->id]) }}" method="post" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cursor-pointer bg-red-600/20 text-red-400 px-2 py-1 rounded text-xs">Excluir</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 text-xs">Faça login para editar ou excluir</span>
                                        @endauth
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection