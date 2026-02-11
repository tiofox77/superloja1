<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

#[Layout('components.admin.layouts.app')]
#[Title('Configurações')]
class SettingsSpa extends Component
{
    use WithFileUploads;
    
    public string $activeTab = 'general';
    
    // General Settings
    public string $app_name = '';
    public string $app_description = '';
    public string $contact_email = '';
    public string $contact_phone = '';
    public string $whatsapp_number = '';
    public string $address = '';
    public string $timezone = 'Africa/Luanda';
    
    // Appearance
    public $site_logo;
    public $site_favicon;
    public string $primary_color = '#FF8C00';
    public string $secondary_color = '#8B1E5C';
    
    // SEO
    public string $meta_title = '';
    public string $meta_description = '';
    public string $meta_keywords = '';
    public string $google_analytics = '';
    public string $facebook_pixel = '';
    public $og_image;
    
    // Social Media
    public string $facebook_url = '';
    public string $instagram_url = '';
    public string $twitter_url = '';
    public string $youtube_url = '';
    public string $linkedin_url = '';
    public string $tiktok_url = '';
    
    // Store Settings
    public string $currency = 'Kz';
    public string $currency_position = 'after';
    public int $low_stock_threshold = 10;
    public bool $enable_reviews = true;
    public bool $enable_wishlist = true;
    public bool $enable_compare = true;
    public bool $enable_quick_view = true;
    
    // SMS Settings
    public bool $sms_enabled = false;
    public string $sms_provider = 'unimtx';
    public string $sms_access_key = '';
    public string $sms_sender_name = '';
    
    // Email Settings
    public bool $email_enabled = true;
    public string $smtp_host = '';
    public string $smtp_port = '587';
    public string $smtp_username = '';
    public string $smtp_password = '';
    public string $smtp_encryption = 'tls';
    
    public function mount(): void
    {
        $this->loadSettings();
    }
    
    protected function loadSettings(): void
    {
        // General
        $this->app_name = Setting::get('app_name', 'SuperLoja');
        $this->app_description = Setting::get('app_description', '');
        $this->contact_email = Setting::get('contact_email', '');
        $this->contact_phone = Setting::get('contact_phone', '');
        $this->whatsapp_number = Setting::get('whatsapp_number', '');
        $this->address = Setting::get('address', '');
        $this->timezone = Setting::get('timezone', 'Africa/Luanda');
        
        // Appearance
        $this->primary_color = Setting::get('primary_color', '#FF8C00');
        $this->secondary_color = Setting::get('secondary_color', '#8B1E5C');
        
        // SEO
        $this->meta_title = Setting::get('meta_title', '');
        $this->meta_description = Setting::get('meta_description', '');
        $this->meta_keywords = Setting::get('meta_keywords', '');
        $this->google_analytics = Setting::get('google_analytics', '');
        $this->facebook_pixel = Setting::get('facebook_pixel', '');
        
        // Social
        $this->facebook_url = Setting::get('facebook_url', '');
        $this->instagram_url = Setting::get('instagram_url', '');
        $this->twitter_url = Setting::get('twitter_url', '');
        $this->youtube_url = Setting::get('youtube_url', '');
        $this->linkedin_url = Setting::get('linkedin_url', '');
        $this->tiktok_url = Setting::get('tiktok_url', '');
        
        // Store
        $this->currency = Setting::get('currency', 'Kz');
        $this->currency_position = Setting::get('currency_position', 'after');
        $this->low_stock_threshold = (int) Setting::get('low_stock_threshold', 10);
        $this->enable_reviews = (bool) Setting::get('enable_reviews', true);
        $this->enable_wishlist = (bool) Setting::get('enable_wishlist', true);
        $this->enable_compare = (bool) Setting::get('enable_compare', true);
        $this->enable_quick_view = (bool) Setting::get('enable_quick_view', true);
        
        // SMS
        $this->sms_enabled = (bool) Setting::get('sms_enabled', false);
        $this->sms_provider = Setting::get('sms_provider', 'unimtx');
        $this->sms_access_key = Setting::get('sms_access_key', '');
        $this->sms_sender_name = Setting::get('sms_sender_name', '');
        
        // Email
        $this->email_enabled = (bool) Setting::get('email_enabled', true);
        $this->smtp_host = Setting::get('smtp_host', '');
        $this->smtp_port = Setting::get('smtp_port', '587');
        $this->smtp_username = Setting::get('smtp_username', '');
        $this->smtp_password = Setting::get('smtp_password', '');
        $this->smtp_encryption = Setting::get('smtp_encryption', 'tls');
    }
    
