<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Anti-spam: Honeypot check (bots fill hidden fields)
        if ($request->filled('website') || $request->filled('phone_number')) {
            // Silently redirect to avoid revealing the trap
            return redirect(route('register'));
        }

        // Anti-spam: Minimum time check (bots submit instantly)
        $formLoadedAt = (int) $request->input('_form_loaded_at', 0);
        if ($formLoadedAt > 0 && (now()->timestamp - $formLoadedAt) < 3) {
            return redirect(route('register'))
                ->withInput($request->only('name', 'email'))
                ->withErrors(['name' => 'Formulário submetido demasiado rápido. Tente novamente.']);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3', 'regex:/^[\pL\s\.\-\']+$/u'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.regex' => 'O nome deve conter apenas letras, espaços e hífens.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
        ]);

        // Anti-spam: Reject gibberish names (no vowels or too many consonants in a row)
        $name = $request->name;
        if ($this->isGibberishName($name)) {
            return redirect(route('register'))
                ->withInput($request->only('name', 'email'))
                ->withErrors(['name' => 'Por favor, insira um nome válido.']);
        }

        // Anti-spam: Block disposable/spam email domains
        $emailDomain = strtolower(substr(strrchr($request->email, '@'), 1));
        if ($this->isDisposableEmail($emailDomain)) {
            return redirect(route('register'))
                ->withInput($request->only('name', 'email'))
                ->withErrors(['email' => 'Este domínio de email não é permitido. Use um email válido.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Detect gibberish/random names typical of spam bots.
     */
    private function isGibberishName(string $name): bool
    {
        $name = strtolower(trim($name));

        // Must contain at least one vowel
        if (!preg_match('/[aeiouáéíóúâêîôûàèìòùãõ]/u', $name)) {
            return true;
        }

        // Must contain at least one space (first + last name) — optional but effective
        // Disabled: some legitimate single names exist

        // Check for too many consecutive consonants (4+)
        if (preg_match('/[^aeiouáéíóúâêîôûàèìòùãõ\s\-\.]{5,}/u', $name)) {
            return true;
        }

        // Check vowel ratio — real names typically have 30-60% vowels
        $letters = preg_replace('/[^a-záéíóúâêîôûàèìòùãõ]/u', '', $name);
        if (strlen($letters) > 0) {
            $vowels = preg_match_all('/[aeiouáéíóúâêîôûàèìòùãõ]/u', $letters);
            $ratio = $vowels / strlen($letters);
            if ($ratio < 0.15 || $ratio > 0.85) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if email domain is disposable/spam.
     */
    private function isDisposableEmail(string $domain): bool
    {
        $blocked = [
            'checkyourform.xyz', 'mailinator.com', 'guerrillamail.com', 'tempmail.com',
            'throwaway.email', 'fakeinbox.com', 'sharklasers.com', 'guerrillamailblock.com',
            'grr.la', 'dispostable.com', 'yopmail.com', 'trashmail.com', 'mailnesia.com',
            'maildrop.cc', 'discard.email', 'temp-mail.org', 'getnada.com', 'mohmal.com',
            'tempail.com', 'emailondeck.com', 'mintemail.com', 'tempr.email', 'fakemail.net',
            '10minutemail.com', 'guerrillamail.info', 'spam4.me', 'binkmail.com',
            'safetymail.info', 'trashmail.net', 'mailcatch.com', 'mvrht.net',
        ];

        // Block known spam domains
        if (in_array($domain, $blocked)) {
            return true;
        }

        // Block suspicious TLDs commonly used by spam
        $suspiciousTlds = ['.xyz', '.top', '.click', '.buzz', '.gq', '.ml', '.cf', '.tk', '.ga', '.icu', '.rest', '.monster'];
        foreach ($suspiciousTlds as $tld) {
            if (str_ends_with($domain, $tld)) {
                return true;
            }
        }

        return false;
    }
}
