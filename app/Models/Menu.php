<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Client;

class Menu extends Model
{
    use HasFactory;

    protected $collection = 'menu';

    protected $connection = 'mongodb';

    protected $client;

    public function __construct()
    {
        $this->client = new Client("mongodb://database:27017");
    }

    public function list()
    {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->menu;

        // Find all documents
        $menu = $collection->find()->toArray();

        return $menu;
    }

    public function add($name)
    {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->menu;

        // Insert the document
        $insertOneResult = $collection->insertOne([
            'name' => $name,
        ]);

        // Return the new ID
        return $insertOneResult->getInsertedId();
    }

    public function deleteById($id)
    {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->menu;

        // Delete the document
        $deleteResult = $collection->deleteOne([
            '_id' => new \MongoDB\BSON\ObjectId($id),
        ]);

        // Return the deleted count
        return $deleteResult->getDeletedCount();
    }

    public function getById($id) {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->menu;

        // Find all documents
        $menu = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectId($id),
        ]);

        return $menu;
    }

    public function updateById($id, $name) {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->menu;

        // Update the document
        $updateResult = $collection->updateOne([
            '_id' => new \MongoDB\BSON\ObjectId($id),
        ], [
            '$set' => [
                'name' => $name,
            ],
        ]);

        // Return the updated count
        return $updateResult->getModifiedCount();
    }

    // check if the menu name is exist and return boolean
    public function isExist($name) {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->menu;

        // Find all documents
        $menu = $collection->findOne([
            'name' => $name,
        ]);

        return $menu;
    }
}