    public function saveGeneral(): void
    {
        $this->validate([
            'app_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);
        
        Setting::set('app_name', $this->app_name);
        Setting::set('app_description', $this->app_description);
        Setting::set('contact_email', $this->contact_email);
        Setting::set('contact_phone', $this->contact_phone);
        Setting::set('whatsapp_number', $this->whatsapp_number);
        Setting::set('address', $this->address);
        Setting::set('timezone', $this->timezone);
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Configurações gerais salvas com sucesso!',
        ]);
    }
    
    public function saveAppearance(): void
    {
        if ($this->site_logo) {
            $path = $this->site_logo->store('settings', 'public');
            Setting::set('site_logo', $path);
        }
        
        if ($this->site_favicon) {
            $path = $this->site_favicon->store('settings', 'public');
            Setting::set('site_favicon', $path);
        }
        
        Setting::set('primary_color', $this->primary_color);
        Setting::set('secondary_color', $this->secondary_color);
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Aparência salva com sucesso!',
        ]);
    }
    
    public function saveSeo(): void
    {
        if ($this->og_image) {
            $path = $this->og_image->store('settings', 'public');
            Setting::set('og_image', $path);
        }
        
        Setting::set('meta_title', $this->meta_title);
        Setting::set('meta_description', $this->meta_description);
        Setting::set('meta_keywords', $this->meta_keywords);
        Setting::set('google_analytics', $this->google_analytics);
        Setting::set('facebook_pixel', $this->facebook_pixel);
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Configurações de SEO salvas!',
        ]);
    }
    
    public function saveSocial(): void
    {
        Setting::set('facebook_url', $this->facebook_url);
        Setting::set('instagram_url', $this->instagram_url);
        Setting::set('twitter_url', $this->twitter_url);
        Setting::set('youtube_url', $this->youtube_url);
        Setting::set('linkedin_url', $this->linkedin_url);
        Setting::set('tiktok_url', $this->tiktok_url);
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Redes sociais salvas!',
        ]);
    }
    
    public function saveStore(): void
    {
        Setting::set('currency', $this->currency);
        Setting::set('currency_position', $this->currency_position);
        Setting::set('low_stock_threshold', $this->low_stock_threshold);
        Setting::set('enable_reviews', $this->enable_reviews);
        Setting::set('enable_wishlist', $this->enable_wishlist);
        Setting::set('enable_compare', $this->enable_compare);
        Setting::set('enable_quick_view', $this->enable_quick_view);
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Configurações da loja salvas!',
        ]);
    }
    
    public function saveSms(): void
    {
        Setting::set('sms_enabled', $this->sms_enabled);
        Setting::set('sms_provider', $this->sms_provider);
        Setting::set('sms_access_key', $this->sms_access_key);
        Setting::set('sms_sender_name', $this->sms_sender_name);
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Configurações de SMS salvas!',
        ]);
    }
    
    public function saveEmail(): void
    {
        Setting::set('email_enabled', $this->email_enabled);
        Setting::set('smtp_host', $this->smtp_host);
        Setting::set('smtp_port', $this->smtp_port);
        Setting::set('smtp_username', $this->smtp_username);
        Setting::set('smtp_password', $this->smtp_password);
        Setting::set('smtp_encryption', $this->smtp_encryption);
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Configurações de email salvas!',
        ]);
    }
    
    public function runSettingsSeeder(): void
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'Database\\Seeders\\SettingsSeeder',
                '--force' => true,
            ]);
            
            // Recarregar os valores do banco para a view
            $this->mount();
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Configurações padrão restauradas com sucesso! Apenas chaves em falta foram preenchidas.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Erro ao executar seeder: ' . $e->getMessage(),
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.admin.settings.index-spa', [
            'currentLogo' => Setting::get('site_logo'),
            'currentFavicon' => Setting::get('site_favicon'),
            'currentOgImage' => Setting::get('og_image'),
        ]);
    }
}
