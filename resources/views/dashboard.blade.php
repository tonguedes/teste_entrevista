<x-app-layout>
    <!-- Define the header section of the page -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Page title -->
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>

            <!-- Link button to the products page -->
            <a href="{{ url('/produtos') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md
                      font-semibold text-xs text-white uppercase tracking-widest
                      hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                      focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25
                      transition ease-in-out duration-150">
                Início (Produtos) <!-- Button text -->
            </a>
        </div>
    </x-slot>

    <!-- Main content section -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome card -->
            <div class="p-6 bg-white border border-slate-100 rounded-xl shadow-sm">
                <h1 class="text-2xl font-semibold text-slate-800">
                    Bem-vindo, {{ auth()->user()->name }} 👋
                </h1>
                <p class="mt-2 text-sm text-slate-600">
                    Fico feliz que você tenha entrado — abaixo está o painel de produtos para você gerenciar o catálogo.
                </p>
            </div>

            {{-- Livewire CRUD dashboard component --}}
            <div>
                <livewire:produtos-dashboard /> <!-- Mounts the Livewire dashboard component for managing products -->
            </div>
        </div>
    </div>
</x-app-layout>
