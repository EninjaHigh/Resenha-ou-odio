# 🪙 Resenha ou Ódio

> Um sistema web completo, responsivo e seguro para definir no Cara ou Coroa: **Cara = Resenha 😎** (50%) ou **Coroa = Ódio 😡** (50%).

Construído estritamente de acordo com as especificações e regras estabelecidas em [requisitos.md](requisitos.md).

---

## 🎯 Objetivos do Projeto

- Jogar uma moeda em 3D interativa e definir o resultado com probabilidade imparcial e exata de **50%**:
  - **Cara = Resenha** 😎🍺🎉
  - **Coroa = Ódio** 😡🔥💥
- Garantir rastreabilidade total através de **Logs de Auditoria** para qualquer alteração ou evento realizado por qualquer usuário.
- Interface moderna **Mobile-First** desenvolvida com **Tailwind CSS**.
- Retornar todas as mensagens e erros de forma amigável através de **TOAST**.
- Interceptar diálogos nativos do navegador (`alert`, `confirm`) através de **MODAL** customizado.

---

## 🛠️ Stack Tecnológica

- **Backend**: PHP 8.x estruturado com sessões nativas (`session_start`)
- **Banco de Dados**: MySQL com **PDO** e Prepared Statements (proteção total contra SQL Injection)
- **Segurança de Senhas**: Hash criptográfico **Bcrypt** (`PASSWORD_BCRYPT`)
- **Frontend**: HTML5, PHP, CSS3 (transformações e animações 3D) e **Tailwind CSS**
- **Áudio**: Efeitos sonoros sintetizados nativamente com **Web Audio API** (sem arquivos de áudio pesados externos)

---

## 📁 Estrutura de Arquivos (Arquitetura Desacoplada)

O sistema foi modelado de forma não monolítica, separando estritamente regras de negócio, conexão de dados e visualização:

```text
Projeto/
├── config/
│   └── config.php          # Configurações de banco, constantes e sessões nativas
├── bd.php                  # Conexão central PDO com MySQL e auto-inicializador
├── database.sql            # Script SQL de criação do banco, tabelas e dados iniciais
├── includes/
│   ├── auth.php            # Sessões nativas, controle de acesso e hash Bcrypt
│   ├── logger.php          # Sistema central de Logs de Auditoria do sistema
│   ├── flash.php           # Gerenciador de mensagens de sessão para Toasts
│   ├── header.php          # Header com Navbar responsiva Mobile-First Tailwind
│   ├── footer.php          # Rodapé responsivo e inclusão de componentes
│   ├── modal.php           # Componente de Modal customizado (substitui alert/confirm)
│   └── toast.php           # Container visual flutuante de Toasts
├── actions/
│   ├── jogar.php           # Backend isolado: sorteio da moeda (50%) e gravação de auditoria
│   ├── login_process.php   # Backend isolado: autenticação Bcrypt e logs de acesso
│   ├── cadastro_process.php# Backend isolado: validação, hash Bcrypt e criação de conta
│   ├── logout.php          # Backend isolado: encerramento seguro de sessão
│   ├── perfil_process.php  # Backend isolado: atualização de perfil e senha
│   └── exportar_auditoria.php# Backend isolado: exportação dos logs em CSV/JSON
├── assets/
│   ├── css/
│   │   └── style.css       # Animações 3D da moeda, profundidade e glow
│   └── js/
│       ├── coin.js         # Lógica da moeda 3D, física e áudio Web Audio API
│       ├── toast.js        # Engine do sistema de Toasts flutuantes
│       └── modal.js        # Engine do sistema de Modais
├── index.php               # View: Jogo da moeda 3D "Resenha ou Ódio" (Mobile First)
├── login.php               # View: Tela de autenticação com validação
├── cadastro.php            # View: Tela de cadastro de novos usuários
├── historico.php           # View: Histórico de lançamentos e Logs de Auditoria com filtros
├── perfil.php              # View: Perfil do usuário e configurações de segurança
├── docker-compose.yml      # Ambiente Docker pronto (PHP 8.2 + MySQL 8 + phpMyAdmin)
├── Dockerfile              # Imagem Docker com Apache e extensões PDO MySQL
├── requisitos.md           # Requisitos originais do projeto
└── README.md               # Documentação completa
```

