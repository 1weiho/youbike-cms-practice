<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Client;

class News extends Model
{
    use HasFactory;

    protected $collection = 'news';

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
        $collection = $database->news;

        // Find all documents
        $news = $collection->find()->toArray();

        return $news;
    }

    public function add($area, $menu, $start_at, $end_at, $status, $title, $content)
    {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->news;

        // Insert the document
        $insertOneResult = $collection->insertOne([
            'area' => $area,
            'menu' => $menu,
            'start_at' => $start_at,
            'end_at' => $end_at,
            'status' => $status,
            'title' => $title,
            'content' => $content
        ]);

        // Return the new ID
        return $insertOneResult->getInsertedId();
    }

    public function deleteById($id)
    {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->news;

        // Delete the document
        $deleteResult = $collection->deleteOne([
            '_id' => new \MongoDB\BSON\ObjectId($id),
        ]);

        // Return the deleted count
        return $deleteResult->getDeletedCount();
    }

    public function getById($id)
    {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->news;

        // Find all documents
        $news = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectId($id),
        ]);

        return $news;
    }

    public function updateById($id, $area, $menu, $start_at, $end_at, $status, $title, $content)
    {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->news;

        // Update the document
        $updateResult = $collection->updateOne([
            '_id' => new \MongoDB\BSON\ObjectId($id),
        ], [
            '$set' => [
                'area' => $area,
                'menu' => $menu,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'status' => $status,
                'title' => $title,
                'content' => $content
            ],
        ]);

        // Return the updated count
        return $updateResult->getModifiedCount();
    }

    // check if the news name is exist and return boolean
    public function isExist($name)
    {
        // Select the database
        $database = $this->client->laravel;

        // Select the collection
        $collection = $database->news;

        // Find all documents
        $news = $collection->findOne([
            'name' => $name,
        ]);

        return $news;
    }
}
