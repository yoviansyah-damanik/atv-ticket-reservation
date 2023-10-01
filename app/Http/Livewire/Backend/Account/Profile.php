<?php

namespace App\Http\Livewire\Backend\Account;

use Exception;
use Throwable;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{
    use LivewireAlert;
    public $name;
    public $username;
    public $email;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->username = Auth::user()->username;
        $this->email = Auth::user()->email;
    }
    public function render()
    {
        return view('livewire.backend.account.profile');
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|alpha_dash|min:8|max:16|unique:users,username,' . Auth::id(),
            'name' => 'required|string|min:8|max:200',
            'email' => 'required|email:dns|unique:users,email,' . Auth::id(),
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

    public function save_profile()
    {
        $this->validate();
        try {
            $user = User::find(Auth::id());
            $user->username = $this->username;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->save();

            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully updated.', ['feature' => __('Account')])]
            );
        } catch (Exception $e) {
            $this->alert('warning', __('Something went wrong!'), ['text' => $e->getMessage()]);
        } catch (Throwable $e) {
            $this->alert('warning', __('Something went wrong!'), ['text' => $e->getMessage()]);
        }
    }
}
