@extends('main')

@section('title', 'Login')

@section('content')
    <div class="w-full h-full flex justify-center items-center">
        <div class="bg-slate-800 p-6 rounded-lg shadow">
            <h1 class="text-2xl font-bold text-white mb-6">Login</h1>

            <form action="{{ route('login.authenticate') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" class="bg-slate-700 border border-slate-600 text-white rounded px-3 py-2">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="mb-6">
                    <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Senha</label>
                    <input type="password" id="password" name="password" class="bg-slate-700 border border-slate-600 text-white rounded px-3 py-2">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection