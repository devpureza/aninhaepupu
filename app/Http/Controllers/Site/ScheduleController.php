<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function __invoke()
    {
        $timeline = [
            [
                'time' => '16h00',
                'title' => 'Chegada e boas-vindas',
                'description' => 'Recepcionistas estarão à porta para direcionar convidados, com água aromatizada e estação de fotos.',
            ],
            [
                'time' => '16h30',
                'title' => 'Cerimônia ao ar livre',
                'description' => 'Cerimônia conduzida pelo nosso celebrante querido, com música ao vivo e votos personalizados.',
            ],
            [
                'time' => '17h30',
                'title' => 'Brinde dos recém-casados',
                'description' => 'Logo após a cerimônia, faremos o brinde oficial com todos — prepare a taça e o sorriso!',
            ],
            [
                'time' => '18h00',
                'title' => 'Jantar e estações gastronômicas',
                'description' => 'Buffet completo, com opções vegetarianas e mesa de antepastos. Não pule a mesa de doces!',
            ],
            [
                'time' => '20h00',
                'title' => 'Primeira dança e pista liberada',
                'description' => 'Numa playlist que mistura nossas músicas favoritas e sucessos imperdíveis.',
            ],
            [
                'time' => '23h00',
                'title' => 'Encerramento',
                'description' => 'Para terminar com energia, serviremos lanchinhos da madrugada e distribuir lembranças especiais.',
            ],
        ];

        $tips = [
            'Chegue com 15 minutos de antecedência para aproveitar o pôr do sol.',
            'Traje sugerido: passeio completo (tons claros e tecidos leves são bem-vindos).',
            'Haverá chapelaria e serviço de manobrista no local.',
            'Crianças são super bem-vindas — teremos uma área kids com monitores.',
        ];

        return view('schedule', compact('timeline', 'tips'));
    }
}
