<?php
use MongoDB\BSON\ObjectId;

abstract class Model {
    protected string $collection;

    protected function col() {
        return Database::getInstance()->getCollection($this->collection);
    }

    public function all(): array {
        return $this->col()->find([], ['sort' => ['created_at' => -1]])->toArray();
    }

    public function find(string $id): ?object {
        return $this->col()->findOne(['_id' => new ObjectId($id)]);
    }

    public function create(array $data): void {
        $this->col()->insertOne($data);
    }

    public function update(string $id, array $data): void {
        $this->col()->updateOne(['_id' => new ObjectId($id)], ['$set' => $data]);
    }

    public function delete(string $id): void {
        $this->col()->deleteOne(['_id' => new ObjectId($id)]);
    }
}
