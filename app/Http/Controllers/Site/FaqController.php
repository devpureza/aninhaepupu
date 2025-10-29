<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function __invoke()
    {
        $faqs = [
            [
                'question' => 'Qual o traje recomendado?',
                'answer' => 'Sugerimos traje passeio completo. Tecidos leves e tons claros combinam perfeitamente com o local e o horário.',
            ],
            [
                'question' => 'Crianças são bem-vindas?',
                'answer' => 'Sim! Teremos um espaço kids com monitores e atividades para que os pequenos aproveitem com segurança.',
            ],
            [
                'question' => 'Há estacionamento no local?',
                'answer' => 'Sim, contamos com serviço de valet incluso para os convidados. Se preferir aplicativo de transporte, a área tem boa cobertura.',
            ],
            [
                'question' => 'Posso levar acompanhante?',
                'answer' => 'Se possível, confirme no RSVP o número de acompanhantes. Assim reservamos os lugares com antecedência.',
            ],
            [
                'question' => 'Como posso presentear?',
                'answer' => 'Nossa lista está na página Presentes & Cotinhas. Lá você ajuda com experiências da nossa lua de mel ou contribui com um valor livre.',
            ],
        ];

        return view('faq', compact('faqs'));
    }
}
