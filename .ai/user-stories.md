Você é um desenvolvedor sênior especialista em Laravel, Livewire, Blade, Tailwind CSS, autenticação, arquitetura limpa, UX/UI moderna e testes com Pest.

Quero que você crie um projeto completo de blog com painel administrativo, seguindo boas práticas de arquitetura, frontend moderno e código limpo.

## Objetivo do projeto

Criar um blog chamado **Daily Tech News**, com área pública e área administrativa.

---

## Requisitos técnicos

- Usar **Laravel** (preferencialmente com a estrutura mais moderna e organizada)
- Criar autenticação completa de login
- Usar **Blade + Tailwind CSS**
- Layout **dark mode**, moderno, profissional e minimalista
- Frontend com boas práticas de blog
- Código limpo, organizado e legível
- Criar **testes com Pest**
- Usar **enum** para status dos posts
- Ordenar os posts do **mais novo para o mais antigo**
- Mostrar no blog público **somente posts publicados**
- O autor deve ser fixo como **Daily Tech News**
- Criar seed com usuário administrador:
    - `name: admin`
    - `email: admin@autoblog.com`
    - `password: password`

---

## Regras da área pública

### Página principal do blog
A página principal deve:

- mostrar os **5 posts publicados mais recentes**
- cada post deve exibir:
    - título
    - data
    - autor fixo: `Daily Tech News`
    - trecho/resumo do conteúdo
    - imagem de capa, se existir
    - link para visualizar o post completo
- abaixo da lista deve existir um botão **"Ler mais"**
- ao clicar em **"Ler mais"**, devem ser carregados os próximos 5 posts
- continuar a paginação em blocos de 5 posts
- os posts devem aparecer do mais novo para o mais antigo
- não mostrar posts em rascunho, arquivados ou não publicados

### Página individual do post
A página individual deve:

- mostrar o post completo
- exibir título, data e autor
- exibir imagens relacionadas, se existirem
- usar layout agradável para leitura
- exibir apenas posts publicados
- se o post não estiver publicado, deve retornar 404 na área pública

---

## Regras da área administrativa

O usuário administrador deve conseguir fazer login e acessar rotas com prefixo:

`/admin`

### Após login
Ao logar, o usuário deve ser redirecionado para:

`/admin/posts`

### Tela /admin/posts
A listagem de posts deve mostrar pelo menos:

- título
- status
- data de criação
- data de atualização
- ações para visualizar, editar e excluir
- botão para criar novo post
- ordenação do mais novo para o mais antigo

### CRUD administrativo de posts
O administrador deve conseguir:

- listar posts
- criar post
- editar post
- excluir post
- publicar ou deixar como rascunho
- adicionar imagens ao post
- visualizar preview das imagens, se possível

---

## Estrutura de banco de dados

Crie as tabelas abaixo, ajustando e adicionando colunas se necessário para um projeto profissional.

### Tabela `posts`
Campos iniciais:

- `id`
- `title`
- `text` (o conteúdo do post; se você considerar melhor, pode renomear para `content`)
- `status`
- `created_at`
- `updated_at`

Ajustes esperados:
- adicionar `slug` único para URL amigável
- adicionar `excerpt` ou gerar resumo automaticamente para listagem
- adicionar `published_at` para controle real de publicação
- considerar `deleted_at` se usar soft deletes

### Tabela `post_images`
Campos iniciais:

- `id`
- `post_id`
- `filename`
- `url`
- `created_at`
- `updated_at`

Ajustes esperados:
- relacionamento correto com posts
- possibilidade de definir imagem de capa, se necessário
- considerar ordem das imagens

---

## Enum de status

Criar uma enum para status de post com estados comuns, por exemplo:

- Draft
- Published
- Archived

A enum deve ter métodos úteis para label e possíveis usos em badge/status visual.

---

## Regras de modelagem

- Post possui muitas imagens
- Post deve ter scope para publicados
- Post público só aparece se estiver com status publicado
- Autor exibido no frontend será sempre fixo como `Daily Tech News`
- URLs dos posts devem usar slug
- Usar route model binding por slug na área pública, se fizer sentido

---

## Regras de autenticação

- Implementar autenticação completa de login
- Apenas usuários autenticados podem acessar `/admin/*`
- Usuário não autenticado deve ser redirecionado para login
- Criar seeder com usuário admin padrão:
    - nome: admin
    - email: admin@autoblog.com
    - senha: password

---

## Requisitos de frontend

Criar um visual:

- dark mode
- moderno
- profissional
- minimalista
- com ótima legibilidade
- bom espaçamento
- tipografia agradável
- cards elegantes na listagem
- página do post com leitura confortável
- responsivo para desktop e mobile

Evitar visual genérico. Quero um resultado caprichado, com aparência de produto real.

---

## Requisitos de UX

- botão "Ler mais" claro e elegante
- feedback visual em ações do admin
- formulários organizados
- listagem fácil de ler
- navegação intuitiva
- estados vazios tratados
- mensagens de validação amigáveis

---

## Testes com Pest

Criar testes cobrindo pelo menos:

### Área pública
- exibe apenas posts publicados
- ordena posts do mais novo para o mais antigo
- mostra 5 posts por vez
- botão "Ler mais" carrega os próximos 5
- página individual exibe post publicado
- página individual retorna 404 para post não publicado

### Autenticação
- usuário admin consegue logar
- usuário não autenticado não acessa `/admin/posts`

### Área administrativa
- admin consegue listar posts
- admin consegue criar post
- admin consegue editar post
- admin consegue excluir post
- validações obrigatórias funcionam

---

## Entrega esperada

Quero que você gere:

1. migrations
2. models
3. enums
4. seeders
5. factories
6. controllers ou Livewire components, conforme melhor arquitetura
7. requests de validação
8. rotas web
9. views Blade
10. layout completo do frontend e admin
11. testes com Pest
12. código organizado e pronto para rodar

---

## Boas práticas obrigatórias

- nomes claros
- responsabilidade bem separada
- validação em classes próprias
- uso de enums
- evitar lógica excessiva na view
- código elegante e profissional
- comentários apenas quando realmente necessários

---

## Observações finais

Se encontrar pontos ambíguos, tome decisões sensatas de arquitetura e UX, mantendo o objetivo principal:
um blog moderno, dark mode, com painel admin simples e profissional, e foco em posts publicados com paginação em blocos de 5 usando botão “Ler mais”.