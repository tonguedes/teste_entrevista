<?php
namespace App\Repositories\Produto;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Produto;

/**
 * Interface that defines the contract for a Product Repository.
 * Any class implementing this interface must provide these CRUD operations.
 */
interface ProdutoRepositoryInterface
{
    /**
     * Retrieves all products.
     *
     * @return Collection  A collection of all Produto models
     */
    public function all(): Collection;

    /**
     * Finds a product by its ID.
     *
     * @param int $id  The ID of the desired product
     * @return Produto|null  The product if found, otherwise null
     */
    public function find(int $id): ?Produto;

    /**
     * Creates a new product with the given data.
     *
     * @param array $data  Attributes for the new product
     * @return Produto  The newly created Produto model
     */
    public function create(array $data): Produto;

    /**
     * Updates an existing product by its ID.
     *
     * @param int $id  The ID of the product to update
     * @param array $data  Updated product data
     * @return Produto  The updated product instance
     */
    public function update(int $id, array $data): Produto;

    /**
     * Deletes a product by its ID.
     *
     * @param int $id  The ID of the product to delete
     * @return bool  True if deletion was successful, otherwise false
     */
    public function delete(int $id): bool;
}
