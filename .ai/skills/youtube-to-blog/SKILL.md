---
name: youtube-to-blog
description: >
  Converte vídeos do YouTube em posts completos para blog em português. Use esta skill sempre que o usuário colar um link do YouTube e quiser gerar conteúdo de blog, artigo, post ou publicação a partir do vídeo. Também deve ser ativada quando o usuário mencionar "transcrever vídeo", "criar post a partir de vídeo", "transformar vídeo em texto/artigo", ou qualquer combinação de YouTube + blog/post/artigo. Gera: título criativo, corpo do post em estilo descontraído e acessível, e 2 a 3 prompts de imagem para ilustrar o post.
---

# YouTube → Blog Post

Skill para transformar qualquer vídeo do YouTube em um post completo de blog em português, com título, corpo do texto e sugestões de imagens.

---

## Fluxo de Trabalho

### Passo 1 — Obter a transcrição do vídeo

Use a ferramenta `web_fetch` para buscar a transcrição via a API pública do YouTube Transcript:

```
https://www.youtube.com/watch?v=VIDEO_ID
```

Extraia o `VIDEO_ID` da URL fornecida pelo usuário. Formatos possíveis:
- `https://www.youtube.com/watch?v=VIDEO_ID`
- `https://youtu.be/VIDEO_ID`
- `https://www.youtube.com/shorts/VIDEO_ID`

**Estratégia de transcrição:**
1. Tente buscar a página do vídeo com `web_fetch` para obter título e descrição
2. Use `web_search` com a query: `"TÍTULO DO VÍDEO" transcrição OR transcript site:youtube.com OR legendas`
3. Alternativamente, busque serviços de transcrição como `youtubetranscript.com/watch?v=VIDEO_ID` ou `tactiq.io`
4. Se não houver transcrição disponível, informe o usuário e use o título + descrição para gerar o post com base no que é possível inferir — deixe claro isso ao usuário

### Passo 2 — Analisar o conteúdo

A partir da transcrição (ou do máximo de informação disponível), identifique:

- **Tema central**: do que o vídeo trata, em uma frase
- **Pontos principais**: os 3 a 5 tópicos mais importantes abordados
- **Tom**: o vídeo é educativo, opinativo, tutorial, entretenimento?
- **Público-alvo**: para quem esse conteúdo foi feito?

### Passo 3 — Gerar o post

Escreva o post com as seguintes características:

**Idioma**: Português brasileiro  
**Tom**: Descontraído e acessível — como se estivesse explicando para um amigo. Sem jargão desnecessário, sem ser formal demais. Pode usar expressões coloquiais com moderação.  
**Comprimento**: Entre 500 e 900 palavras (corpo do post, sem o título)

**Estrutura do post:**
```
[TÍTULO]
Título criativo, curto (até 10 palavras), que gere curiosidade sem ser clickbait.
Pode usar números, perguntas ou afirmações impactantes.

[INTRODUÇÃO]
2-3 parágrafos que contextualizem o tema e prendam a atenção do leitor.
Comece com algo que ressoe: uma pergunta, uma situação do cotidiano, ou um dado curioso.

[DESENVOLVIMENTO]
3-4 seções com subtítulos claros (use ## para h2).
Cada seção aprofunda um ponto principal do vídeo.
Use linguagem simples, exemplos concretos e, quando cabível, listas.

[CONCLUSÃO]
1-2 parágrafos fechando o raciocínio.
Pode incluir um call-to-action leve (ex: "Você já tinha pensado nisso? Compartilha nos comentários!").
```

### Passo 4 — Gerar prompts de imagem

Crie **2 a 3 prompts em inglês** para geração de imagens que ilustrem o post. Os prompts devem:

- Ser descritivos e específicos (estilo, cores, elementos visuais)
- Ser adequados ao tema e ao tom do post (descontraído, acessível)
- Variar entre si (ex: uma imagem de capa, uma ilustrativa de conceito, uma de apoio)
- Evitar rostos de pessoas reais ou elementos protegidos por direitos autorais
- Indicar o estilo artístico desejado (ex: flat illustration, digital art, photography style)

**Formato do prompt:**
```
Imagem 1 (Capa): [prompt em inglês]
Imagem 2 (Ilustração): [prompt em inglês]
Imagem 3 (Apoio): [prompt em inglês] (opcional)
```

---

## Output Final

Entregue o resultado neste formato estruturado para facilitar a integração com o sistema do usuário:

```
---TÍTULO---
[título aqui]

---POST---
[corpo completo do post aqui, com subtítulos em markdown]

---IMAGENS---
Imagem 1 (Capa): [prompt]
Imagem 2 (Ilustração): [prompt]
Imagem 3 (Apoio): [prompt]

---META---
Tema central: [uma frase]
Palavras estimadas: [número]
Tom identificado no vídeo: [educativo / opinativo / tutorial / entretenimento / misto]
```

---

## Tratamento de Erros

| Situação | Ação |
|---|---|
| Transcrição indisponível | Gerar post com base em título + descrição; avisar o usuário |
| Vídeo em outro idioma | Traduzir e adaptar para português; mencionar o idioma original |
| Vídeo muito curto (<2 min) | Gerar post mais enxuto (~300-400 palavras); avisar |
| Link inválido | Pedir ao usuário para confirmar o link |
| Conteúdo inadequado | Informar e não gerar o post |

---

## Notas

- Não reproduza trechos literais longos da transcrição — reescreva com suas palavras
- O post deve ter valor próprio, não ser apenas um resumo do vídeo
- Se o vídeo tiver capítulos ou timestamps, use-os como guia para a estrutura do post
- Mantenha a essência e a perspectiva do criador original, mas adapte para o formato escrito