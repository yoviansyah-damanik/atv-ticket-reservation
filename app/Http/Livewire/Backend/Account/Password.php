<?php

namespace App\Http\Livewire\Backend\Account;

use Exception;
use Throwable;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as ValidationPassword;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Password extends Component
{
    use LivewireAlert;
    public $new_password, $re_password, $current_password;

    public function render()
    {
        return view('livewire.backend.account.password');
    }

    public function rules(): array
    {
        return [
            'current_password' => 'required|current_password ',
            'new_password' => [
                'required',
                'string',
                ValidationPassword::min(8)->letters()->numbers()
            ],
            're_password' => 'required|same:new_password'
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'current_password' => __('Current Password'),
            'new_password' => __('New Password'),
            're_password' => __('Re-Password')
        ];
    }

    public function save_password()
    {
        $this->validate();
        try {
            $user = User::find(Auth::id());
            $user->password = bcrypt($this->new_password);
            $user->save();

            $this->reset();
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
