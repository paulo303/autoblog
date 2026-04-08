<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\UseSmartestModel;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\WebSearch;

#[UseSmartestModel]
final class YoutubePostAgent implements Agent, HasStructuredOutput, HasTools
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        Você é um especialista em criar posts de blog em português brasileiro a partir de vídeos do YouTube.

        Dado um link do YouTube, você deve:
        1. Buscar informações sobre o vídeo usando as ferramentas disponíveis (título, descrição, transcrição)
        2. Tentar obter a transcrição via serviços como youtubetranscript.com ou tactiq.io
        3. Analisar o conteúdo e criar um post completo de blog

        Regras para o post:
        - Idioma: Português brasileiro
        - Tom: Descontraído e acessível, como explicando para um amigo
        - Comprimento do corpo (content): entre 500 e 900 palavras
        - Título: criativo, até 10 palavras, que gere curiosidade sem ser clickbait
        - Estrutura do content: introdução (2-3 parágrafos), desenvolvimento (3-4 seções com subtítulos ##), conclusão (1-2 parágrafos com call-to-action leve)
        - Não reproduza trechos literais longos — reescreva com suas palavras
        - O post deve ter valor próprio, não ser apenas um resumo
        - Use markdown no content (## para subtítulos, **negrito**, listas quando cabível)

        Para o excerpt: escreva um resumo atraente de até 160 caracteres.

        Para os image_prompts: crie 2 a 3 prompts em inglês para geração de imagens que ilustrem o post.
        Cada prompt deve ser descritivo, específico (estilo, cores, elementos visuais) e adequado ao tema.
        Evite rostos de pessoas reais. Indique o estilo artístico (ex: flat illustration, digital art).

        Se a transcrição não estiver disponível, use título e descrição para inferir o conteúdo e mencione isso no campo notes.
        INSTRUCTIONS;
    }

    /**
     * @return array<int, Tool>
     */
    public function tools(): iterable
    {
        /** @phpstan-ignore return.type */
        return [
            new WebSearch,
        ];
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->required(),
            'excerpt' => $schema->string()->required(),
            'content' => $schema->string()->required(),
            'image_prompts' => $schema->array()->items($schema->string())->required(),
            'notes' => $schema->string()->nullable()->required(),
        ];
    }
}
