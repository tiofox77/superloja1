<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Product;

class HeroSection extends Component
{
    public array $slides = [];
    public int $currentSlide = 0;

    public function mount(): void
    {
        // Pegar produtos com imagens para o slide
        $featuredProducts = Product::with(['category'])
            ->where('is_active', true)
            ->whereNotNull('featured_image')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $this->slides = [];

        foreach ($featuredProducts as $index => $product) {
            $backgrounds = [
                'from-blue-600 to-purple-600',
                'from-purple-600 to-pink-600', 
                'from-green-600 to-blue-600'
            ];

            $this->slides[] = [
                'title' => 'Descubra ' . $product->name,
                'subtitle' => 'Tecnologia de ponta com os melhores preços',
                'description' => 'Ofertas imperdíveis em Angola com entrega rápida e segura.',
                'button_text' => 'Ver Produto',
                'button_link' => '/produtos',
                'background' => $backgrounds[$index] ?? 'from-orange-600 to-red-600',
                'image' => $product->featured_image,
                'product_id' => $product->id,
                'price' => $product->sale_price ?? $product->price
            ];
        }

        // Se não tiver produtos suficientes, adicionar slides padrão
        if (count($this->slides) < 3) {
            $defaultSlides = [
                [
                    'title' => 'Descubra a Tecnologia do Futuro',
                    'subtitle' => 'Os melhores smartphones, computadores e acessórios',
                    'description' => 'Ofertas imperdíveis em Angola com entrega rápida e segura.',
                    'button_text' => 'Explorar Produtos',
                    'button_link' => '/produtos',
                    'background' => 'from-blue-600 to-purple-600'
                ],
                [
                    'title' => 'Gaming de Última Geração',
                    'subtitle' => 'PlayStation, Xbox e PC Gaming',
                    'description' => 'Equipamentos profissionais para uma experiência única.',
                    'button_text' => 'Ver Gaming',
                    'button_link' => '/produtos',
                    'background' => 'from-purple-600 to-pink-600'
                ],
                [
                    'title' => 'Trabalho e Produtividade',
                    'subtitle' => 'MacBooks, Laptops e Estações de Trabalho',
                    'description' => 'Ferramentas profissionais para aumentar sua produtividade.',
                    'button_text' => 'Ver Computadores',
                    'button_link' => '/produtos',
                    'background' => 'from-green-600 to-blue-600'
                ]
            ];

            $this->slides = array_merge($this->slides, array_slice($defaultSlides, count($this->slides)));
        }
    }

    public function nextSlide(): void
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->slides);
    }

    public function prevSlide(): void
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->slides)) % count($this->slides);
    }

    public function goToSlide(int $index): void
    {
        $this->currentSlide = $index;
    }

    public function render()
    {
        return view('livewire.components.hero-section');
    }
}
