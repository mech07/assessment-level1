<?php
namespace App\Services;

interface UserServiceInterface
{
    public function rules($id = null);
    public function list();
    public function store(array $attributes);
    public function find(int $id);
    public function update(int $id, array $attributes);
    public function destroy($id);
    public function listTrashed();
    public function restore($id);
    public function delete($id);
    public function hash(string $key);
    //public function upload(UploadedFile $file);
}
