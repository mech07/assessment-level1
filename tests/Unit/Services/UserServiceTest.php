<?php
namespace Tests\Unit\Services;

//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UserServiceTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock Request instance
        $request = new Request();

        // Instantiate the UserService with the User model and the request
        $this->userService = new UserService(new User(), $request);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_return_a_paginated_list_of_users()
    {
        // Arrangements
        User::factory()->count(15)->create(); // Assuming you have a User factory set up

        // Actions
        $users = $this->userService->list();

        // Assertions
        $this->assertCount(10, $users->items()); // Default pagination is 10
        $this->assertEquals(16, $users->total());
        }

    /**
     * @test
     * @return void
     */
    public function it_can_store_a_user_to_database()
    {
            // Arrangements
            $userData = [
                'prefixname'=>'Mr',
                'firstname' => $this->faker->firstName,
                //'middlename'=>$this->faker->optional()->middlename,
                'lastname' => $this->faker->lastName,
                'suffixname'=>$this->faker->optional()->suffix,
                'username' => $this->faker->unique()->userName,
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make('test12345'),
                'type' => 'admin',
            ];

            // Actions
            $user = $this->userService->store($userData);

            // Assertions
            $this->assertDatabaseHas('users', [
                'username' => $user->username,
                'email' => $user->email,
            ]);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_find_and_return_an_existing_user()
    {

         // Arrangements
         $user = User::factory()->create();

         // Actions
         $foundUser = $this->userService->find($user->id);

         // Assertions
         $this->assertEquals($user->id, $foundUser->id);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_update_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();

        // Prepare updated data
        $updateData = [
            'firstname' => 'Mech',
            'lastname' => 'Mech',
        ];

        // Actions
        $this->userService->update($user->id, $updateData);

        // Assertions
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firstname' => 'Mech',
        ]);

    }

    /**
     * @test
     * @return void
     */
    public function it_can_soft_delete_an_existing_user()
    {

        // Arrangements
        $user = User::factory()->create();

        // Actions
        $this->userService->destroy($user->id);

        // Assertions
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);

    }

    /**
     * @test
     * @return void
     */
    public function it_can_return_a_paginated_list_of_trashed_users()
    {
	 // Arrangements
     $activeUser = User::factory()->create();
     $trashedUser = User::factory()->create(['deleted_at' => now()]); // Soft delete a user

     // Create more users if needed
     User::factory()->count(5)->create(['deleted_at' => now()]); // Create 5 more trashed users

     // Action
     $trashedUsers = $this->userService->listTrashed();

     // Assertions
     $this->assertCount(6, $trashedUsers); // Assuming we created 6 trashed users
     $this->assertEquals($trashedUser->id, $trashedUsers->first()->id);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_restore_a_soft_deleted_user()
    {
         // Arrangements
         $user = User::factory()->create();
         $this->userService->destroy($user->id); // Soft delete

        // Actions
         $this->userService->restore($user->id);

         // Assertions
         $this->assertDatabaseHas('users', [
             'id' => $user->id,
         ]);

    }

    /**
     * @test
     * @return void
     */
    public function it_can_permanently_delete_a_soft_deleted_user()
    {
        // Arrangements
        $user = User::factory()->create();
        $this->userService->destroy($user->id); // Soft delete

        // Actions
        $this->userService->delete($user->id);

       // Assertions
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function it_can_upload_photo()
    {
        // Arrangements
        $file = UploadedFile::fake()->image('profile.jpg'); // Create a fake image file

        // Actions
        $uploadedFilePath = $this->userService->upload($file);

        // Assertions
        $this->assertNotNull($uploadedFilePath); // Ensure the path is not null
        $this->assertFileExists(storage_path("app/public/{$uploadedFilePath}"));
    }
}
