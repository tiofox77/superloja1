<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class TestUploadModal extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public $image = null;

    protected $rules = [
        'image' => 'required|image|max:12288',
    ];

    public function updatedImage(): void
    {
        $this->validateOnly('image');
    }

    public function openModal(): void
    {
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->reset(['showModal', 'image']);
    }

    public function submit(): void
    {
        $this->validate();

        // No persistence. We only simulate a successful upload/validation.
        $this->dispatch('upload-test-success');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.test-upload-modal');
    }
}
