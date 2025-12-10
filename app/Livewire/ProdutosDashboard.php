<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ProdutoService;
use Illuminate\Support\Str;

class ProdutosDashboard extends Component
{
    // Array that holds all products displayed in the dashboard
    public array $produtos = [];

    // Form fields for creating or editing a product
    public $nome = '';
    public $preco = '';

    // Holds the ID of the product currently being edited (null means creation mode)
    public $editingId = null;

    // Controls the visibility of the modal (create/edit form)
    public bool $isModalOpen = false;

    // Controls the visibility of the delete confirmation dialog
    public bool $isConfirmingDelete = false;

    // Holds the ID of the product selected for deletion
    public $deleteId = null;

    // Injected service responsible for product CRUD operations
    protected ProdutoService $service;

    /**
     * Returns the validation rules used by the save() method.
     */
    protected function rules(): array
    {
        return [
            'nome' => 'required|string|max:150',
            'preco' => 'required|numeric|min:0',
        ];
    }

    /**
     * Boot method runs when the component initializes.
     * Injects the ProdutoService for later use.
     */
    public function boot(ProdutoService $service)
    {
        $this->service = $service;
    }

    /**
     * Runs once when the component is mounted.
     * Loads the list of products immediately.
     */
    public function mount()
    {
        $this->loadProdutos();
    }

    /**
     * Loads all products from the service and maps them into
     * a simplified array format suitable for display.
     */
    public function loadProdutos(): void
    {
        // Load all products and map them into an array
        $this->produtos = $this->service->list()->map(fn($p) => [
            'id' => $p->id,
            'nome' => $p->nome,
            'preco' => $p->preco,
            'created_at' => $p->created_at?->toDateTimeString(),
        ])->toArray();
    }

    /**
     * Opens the modal for creating a new product.
     * Clears the form before displaying it.
     */
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    /**
     * Opens the modal for editing an existing product.
     * Loads the product's data into the form fields.
     */
    public function openEditModal(int $id)
    {
        $produto = $this->service->get($id);

        $this->editingId = $produto->id;
        $this->nome = $produto->nome;
        $this->preco = $produto->preco;

        $this->isModalOpen = true;
    }

    /**
     * Saves the product form.
     * If editingId exists, updates an existing product.
     * Otherwise, creates a new one.
     * After saving, closes the modal, resets the form, reloads the list,
     * and sends a notification event.
     */
    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            // Update existing product
            $this->service->update($this->editingId, [
                'nome' => $this->nome,
                'preco' => $this->preco,
            ]);

            $this->dispatch('notify', message: 'Produto atualizado com sucesso!');
        } else {
            // Create new product
            $this->service->create([
                'nome' => $this->nome,
                'preco' => $this->preco,
            ]);

            $this->dispatch('notify', message: 'Produto criado com sucesso!');
        }

        // Close modal and reset state
        $this->isModalOpen = false;
        $this->resetForm();
        $this->loadProdutos();
    }

    /**
     * Opens the delete confirmation dialog for the selected product.
     */
    public function confirmDelete(int $id)
    {
        $this->isConfirmingDelete = true;
        $this->deleteId = $id;
    }

    /**
     * Cancels the delete process and hides the confirmation dialog.
     */
    public function cancelDelete()
    {
        $this->isConfirmingDelete = false;
        $this->deleteId = null;
    }

    /**
     * Deletes the selected product.
     * After deletion, reloads the list and sends a notification.
     */
    public function delete()
    {
        if ($this->deleteId) {
            $this->service->delete((int)$this->deleteId);

            $this->dispatch('notify', message: 'Produto excluído!');

            $this->isConfirmingDelete = false;
            $this->deleteId = null;

            $this->loadProdutos();
        }
    }

    /**
     * Resets form fields and clears the editing state.
     */
    public function resetForm()
    {
        $this->nome = '';
        $this->preco = '';
        $this->editingId = null;
    }

    /**
     * Renders the dashboard view.
     * Passes the product list to the Blade view.
     */
    public function render()
    {
        return view('livewire.produtos-dashboard', [
            'produtos' => $this->produtos,
        ]);
    }
}
