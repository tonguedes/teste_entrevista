<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ProdutoService;
use Illuminate\Support\Collection;

class Produtos extends Component
{
    // --- DATA PROPERTIES ---
    // Stores the list of products to be displayed in the UI
    public array $produtos = [];


    // Form fields
    public $nome;
    public $preco;

    // --- MODAL / ACTION STATE PROPERTIES ---
    // Controls visibility of the create/edit modal
    public bool $isModalOpen = false;

    // Controls visibility of the delete confirmation dialog
    public bool $isConfirmingDelete = false;

    // ID of the product being edited (null means creation)
    public ?int $editingId = null;

    // ID of the product selected for deletion
    public ?int $deleteId = null;

    // Service responsible for product operations
    protected ProdutoService $service;

    // Validation rules for the save() method
    protected array $rules = [
        'nome' => 'required|string|max:150',
        'preco' => 'required|numeric|min:0',
    ];

    /**
     * Called when the component is initialized.
     * Injects the ProdutoService instance.
     */
    public function boot(ProdutoService $service)
    {
        $this->service = $service;
    }

    /**
     * Runs once when the component is mounted.
     * Currently does nothing because products are loaded in render().
     */
    public function mount()
    {
        // loadProdutos() will be called from render()
    }

    /**
     * Loads the list of products from the service,
     * ensures the result is a Collection,
     * and maps the items to a simple array format.
     */
    public function loadProdutos()
    {
        // 1. Retrieves the full list from the service
        $query = $this->service->list();

        // 2. Ensures we are working with a Collection
        if (!($query instanceof Collection)) {
            $query = collect($query);
        }

        // 3. Maps each product to an array structure
        $this->produtos = $query->map(function($p) {
            return [
                'id' => $p->id,
                'nome' => $p->nome,
                'preco' => $p->preco,
                'created_at' => $p->created_at ?? '-',
            ];
        })->toArray();
    }


    // --- MODAL / CRUD ACTION METHODS ---

    /**
     * Opens the modal for creating a new product.
     * Resets the form and ensures no editing ID is set.
     */
    public function openCreateModal()
    {
        $this->resetForm();
        $this->editingId = null;
        $this->isModalOpen = true;
    }

    /**
     * Validates input data, creates a new product,
     * closes the modal, resets the form, reloads the product list,
     * and sends a notification.
     */
    public function save()
    {
        $this->validate();

        $data = [
            'nome' => $this->nome,
            'preco' => $this->preco,
        ];

        // Creates the product through the service class
        $this->service->create($data);

        $message = 'Produto salvo com sucesso!';

        // Closes modal and resets form
        $this->isModalOpen = false;
        $this->resetForm();

        // Refreshes list
        $this->loadProdutos();

        // Dispatches success notification
        $this->dispatch('notify', message: $message);
    }

    /**
     * Opens the confirmation dialog for deleting a product.
     */
    public function confirmDelete(int $id)
    {
        $this->deleteId = $id;
        $this->isConfirmingDelete = true;
    }

    /**
     * Cancels the deletion process and hides the confirmation dialog.
     */
    public function cancelDelete()
    {
        $this->deleteId = null;
        $this->isConfirmingDelete = false;
    }

    /**
     * Deletes the selected product using the service,
     * reloads the product list, closes the confirmation dialog,
     * and sends a notification.
     */
    public function delete()
    {
        if ($this->deleteId) {
            $this->service->delete($this->deleteId);

            // Refresh product list
            $this->loadProdutos();

            // Resets delete state
            $this->cancelDelete();

            // Emits notification
            $this->dispatch('notify', message: 'Produto excluído!');
        }
    }

    /**
     * Resets form fields, clears the editing state,
     * and resets validation errors.
     */
    public function resetForm()
    {
        $this->nome = '';
        $this->preco = '';
        $this->editingId = null;
        $this->resetValidation();
    }

    /**
     * Renders the component and loads the product list
     * every time the component updates.
     */
    public function render()
    {
        $this->loadProdutos();
        return view('livewire.produtos');
    }
}
