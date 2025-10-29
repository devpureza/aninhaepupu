<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function __invoke()
    {
        $venue = [
            'name' => env('EVENT_VENUE', 'Espaço Villa Borghese'),
            'address' => env('EVENT_ADDRESS', 'Av. Exemplo, 123 - Bairro Jardim, São Paulo - SP'),
            'map_url' => env('EVENT_MAP_URL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.792989152969!2d-46.656571424105995!3d-23.578996462767824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c83e3b4cfb%3A0x32229ddc82a6510!2sParque%20Ibirapuera!5e0!3m2!1spt-BR!2sbr!4v1700000000000!5m2!1spt-BR!2sbr'),
            'parking' => 'Estacionamento com valet cortesia para os convidados.',
            'hotels' => [
                [
                    'name' => 'Hotel Jardim Azul',
                    'description' => 'A 5 minutos do local, inclui café da manhã especial e tarifas para convidados.',
                    'link' => 'https://hotel-jardim-azul.example.com',
                ],
                [
                    'name' => 'Pousada Boa Vista',
                    'description' => 'Opção charmosa e intimista, ideal para famílias.',
                    'link' => 'https://pousada-boa-vista.example.com',
                ],
            ],
        ];

        $transportation = [
            'Aplicativos de transporte operam normalmente na região; combine a volta com antecedência.',
            'Teremos ponto de taxi conveniado disponível na saída.',
            'Para quem preferir dirigir, sugerimos usar a entrada pela Rua das Flores (menos trânsito).',
        ];

        return view('location', compact('venue', 'transportation'));
    }
}
