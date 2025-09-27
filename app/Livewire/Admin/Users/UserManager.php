<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class UserManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $selectedUser = null;

    // Form fields
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'customer';
    public $phone = '';
    public $address = '';
    public $city = '';
    public $is_active = true;

    // Filters
    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:admin,customer,seller',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'city' => 'nullable|string|max:100',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $users = User::query()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function($query) {
                $query->where('role', $this->filterRole);
            })
            ->when($this->filterStatus, function($query) {
                if ($this->filterStatus === 'active') {
                    $query->where('is_active', true);
                } else {
                    $query->where('is_active', false);
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        $stats = [
            'total' => User::count(),
            'customers' => User::where('role', 'customer')->count(),
            'sellers' => User::where('role', 'seller')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
        ];

        return view('livewire.admin.users.user-manager', [
            'users' => $users,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Gerir Utilizadores',
            'pageTitle' => 'Utilizadores'
        ]);
    }

    public function openModal($userId = null): void
    {
        $this->resetFields();
        $this->resetValidation();

        if ($userId) {
            $this->editMode = true;
            $this->selectedUser = User::findOrFail($userId);
            $this->loadUserData();
        } else {
            $this->editMode = false;
            $this->selectedUser = null;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetFields();
        $this->resetValidation();
    }

    public function saveUser(): void
    {
        if ($this->editMode) {
            $this->rules['email'] = 'required|email|unique:users,email,' . $this->selectedUser->id;
            $this->rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'is_active' => $this->is_active,
        ];

        if (!$this->editMode || $this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editMode) {
            $this->selectedUser->update($data);
            $message = 'Utilizador atualizado com sucesso!';
        } else {
            User::create($data);
            $message = 'Utilizador criado com sucesso!';
        }

        $this->dispatch('success', $message);
        $this->closeModal();
    }

    public function deleteUser($userId): void
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            $this->dispatch('error', 'Não pode eliminar o seu próprio utilizador!');
            return;
        }

        $user->delete();
        $this->dispatch('success', 'Utilizador eliminado com sucesso!');
    }

    public function toggleStatus($userId): void
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            $this->dispatch('error', 'Não pode desativar o seu próprio utilizador!');
            return;
        }

        $user->update(['is_active' => !$user->is_active]);
        
        $message = $user->is_active ? 'Utilizador ativado!' : 'Utilizador desativado!';
        $this->dispatch('success', $message);
    }

    private function resetFields(): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'customer';
        $this->phone = '';
        $this->address = '';
        $this->city = '';
        $this->is_active = true;
    }

    private function loadUserData(): void
    {
        $this->name = $this->selectedUser->name;
        $this->email = $this->selectedUser->email;
        $this->role = $this->selectedUser->role;
        $this->phone = $this->selectedUser->phone ?? '';
        $this->address = $this->selectedUser->address ?? '';
        $this->city = $this->selectedUser->city ?? '';
        $this->is_active = $this->selectedUser->is_active;
    }
}
