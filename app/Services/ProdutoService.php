<?php
namespace App\Services;

use App\Repositories\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Produto;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service layer responsible for handling business logic related to products.
 * It acts as an intermediary between controllers/Livewire components
 * and the Product Repository.
 */
class ProdutoService
{
    // Repository instance used for database operations
    protected ProdutoRepositoryInterface $repo;

    /**
     * Injects the product repository implementation.
     * This allows the service to work with any repository
     * that implements the ProdutoRepositoryInterface.
     */
    public function __construct(ProdutoRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Returns a collection containing all products.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->repo->all();
    }

    /**
     * Retrieves a product by its ID.
     * Throws an exception if the product is not found.
     *
     * @param int $id
     * @return Produto
     *
     * @throws ModelNotFoundException
     */
    public function get(int $id): Produto
    {
        return $this->repo->find($id)
            ?? throw new ModelNotFoundException("Produto {$id} não encontrado");
    }

    /**
     * Creates a new product using the provided data.
     *
     * @param array $data
     * @return Produto
     */
    public function create(array $data): Produto
    {
        return $this->repo->create($data);
    }

    /**
     * Updates an existing product with new data.
     *
     * @param int $id
     * @param array $data
     * @return Produto
     */
    public function update(int $id, array $data): Produto
    {
        return $this->repo->update($id, $data);
    }

    /**
     * Deletes a product by its ID.
     *
     * @param int $id
     * @return bool  True on successful deletion
     */
    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }
}
