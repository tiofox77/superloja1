<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.admin.layouts.app')]
#[Title('Usuários')]
class UsersSpa extends Component
{
    use WithPagination;
    
    #[Url]
    public string $search = '';
    
    #[Url]
    public string $role = '';
    
    public int $perPage = 15;
    
    // Modal
    public bool $showModal = false;
    public ?int $editingUserId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $userRole = 'customer';
    
    protected function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'userRole' => 'required|in:admin,customer',
        ];
        
        if ($this->editingUserId) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->editingUserId;
            $rules['password'] = 'nullable|min:6';
        } else {
            $rules['password'] = 'required|min:6';
        }
        
        return $rules;
    }
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    
    public function openCreateModal(): void
    {
        $this->reset(['editingUserId', 'name', 'email', 'password', 'userRole']);
        $this->userRole = 'customer';
        $this->showModal = true;
    }
    
    public function editUser(int $userId): void
    {
        $user = User::find($userId);
        if ($user) {
            $this->editingUserId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->userRole = $user->role ?? 'customer';
            $this->password = '';
            $this->showModal = true;
        }
    }
    
    public function saveUser(): void
    {
        $this->validate();
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->userRole,
        ];
        
        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }
        
        if ($this->editingUserId) {
            User::find($this->editingUserId)->update($data);
            $message = 'Usuário atualizado com sucesso!';
        } else {
            User::create($data);
            $message = 'Usuário criado com sucesso!';
        }
        
        $this->showModal = false;
        $this->reset(['editingUserId', 'name', 'email', 'password', 'userRole']);
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => $message,
        ]);
    }
    
    public function deleteUser(int $userId): void
    {
        $user = User::find($userId);
        if ($user && $user->id !== auth()->id()) {
            $user->delete();
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Usuário excluído com sucesso!',
            ]);
        }
    }
    
    public function clearFilters(): void
    {
        $this->reset(['search', 'role']);
        $this->resetPage();
    }
    
    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where(function($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
            }))
            ->when($this->role, fn($q) => $q->where('role', $this->role))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        
        return view('livewire.admin.users.index-spa', [
            'users' => $users,
            'totalUsers' => User::count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
        ]);
    }
}
