<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class PrivacyController extends Controller
{
    public function __invoke()
    {
        $sections = [
            [
                'title' => 'Coleta de dados',
                'content' => 'Registramos apenas informações fornecidas voluntariamente no RSVP, mural de mensagens e lista de presentes (nome, e-mail, telefone e mensagens).',
            ],
            [
                'title' => 'Uso das informações',
                'content' => 'Utilizamos os dados exclusivamente para organização do casamento: confirmações, agradecimentos e comunicação sobre o evento.',
            ],
            [
                'title' => 'Armazenamento e segurança',
                'content' => 'Os dados ficam armazenados em ambiente seguro, com acesso restrito aos noivos. Não compartilhamos com terceiros sem consentimento.',
            ],
            [
                'title' => 'Direitos dos convidados',
                'content' => 'Você pode solicitar atualização ou remoção das suas informações a qualquer momento. Basta enviar um e-mail para o contato oficial do casal.',
            ],
        ];

        return view('privacy', compact('sections'));
    }
}
