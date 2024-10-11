<?php
namespace App\Services; // Make sure the namespace is correct

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use App\Services\UserServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User; // Update to use the correct User model namespace

class UserService implements UserServiceInterface
{
    /**
     * The model instance.
     *
     * @var User
     */
    protected $model;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * Constructor to bind model to a repository.
     *
     * @param User $model
     * @param Request $request
     */
    public function __construct(User $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * Define the validation rules for the model.
     *
     * @param int|null $id
     * @return array
     */
    public function rules($id = null)
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8', // Password is optional, but if provided, it should have a minimum length
            'prefixname' => 'nullable',
            'middlename' => 'nullable',
            'suffixname' => 'nullable',
            'type' => 'nullable',
        ];
    }

    /**
     * Retrieve all resources and paginate.
     *
     * @return LengthAwarePaginator
     */
    public function list(): LengthAwarePaginator
    {
        return $this->model::paginate(10);
    }

    /**
     * Create model resource.
     *
     * @param array $attributes
     * @return User
     */
    public function store(array $attributes): User
    {
        $attributes['password'] = Hash::make($attributes['password']); // Hash the password
        return $this->model::create($attributes);
    }

    /**
     * Retrieve model resource details.
     * Abort to 404 if not found.
     *
     * @param integer $id
     * @return User
     */
    public function find(int $id): ?User
    {
        return $this->model::findOrFail($id);
    }

    /**
     * Update model resource.
     *
     * @param integer $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {

        $user = $this->find($id);

        // Hash the password only if it was updated
        if (isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        } else {
            unset($attributes['password']); // Remove password if not being updated
        }

        return $user->update($attributes);
    }

    /**
     * Soft delete model resource.
     *
     * @param integer|array $id
     * @return void
     */
    public function destroy($id)
    {
        $user = $this->find($id);
        $user->delete();
    }

    /**
     * Include only soft deleted records in the results.
     *
     * @return LengthAwarePaginator
     */
    public function listTrashed(): LengthAwarePaginator
    {
        return $this->model::onlyTrashed()->paginate(10); // Adjust pagination as needed
    }

    /**
     * Restore model resource.
     *
     * @param integer|array $id
     * @return void
     */
    public function restore($id)
    {
        $this->model::withTrashed()->findOrFail($id)->restore();
    }

    /**
     * Permanently delete model resource.
     *
     * @param integer|array $id
     * @return void
     */
    public function delete($id)
    {
        $user = $this->model::withTrashed()->findOrFail($id);
        $user->forceDelete();
    }

    /**
     * Generate random hash key.
     *
     * @param string $key
     * @return string
     */
    public function hash(string $key): string
    {
        return Hash::make($key); // Generate a hash
    }

    /**
     * Upload the given file.
     *
     * @param UploadedFile $file
     * @return string|null
     */
    public function upload(UploadedFile $file): ?string
    {
        $path = $file->store('uploads', 'public'); // Store the file in the public/uploads directory
        return $path;
    }
}
