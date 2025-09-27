<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    // User data
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $city = '';
    public $birth_date = '';
    public $gender = '';
    public $bio = '';

    // Password change
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // Avatar upload
    public $avatar;
    public $current_avatar;

    // UI states
    public $showPasswordSection = false;
    public $showAvatarSection = false;

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'city' => 'nullable|string|max:100',
        'birth_date' => 'nullable|date|before:today',
        'gender' => 'nullable|in:male,female,other',
        'bio' => 'nullable|string|max:1000',
        'current_password' => 'required_with:new_password|current_password',
        'new_password' => 'nullable|min:8|confirmed',
        'avatar' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $user = Auth::user();
        
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->city = $user->city ?? '';
        $this->birth_date = $user->birth_date ? $user->birth_date->format('Y-m-d') : '';
        $this->gender = $user->gender ?? '';
        $this->bio = $user->bio ?? '';
        $this->current_avatar = $user->avatar_url;

        // Unique email validation (exclude current user)
        $this->rules['email'] = 'required|email|unique:users,email,' . $user->id;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'birth_date' => $this->birth_date ?: null,
            'gender' => $this->gender ?: null,
            'bio' => $this->bio,
        ]);

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Perfil atualizado com sucesso!'
        ]);
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        // Clear password fields
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->showPasswordSection = false;

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Senha alterada com sucesso!'
        ]);
    }

    public function updateAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|max:2048'
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $this->avatar->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        $this->current_avatar = Storage::url($path);
        $this->avatar = null;
        $this->showAvatarSection = false;

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Avatar atualizado com sucesso!'
        ]);
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);
        $this->current_avatar = null;

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Avatar removido com sucesso!'
        ]);
    }

    public function togglePasswordSection()
    {
        $this->showPasswordSection = !$this->showPasswordSection;
        
        if (!$this->showPasswordSection) {
            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';
        }
    }

    public function toggleAvatarSection()
    {
        $this->showAvatarSection = !$this->showAvatarSection;
        $this->avatar = null;
    }

    public function render()
    {
        return view('livewire.user.profile')
            ->layout('layouts.app')
            ->title('Meu Perfil - SuperLoja');
    }
}
