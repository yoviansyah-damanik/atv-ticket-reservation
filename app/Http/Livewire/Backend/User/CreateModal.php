<?php

namespace App\Http\Livewire\Backend\User;

use Exception;
use Throwable;
use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateModal extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['refresh_create_form'];
    public $name, $email, $username, $password, $re_password, $role;

    public function refresh_create_form()
    {
        $this->reset();
    }

    public function render(): View
    {
        $roles = Role::whereNotIn('name', ['User', 'Administrator'])
            ->get();
        return view('livewire.backend.user.create-modal', compact('roles'));
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|alpha_dash|min:8|max:16|unique:users,username',
            'name' => 'required|string|max:200',
            'email' => 'required|email:dns|unique:users,email',
            'password' => [
                'required',
                'string',
                Password::min(8)->letters()->numbers()->uncompromised()
            ],
            'role' => ['required', Rule::in(
                Role::whereNotIn('name', ['User', 'Administrator'])
                    ->get()->pluck('name')->toArray()
            )],
            're_password' => 'required|same:password'
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'username' => __('Username'),
            'name' => __('Full Name'),
            'email' => __('Email'),
            'password' => __('Password'),
            're_password' => __('Re-Password'),
            'role' => __('Role')
        ];
    }

    public function store(): void
    {
        $this->validate();

        try {
            $new_user = new User();
            $new_user->username = $this->username;
            $new_user->name = $this->name;
            $new_user->email = $this->email;
            $new_user->password = bcrypt($this->password);
            $new_user->save();

            $new_user->assignRole($this->role);

            $this->reset();
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully created.', ['feature' => __('User')])]
            );
            $this->dispatch('refresh_user_table');
            $this->dispatch('modal-close');
        } catch (Exception $e) {
            $this->alert(
                'warning',
                __('Attention!'),
                ['text' => $e->getMessage()]
            );
        } catch (Throwable $e) {
            $this->alert(
                'warning',
                __('Attention!'),
                ['text' => $e->getMessage()]
            );
        }
    }
}
