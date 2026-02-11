<?php

namespace App\Console\Commands;

use App\Services\AgentSocial;
use Illuminate\Console\Command;

class AgentSocialCommand extends Command
{
    protected $signature = 'agent-social
                           {action? : Action: register, speak, idea, plan, broadcast, status, feed}
                           {--message= : Message for speak/broadcast}
                           {--title= : Title for idea/plan}
                           {--description= : Description for plan}
                           {--conversation= : Conversation ID}';

    protected $description = 'Communicate with Agent Social Network';

    public function handle(): int
    {
        $agentSocial = new AgentSocial();
        $action = $this->argument('action') ?? 'status';

        switch ($action) {
            case 'register':
                return $this->register($agentSocial);
            case 'speak':
                return $this->speak($agentSocial);
            case 'idea':
                return $this->shareIdea($agentSocial);
            case 'plan':
                return $this->createPlan($agentSocial);
            case 'broadcast':
                return $this->broadcast($agentSocial);
            case 'status':
                return $this->status($agentSocial);
            case 'feed':
                return $this->feed($agentSocial);
            case 'ideas':
                return $this->ideas($agentSocial);
            default:
                $this->error("Unknown action: {$action}");
                $this->info("Available actions: register, speak, idea, plan, broadcast, status, feed, ideas");
                return 1;
        }
    }

    private function register(AgentSocial $agentSocial): int
    {
        $this->info('Registering Superloja...');
        $result = $agentSocial->register();
        if (isset($result['success']) && $result['success']) {
            $this->info($result['message']);
            return 0;
        }
        $this->error('Error: ' . ($result['error'] ?? 'Unknown'));
        return 1;
    }

    private function speak(AgentSocial $agentSocial): int
    {
        $conversationId = $this->option('conversation') ?? 'conv-agents-001';
        $message = $this->option('message') ?? $this->ask('Message:');
        if (empty($message)) {
            $this->error('Empty message');
            return 1;
        }
        $result = $agentSocial->speak($conversationId, $message);
        if (isset($result['success']) && $result['success']) {
            $this->info('Message sent: ' . $result['content']);
            return 0;
        }
        $this->error('Error: ' . ($result['error'] ?? 'Unknown'));
        return 1;
    }

    private function shareIdea(AgentSocial $agentSocial): int
    {
        $title = $this->option('title') ?? $this->ask('Title:');
        $description = $this->option('description') ?? $this->ask('Description:');
        if (empty($title) || empty($description)) {
            $this->error('Title or description empty');
            return 1;
        }
        $result = $agentSocial->shareIdea($title, $description);
        if (isset($result['success']) && $result['success']) {
            $this->info($result['message']);
            $this->info('Title: ' . $result['title']);
            return 0;
        }
        $this->error('Error: ' . ($result['error'] ?? 'Unknown'));
        return 1;
    }

    private function createPlan(AgentSocial $agentSocial): int
    {
        $title = $this->option('title') ?? $this->ask('Title:');
        $description = $this->option('description') ?? $this->ask('Description:');
        if (empty($title) || empty($description)) {
            $this->error('Title or description empty');
            return 1;
        }
        $result = $agentSocial->createPlan($title, $description, ['agent-fox'], [], '2 weeks');
        if (isset($result['success']) && $result['success']) {
            $this->info($result['message']);
            $this->info('Plan: ' . $result['title']);
            return 0;
        }
        $this->error('Error: ' . ($result['error'] ?? 'Unknown'));
        return 1;
    }

    private function broadcast(AgentSocial $agentSocial): int
    {
        $message = $this->option('message') ?? $this->ask('Message:');
        if (empty($message)) {
            $this->error('Empty message');
            return 1;
        }
        $result = $agentSocial->broadcast($message);
        if (isset($result['success']) && $result['success']) {
            $this->info('Broadcast sent!');
            return 0;
        }
        $this->error('Error: ' . ($result['error'] ?? 'Unknown'));
        return 1;
    }

    private function status(AgentSocial $agentSocial): int
    {
        $this->info('Checking network status...');
        $result = $agentSocial->networkStatus();
        if (!isset($result['success']) || !$result['success']) {
            $this->error('Error: ' . ($result['error'] ?? 'Unknown'));
            return 1;
        }
        $data = $result['data'] ?? [];
        $this->info('Agent Social Network:');
        $this->info('  Online agents: ' . ($data['online_agents'] ?? 0));
        $this->info('  Active conversations: ' . ($data['active_conversations'] ?? 0));
        $this->info('  Trending ideas: ' . ($data['trending_ideas'] ?? 0));
        $this->info('  Pending tasks: ' . ($data['pending_tasks'] ?? 0));
        
        $agents = $data['agents'] ?? [];
        if (!empty($agents)) {
            $this->info('Agents:');
            foreach ($agents as $agent) {
                $status = $agent['status'] ?? 'offline';
                $icon = $status === 'online' ? '[ONLINE]' : '[OFFLINE]';
                $this->info('  ' . $icon . ' ' . $agent['name'] . ' (' . $agent['agent_id'] . ')');
            }
        }
        return 0;
    }

    private function feed(AgentSocial $agentSocial): int
    {
        $this->info('Getting activity feed...');
        $result = $agentSocial->feed();
        if (!isset($result['success']) || !$result['success']) {
            $this->error('Error: ' . ($result['error'] ?? 'Unknown'));
            return 1;
        }
        $activities = $result['data'] ?? [];
        if (empty($activities)) {
            $this->info('No recent activity.');
            return 0;
        }
        $this->info('Recent Activity:');
        foreach (array_slice($activities, 0, 10) as $activity) {
            $time = \Carbon\Carbon::parse($activity['created_at'])->format('H:i');
            $agent = $activity['agent_name'] ?? $activity['agent_id'];
            $action = $activity['action'];
            $this->info('  [' . $time . '] ' . $agent . ': ' . $action);
        }
        return 0;
    }

    private function ideas(AgentSocial $agentSocial): int
    {
        $this->info('Getting ideas...');
        $result = $agentSocial->ideas();
        if (!isset($result['success']) || !$result['success']) {
            $this->error('Error: ' . ($result['error'] ?? 'Unknown'));
            return 1;
        }
        $ideas = $result['data'] ?? [];
        if (empty($ideas)) {
            $this->info('No ideas yet.');
            return 0;
        }
        $this->info('Ideas:');
        foreach (array_slice($ideas, 0, 10) as $idea) {
            $votes = $idea['votes'] ?? 0;
            $status = $idea['status'] ?? 'draft';
            $statusIcon = $status === 'approved' ? '[APPROVED]' : ($status === 'rejected' ? '[REJECTED]' : '[DRAFT]');
            $this->info('  ' . $statusIcon . ' [' . $votes . ' votes] ' . $idea['title']);
            $this->info('    By: ' . $idea['author_agent_id']);
        }
        return 0;
    }
}
