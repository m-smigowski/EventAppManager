<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Event.php';

class DepotRepository extends Repository
{

    public function addItem($name,$description,$image,$barcode,$quantity){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO depot_items(name,description,created_at,id_assigned_by,image,barcode)
            VALUES(?,?,CURRENT_TIMESTAMP,?,?,?);');
        $assignedById = $_SESSION['user_id'];
        $stmt->execute([
            $name,
            $description,
            $assignedById,
            $image,
            $barcode,
        ]);
        $stmt = $this->database->connect()->prepare('
            SELECT id FROM depot_items WHERE name=? AND description=? AND barcode=?');
        $stmt->execute([
            $name,
            $description,
            $barcode
        ]);

        $id =  $stmt->fetchColumn();
        $stmt = $this->database->connect()->prepare('
            INSERT INTO depot_quantity(id_items,quantity)
            VALUES(?,?);');
        $stmt->execute([
            $id,
            $quantity,
        ]);

    }

    public function getItems(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT di.id,di.name,di.description,di.image,di.barcode,dq.quantity 
        FROM depot_items di INNER JOIN depot_quantity dq ON di.id = dq.id_items ORDER BY di.id');
        $stmt->execute();
        $items =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item){
            $result[] = new Item(
                $item['id'],
                $item['name'],
                $item['description'],
                $item['image'],
                $item['barcode'],
                $item['quantity']
            );
        }
        return $result;
    }

    public function getItem(int $id,int $barcode): ?Item
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT di.id,di.name,di.description,di.image,di.barcode,dq.quantity 
        FROM depot_items di INNER JOIN depot_quantity dq ON di.id = dq.id_items 
        WHERE di.id=? AND di.barcode=?
        ');
        $stmt->execute([$id,$barcode]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item == false) {
            return null;
        }

        return new Item(
                $item['id'],
                $item['name'],
                $item['description'],
                $item['image'],
                $item['barcode'],
                $item['quantity']
            );

    }

    public function updateItem($name,$description,$image,$barcode,$quantity,$id){
        $stmt = $this->database->connect()->prepare('
            UPDATE depot_items SET name=?,description=?,image=?,barcode=? WHERE id=?');
        $stmt->execute([
            $name,
            $description,
            $image,
            $barcode,
            $id
        ]);

        $stmt = $this->database->connect()->prepare('
            UPDATE depot_quantity SET quantity=? WHERE id_items=? ');
        $stmt->execute([
            $quantity,
            $id,
        ]);

    }


    public function dropItem($id)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM depot_quantity WHERE id_items=?');
        $stmt->execute([
            $id,
        ]);

        $stmt = $this->database->connect()->prepare('
            DELETE FROM depot_items WHERE id=?');
        $stmt->execute([
            $id,
        ]);

    }

    public function addItemToRent($event_id,$user_id,$item_id,$quantity,$comments)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM events WHERE id=?');
        $stmt->execute([
            $event_id,
        ]);

        $event = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $event_start = implode("", array_column($event, 'event_start'));
        $event_end = implode("", array_column($event, 'event_end'));
        $event_s = date_format(date_create($event_start), "Y-m-d");
        $event_e = date_format(date_create($event_end), "Y-m-d");

       $stmt = $this->database->connect()->prepare('
            INSERT INTO rental(events_id,users_id,items_id,quantity,start_date,return_date,comments)
            VALUES(?,?,?,?,?,?,?)
            ');
        $stmt->execute([
            $event_id,
            $user_id,
            $item_id,
            $quantity,
            $event_s,
            $event_e,
            $comments,
        ]);
    }

    public function abilityItemBetweenDateWhenEventIs($event_id,$item_id){
            $stmt = $this->database->connect()->prepare('
            SELECT * FROM events WHERE id=?');
            $stmt->execute([
                $event_id,
            ]);

            $event =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            $event_start = implode("",array_column($event, 'event_start'));
            $event_end = implode("",array_column($event, 'event_end'));
            $event_s =  date_format(date_create($event_start),"Y-m-d");
            $event_e =  date_format(date_create($event_end),"Y-m-d");


            $stmt = $this->database->connect()->prepare('
                SELECT SUM(quantity) FROM rental WHERE items_id = :item_id AND start_date <= :event_end AND return_date >= :event_start ');

            $stmt->bindParam(':item_id', $item_id, PDO::PARAM_STR);
            $stmt->bindParam(':event_start', $event_s, PDO::PARAM_STR);
            $stmt->bindParam(':event_end', $event_e, PDO::PARAM_STR);

            $stmt->execute();
            $item_rented_quantity =  $stmt->fetchColumn();

            $stmt = $this->database->connect()->prepare('
                SELECT quantity FROM depot_quantity WHERE id_items=:item_id');

            $stmt->bindParam(':item_id', $item_id, PDO::PARAM_STR);
            $stmt->execute();
            $item_depot_quantity = $stmt->fetchColumn();

            return $item_depot_quantity-$item_rented_quantity;

        }

        public function getRentedItemsForEvent($event_id){
            $stmt = $this->database->connect()->prepare('
            SELECT di.id,di.image,di.name,di.barcode,di.description,r.quantity,r.comments,r.id as rental_id
            FROM rental r INNER JOIN depot_items di ON r.items_id = di.id
            WHERE r.events_id=?');
            $stmt->execute([
                $event_id,
            ]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        }

    public function dropRentedItem($rental_id){
        $stmt = $this->database->connect()->prepare('
            DELETE FROM rental where id=?
            ');
        $stmt->execute([
            $rental_id,
        ]);


    }

    public function getItemByName(string $searchString): array
    {
        $searchString = '%'.strtolower($searchString).'%';
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT di.id,di.image,di.name,di.description,di.barcode,dq.quantity FROM depot_items di INNER JOIN depot_quantity dq
        ON di.id = dq.id_items WHERE LOWER(di.name) LIKE (:search) ORDER BY di.id
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_INT);
        $stmt->execute();
        return $items =  $stmt->fetchAll(PDO::FETCH_ASSOC);

    }



}