<?php
// 代码生成时间: 2025-08-13 16:24:35
 * and follows PHP best practices for maintainability and scalability.
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class InventoryItem extends Model
{
    // Define the table associated with the model
    protected $table = 'inventory_items';

    // Disable Laravel's timestamp feature
    public $timestamps = false;
}

class InventoryService
{
    /**
     * Adds a new inventory item to the system.
     *
     * @param array $data The data for the new inventory item.
     * @return InventoryItem|false
     */
    public function addItem(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return false; // Return false if validation fails
        }

        return InventoryItem::create($data);
    }

    /**
     * Updates an existing inventory item.
     *
     * @param int $id The ID of the inventory item to update.
     * @param array $data The updated data for the inventory item.
     * @return InventoryItem|false
     */
    public function updateItem($id, array $data)
    {
        $item = InventoryItem::find($id);
        if (!$item) {
            return false; // Return false if item not found
        }

        $validator = Validator::make($data, [
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return false; // Return false if validation fails
        }

        $item->update($data);
        return $item;
    }

    /**
     * Deletes an inventory item from the system.
     *
     * @param int $id The ID of the inventory item to delete.
     * @return bool
     */
    public function deleteItem($id)
    {
        $item = InventoryItem::find($id);
        if (!$item) {
            return false; // Return false if item not found
        }

        return $item->delete();
    }

    /**
     * Lists all inventory items.
     *
     * @return Collection
     */
    public function listItems()
    {
        return InventoryItem::all();
    }
}

// Example usage
$inventoryService = new InventoryService();
$newItem = $inventoryService->addItem(['name' => 'Widget', 'quantity' => 100]);
if ($newItem) {
    echo "Item added successfully.\
";
} else {
    echo "Error adding item.\
";
}

$updatedItem = $inventoryService->updateItem(1, ['quantity' => 150]);
if ($updatedItem) {
    echo "Item updated successfully.\
";
} else {
    echo "Error updating item.\
";
}

$deleted = $inventoryService->deleteItem(1);
if ($deleted) {
    echo "Item deleted successfully.\
";
} else {
    echo "Error deleting item.\
";
}

$items = $inventoryService->listItems();
foreach ($items as $item) {
    echo "Name: {$item->name}, Quantity: {$item->quantity}\
";
}