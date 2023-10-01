<?php

namespace App\Http\Livewire\Backend\User;

use Exception;
use Throwable;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditModal extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['refresh_edit_form'];
    public $user_id, $name, $email, $username, $password, $re_password;

    public function render()
    {
        return view('livewire.backend.user.edit-modal');
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|alpha_dash|min:8|max:16|unique:users,username,' . $this->user_id,
            'name' => 'required|string|max:200',
            'email' => 'required|email:dns|unique:users,email,' . $this->user_id,
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'username' => __('Username'),
            'name' => __('Full Name'),
            'email' => __('Email'),
        ];
    }

    public function refresh_edit_form($id)
    {
        $this->reset();
        $this->user_id = $id;
        $user = User::findOrFail($id);
        $this->username = $user->username;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function update_user(): void
    {
        $this->validate();

        try {
            $user = User::find($this->user_id);
            $user->username = $this->username;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->save();

            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully updated.', ['feature' => __('User')])]
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
