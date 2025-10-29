<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class StoryController extends Controller
{
    public function __invoke()
    {
        $chapters = [
            [
                'title' => 'O começo de tudo',
                'subtitle' => 'Um café que virou horas',
                'content' => 'Conhecemo-nos em um café acolhedor, onde a conversa se estendeu por horas. Descobrimos gostos em comum, risadas fáceis e um desejo sincero de nos reencontrarmos.',
            ],
            [
                'title' => 'Construindo memórias',
                'subtitle' => 'Viagens, shows e novas receitas',
                'content' => 'Entre viagens, receitas inventadas na cozinha e maratonas de séries, percebemos que a melhor parte era dividir os pequenos detalhes do dia a dia.',
            ],
            [
                'title' => 'O pedido',
                'subtitle' => 'Um “sim” cheio de emoção',
                'content' => 'Em uma viagem surpresa, entre luzes e promessas, veio o pedido. Choramos, rimos e dissemos o “sim” que nos trouxe até aqui.',
            ],
            [
                'title' => 'O próximo capítulo',
                'subtitle' => 'Construindo nosso lar',
                'content' => 'Agora estamos prontos para celebrar com quem acompanhou cada passo. Queremos dividir esse momento com você e criar memórias para toda a vida.',
            ],
        ];

        $highlights = [
            '7 anos de história',
            '12 viagens juntos',
            'Inúmeras receitas testadas (e algumas bombas)',
            'Um futuro cheio de planos e risadas',
        ];

        return view('story', compact('chapters', 'highlights'));
    }
}
