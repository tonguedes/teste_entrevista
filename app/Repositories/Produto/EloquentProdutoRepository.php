<?php
namespace App\Repositories\Produto;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Collection;

class EloquentProdutoRepository implements ProdutoRepositoryInterface
{
    /**
     * Retrieves all products ordered by ID in descending order.
     *
     * @return Collection  A collection containing all products
     */
    public function all(): Collection
    {
        return Produto::orderBy('id', 'desc')->get();
    }

    /**
     * Finds a product by its ID.
     *
     * @param int $id  The ID of the product to retrieve
     * @return Produto|null  The product if found, otherwise null
     */
    public function find(int $id): ?Produto
    {
        return Produto::find($id);
    }

    /**
     * Creates a new product using the provided data.
     *
     * @param array $data  The product attributes to be stored
     * @return Produto  The newly created product instance
     */
    public function create(array $data): Produto
    {
        return Produto::create($data);
    }

    /**
     * Updates an existing product based on ID.
     * Throws an exception if the product is not found.
     *
     * @param int $id  The ID of the product to update
     * @param array $data  The fields to update
     * @return Produto  The updated product instance
     */
    public function update(int $id, array $data): Produto
    {
        $produto = Produto::findOrFail($id);
        $produto->update($data);
        return $produto;
    }

    /**
     * Deletes a product by ID.
     * Throws an exception if the product does not exist.
     *
     * @param int $id  The ID of the product to delete
     * @return bool  True if deleted successfully, false otherwise
     */
    public function delete(int $id): bool
    {
        $produto = Produto::findOrFail($id);
        return (bool) $produto->delete();
    }
}
