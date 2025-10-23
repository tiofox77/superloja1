<?php

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AiDiagnosticLog;

class DiagnosticLogs extends Component
{
    use WithPagination;

    public $filterIssueType = '';
    public $filterSeverity = '';
    public $filterResolved = 'unresolved'; // all, resolved, unresolved
    public $search = '';

    public $selectedLog = null;
    public $showDetailModal = false;
    public $adminNotes = '';

    protected $queryString = [
        'filterIssueType' => ['except' => ''],
        'filterSeverity' => ['except' => ''],
        'filterResolved' => ['except' => 'unresolved'],
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterIssueType()
    {
        $this->resetPage();
    }

    public function updatingFilterSeverity()
    {
        $this->resetPage();
    }

    public function updatingFilterResolved()
    {
        $this->resetPage();
    }

    public function viewDetails($logId)
    {
        $this->selectedLog = AiDiagnosticLog::with('customer')->find($logId);
        $this->adminNotes = $this->selectedLog->admin_notes ?? '';
        $this->showDetailModal = true;
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->selectedLog = null;
        $this->adminNotes = '';
    }

    public function markResolved()
    {
        if ($this->selectedLog) {
            $this->selectedLog->markResolved($this->adminNotes);
            session()->flash('success', '✅ Log marcado como resolvido!');
            $this->closeModal();
        }
    }

    public function markUnresolved($logId)
    {
        $log = AiDiagnosticLog::find($logId);
        if ($log) {
            $log->update([
                'resolved' => false,
                'resolved_at' => null,
            ]);
            session()->flash('success', '✅ Log marcado como não resolvido!');
        }
    }

    public function deleteLog($logId)
    {
        $log = AiDiagnosticLog::find($logId);
        if ($log) {
            $log->delete();
            session()->flash('success', '✅ Log excluído!');
        }
    }

    public function getStatsProperty()
    {
        return [
            'total' => AiDiagnosticLog::count(),
            'unresolved' => AiDiagnosticLog::unresolved()->count(),
            'high_severity' => AiDiagnosticLog::highSeverity()->unresolved()->count(),
            'today' => AiDiagnosticLog::whereDate('created_at', today())->count(),
        ];
    }

    public function render()
    {
        $query = AiDiagnosticLog::with('customer')
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($this->filterIssueType) {
            $query->where('issue_type', $this->filterIssueType);
        }

        if ($this->filterSeverity) {
            $query->where('severity', $this->filterSeverity);
        }

        if ($this->filterResolved === 'resolved') {
            $query->where('resolved', true);
        } elseif ($this->filterResolved === 'unresolved') {
            $query->where('resolved', false);
        }

        // Busca
        if ($this->search) {
            $query->where(function($q) {
                $q->where('customer_name', 'like', "%{$this->search}%")
                  ->orWhere('customer_message', 'like', "%{$this->search}%")
                  ->orWhere('customer_identifier', 'like', "%{$this->search}%");
            });
        }

        $logs = $query->paginate(15);

        return view('livewire.admin.ai-agent.diagnostic-logs', [
            'logs' => $logs,
            'stats' => $this->stats,
        ]);
    }
}
