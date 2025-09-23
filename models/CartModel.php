<?php

class CartModel extends BaseModel
{
    const TABLE = 'cart';

    public function getCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['cart'] ?? [];
    }

    public function addOrIncrement($userId, $productId, $name, $image, $price, $size, $quantity = 1)
    {
        $userId = (int)$userId;
        $productId = (int)$productId;
        $quantity = (int)$quantity;
        $sizeEsc = mysqli_real_escape_string($this->conn, $size);

        $sql = "SELECT id, quantity FROM `" . self::TABLE . "` WHERE user_id = $userId AND product_id = $productId AND size = '$sizeEsc' LIMIT 1";
        $rows = $this->getByQuery($sql);

        if (!empty($rows)) {
            $current = (int)$rows[0]['quantity'];
            $this->update(self::TABLE, $rows[0]['id'], [
                'quantity' => $current + $quantity,
            ]);
            return;
        }

        $this->create(self::TABLE, [
            'user_id'    => $userId,
            'product_id' => $productId,
            'name'       => $name,
            'image'      => $image,
            'price'      => $price,
            'size'       => $size,
            'quantity'   => $quantity,
        ]);
    }

    public function setQuantityByComposite($userId, $productId, $size, $quantity)
    {
        $userId = (int)$userId;
        $productId = (int)$productId;
        $quantity = (int)$quantity;
        $sizeEsc = mysqli_real_escape_string($this->conn, $size);

        $rows = $this->getByQuery("SELECT id FROM `" . self::TABLE . "` WHERE user_id = $userId AND product_id = $productId AND size = '$sizeEsc' LIMIT 1");
        if (empty($rows)) {
            return;
        }

        $id = (int)$rows[0]['id'];
        // $rows[0]: lấy dòng đầu tiên (vì đã LIMIT 1).
        //['id']: lấy giá trị cột id.
        if ($quantity <= 0) {
            $this->delete(self::TABLE, $id);
            return;
        }
        $this->update(self::TABLE, $id, [
            'quantity' => $quantity,
        ]);
    }

    public function getByUser($userId)
    {
        $userId = (int)$userId;
        return $this->getByQuery("SELECT product_id, name, image, price, size, quantity FROM `" . self::TABLE . "` WHERE user_id = $userId");
    }

    public function rowsToSessionCart(array $rows)
    {
        $cart = [];
        foreach ($rows as $row) {
            $cart[] = [
                'id'       => (int)$row['product_id'],
                'name'     => $row['name'],
                'image'    => $row['image'],
                'price'    => (float)$row['price'],
                'size'     => $row['size'],
                'quantity' => (int)$row['quantity'],
            ];
        }
        return $cart;
    }

    public function clearByUser($userId)
    {
        $userId = (int)$userId;
        $sql = "DELETE FROM `" . self::TABLE . "` WHERE user_id = $userId";
        mysqli_query($this->conn, $sql);
    }
}