---

## 🚀 Como Executar o Projeto

Você pode rodar o projeto de qualquer uma das três formas abaixo:

### Opção 1: Usando XAMPP / Laragon / WampServer (Mais Rápido no Windows)

1. Mova esta pasta do projeto para o diretório raiz do seu servidor local:
   - No **XAMPP**: `C:\xampp\htdocs\resenha-ou-odio`
   - No **Laragon**: `C:\laragon\www\resenha-ou-odio`
2. Inicie os módulos **Apache** e **MySQL** no painel do XAMPP ou Laragon.
3. Se desejar, importe o arquivo [`database.sql`](database.sql) no seu phpMyAdmin ou deixe o arquivo [`bd.php`](bd.php) auto-inicializar o banco automaticamente!
4. Abra no seu navegador:
   ```url
   http://localhost/resenha-ou-odio
   ```

---

### Opção 2: Usando Docker (1 Comando)

Se você possui o Docker instalado:

```bash
docker compose up -d
```

- Aplicação web: [http://localhost:8080](http://localhost:8080)
- phpMyAdmin: [http://localhost:8081](http://localhost:8081)
- MySQL Host: `localhost:3306` (Usuário: `root`, Senha: `rootpassword`)

---

### Opção 3: Usando o Servidor Embutido do PHP CLI

Tendo o PHP e MySQL instalados:

```bash
# Inicia o servidor embutido do PHP
php -S localhost:8000
```
Acesse [http://localhost:8000](http://localhost:8000).

---

## 🔐 Conta de Demonstração

Para testar imediatamente todas as áreas autenticadas e de auditoria:

- **E-mail:** `admin@resenha.com`
- **Senha:** `admin123`

*(A senha está armazenada no banco com hash Bcrypt).*

---

## 📋 Conformidade com as Regras de Negócio (CORE)

| Requisito | Como foi atendido |
| :--- | :--- |
| **50% de chance (Cara = Resenha, Coroa = Ódio)** | Sorteio no backend via `random_int(0, 1)` (criptograficamente seguro) em [`actions/jogar.php`](actions/jogar.php). |
| **Backend em PHP com sessões nativas** | Uso de `session_start()`, `$_SESSION` protegida com HttpOnly e SameSite em [`config/config.php`](config/config.php) e [`includes/auth.php`](includes/auth.php). |
| **Banco MySQL com PDO** | Conexão estrita via PDO com Prepared Statements e `PDO::ERRMODE_EXCEPTION` em [`bd.php`](bd.php). |
| **Senhas com Hash Bcrypt** | Tratadas com `password_hash($senha, PASSWORD_BCRYPT)` e `password_verify` em [`includes/auth.php`](includes/auth.php). |
| **Página de Históricos e Logs de Auditoria** | Tela dedicada em [`historico.php`](historico.php) com abas de lançamentos e auditoria imutável, filtros e exportação (CSV/JSON). |
| **Código não monolítico** | Separação lógica total entre views (`*.php`), rotas de backend (`actions/*.php`), regras de negócio (`includes/*.php`) e conexão (`bd.php`). |
| **Mobile-First & Tailwind CSS** | Interface totalmente responsiva construída com classes utilitárias do Tailwind CSS. |
| **Erros e mensagens em TOAST** | Sistema customizado de notificações Toast dinâmicas em [`assets/js/toast.js`](assets/js/toast.js) e [`includes/toast.php`](includes/toast.php). |
| **Substituição de alert nativo por MODAL** | Interceptador global em [`assets/js/modal.js`](assets/js/modal.js) que substitui `alert()` e diálogos por modais Tailwind. |

---

## 📜 Licença

Distribuído sob a licença MIT. Consulte o arquivo de licença para mais informações.
