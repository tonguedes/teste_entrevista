<div class="max-w-6xl mx-auto space-y-6 p-4 sm:p-6 lg:p-0">

  {{-- HEADER DO PAINEL --}}
  <div class="bg-gradient-to-r from-sky-50 to-emerald-50 rounded-2xl p-6 shadow-sm border flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">

    {{-- TÍTULO E DESCRIÇÃO --}}
    <div class="w-full md:w-auto">
      <h2 class="text-2xl font-semibold text-slate-800">Painel de Produtos</h2>
      <p class="text-sm text-slate-600 mt-1">Gerencie os produtos do sistema. Crie, edite e exclua com segurança.</p>
    </div>

    {{-- BOTÕES DE AÇÃO --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
      {{-- Mobile: coluna; SM+: linha --}}
      <div class="flex gap-3 w-full sm:w-auto">
        {{-- Abre modal de criação --}}
        <button wire:click="openCreateModal" class="flex-1 sm:flex-none px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg shadow">
          Novo produto
        </button>
        {{-- Exporta produtos para PDF --}}
        <a href="/api/produtos-export-pdf" target="_blank" class="flex-1 sm:flex-none px-4 py-2 rounded border text-center">
          Imprimir PDF
        </a>
      </div>
    </div>
  </div>

  {{-- TABELA DE PRODUTOS --}}
  <div class="bg-white rounded-2xl shadow border overflow-hidden">
    <div class="overflow-x-auto"> {{-- Permite rolagem horizontal no mobile --}}
      <table class="w-full text-left table-auto">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-6 py-3 text-sm font-medium text-slate-600 whitespace-nowrap">ID</th>
            <th class="px-6 py-3 text-sm font-medium text-slate-600 whitespace-nowrap">Nome</th>
            <th class="px-6 py-3 text-sm font-medium text-slate-600 whitespace-nowrap">Preço (R$)</th>
            <th class="px-6 py-3 text-sm font-medium text-slate-600 whitespace-nowrap">Criado em</th>
            <th class="px-6 py-3 text-sm font-medium text-slate-600">Ações</th> {{-- Botões podem quebrar linha --}}
          </tr>
        </thead>
        <tbody>
          {{-- Loop de produtos --}}
          @forelse($produtos as $p)
          <tr class="odd:bg-white even:bg-slate-50">
            <td class="px-6 py-3 text-sm text-slate-700 whitespace-nowrap">{{ $p['id'] }}</td>
            <td class="px-6 py-3 text-sm text-slate-700 whitespace-nowrap">{{ $p['nome'] }}</td>
            <td class="px-6 py-3 text-sm text-slate-700 whitespace-nowrap">R$ {{ number_format($p['preco'], 2, ',', '.') }}</td>
            <td class="px-6 py-3 text-sm text-slate-500 whitespace-nowrap">{{ $p['created_at'] ?? '-' }}</td>
            <td class="px-6 py-3 text-sm">
              <div class="flex flex-col space-y-1 md:flex-row md:space-y-0 md:gap-2 min-w-[120px]">
                {{-- Botão de edição --}}
                <button wire:click="openEditModal({{ $p['id'] }})" class="px-3 py-1 rounded-md bg-sky-100 text-sky-700 hover:bg-sky-200 text-xs">Editar</button>
                {{-- Botão de exclusão --}}
                <button wire:click="confirmDelete({{ $p['id'] }})" class="px-3 py-1 rounded-md bg-rose-100 text-rose-700 hover:bg-rose-200 text-xs">Excluir</button>
              </div>
            </td>
          </tr>
          @empty
          {{-- Nenhum produto encontrado --}}
          <tr>
            <td colspan="5" class="px-6 py-6 text-center text-slate-500">Nenhum produto encontrado.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- MODAL DE CRIAÇÃO/EDIÇÃO --}}
  @if($isModalOpen)
  <div class="fixed inset-0 flex items-center justify-center z-50 p-4">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/30" wire:click="$set('isModalOpen', false)"></div>
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 z-10 mx-4">
      <h3 class="text-lg font-medium text-slate-800 mb-4">{{ $editingId ? 'Editar Produto' : 'Novo Produto' }}</h3>

      {{-- Formulário --}}
      <div class="space-y-4">
        <div>
          <label class="block text-sm text-slate-600">Nome</label>
          <input wire:model.defer="nome" type="text" class="w-full border rounded px-3 py-2 mt-1" />
          @error('nome') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm text-slate-600">Preço (R$)</label>
          <input wire:model.defer="preco" type="number" step="0.01" class="w-full border rounded px-3 py-2 mt-1" />
          @error('preco') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Botões do modal --}}
      <div class="mt-6 flex justify-end gap-3">
        <button wire:click="$set('isModalOpen', false)" class="px-4 py-2 border rounded-md w-full sm:w-auto">Cancelar</button>
        <button wire:click="save" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-md w-full sm:w-auto">Salvar</button>
      </div>
    </div>
  </div>
  @endif

  {{-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO --}}
  @if($isConfirmingDelete)
  <div class="fixed inset-0 flex items-center justify-center z-50 p-4">
    <div class="absolute inset-0 bg-black/30" wire:click="cancelDelete"></div>
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 z-10 mx-4">
      <h3 class="text-lg font-semibold text-slate-800">Confirmar exclusão</h3>
      <p class="mt-3 text-sm text-slate-600">Tem certeza que deseja excluir este produto? Esta ação não pode ser desfeita.</p>

      <div class="mt-6 flex justify-end gap-3">
        <button wire:click="cancelDelete" class="px-4 py-2 border rounded-md w-full sm:w-auto">Cancelar</button>
        <button wire:click="delete" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-md w-full sm:w-auto">Excluir</button>
      </div>
    </div>
  </div>
  @endif

  {{-- TOAST NOTIFICATIONS --}}
  <script>
    document.addEventListener('livewire:initialized', () => {
      Livewire.on('notify', (event) => {
        const msg = event.message ?? 'Operação concluída';
        const t = document.createElement('div');
        t.textContent = msg;
        t.className = 'fixed bottom-6 right-6 px-4 py-2 rounded shadow bg-slate-800 text-white z-[60] transition-opacity duration-300 ease-out opacity-100';
        document.body.appendChild(t);
        setTimeout(() => {
          t.classList.remove('opacity-100');
          t.classList.add('opacity-0');
          setTimeout(() => t.remove(), 300);
        }, 2500);
      });
    });
  </script>

</div>
