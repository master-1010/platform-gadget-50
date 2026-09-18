<?php
namespace Tests\Feature; use Tests\TestCase; use Illuminate\Foundation\Testing\RefreshDatabase; use App\Models\{User,Category};
class RegistrationTest extends TestCase {use RefreshDatabase; public function test_user_can_register():void{$this->post('/register',['name'=>'Citizen','username'=>'citizen','email'=>'citizen@example.com','password'=>'long-secure-password','password_confirmation'=>'long-secure-password','terms'=>'on'])->assertRedirect('/dashboard');$this->assertDatabaseHas('users',['username'=>'citizen']);}}
