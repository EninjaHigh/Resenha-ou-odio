# 🔥 Resenha ou Ódio - Cara ou Coroa 3D

Um site moderno, interativo e imersivo de Cara ou Coroa criado para solucionar qualquer dúvida ou disputa de forma justa, épica e divertida.

Desenvolvido estritamente conforme todos os requisitos estabelecidos em [Requisitos.md](Requisitos.md).

---

## 🚀 Funcionalidades & Requisitos Implementados

1. **Página Inicial Vibrante com Cores Quentes**:
   - Título oficial estilizado: **Resenha ou ódio** em degradê de fogo com brilho e tipografia moderna.
   - Moeda 3D realista no centro com duas faces: **CARA** e **COROA**.
   - A moeda fica continuamente **flutuando e girando** em 3D.
   - Botão **JOGAR** em degradê quente pulsante posicionado logo abaixo da moeda.

2. **Galeria de Seleção de Moedas Temáticas**:
   - Ao clicar no botão **Jogar**, o usuário é direcionado para a página de seleção de moedas.
   - Diversos designs detalhados e exclusivos de moedas:
     - ⚽ **Times de Futebol**: *Flamengo vs Vasco* (Clássico dos Milhões), *Corinthians vs Palmeiras* (Derby Paulista), *Real Madrid vs Barcelona* (El Clásico).
     - 🎮 **Jogos & Videogames**: *Minecraft vs Roblox*, *Mario vs Sonic*, *PlayStation vs Xbox*.
     - 🦸 **Super-Heróis**: *Batman vs Coringa*, *Homem-Aranha vs Venom*.
     - 🌍 **Países**: *Brasil vs Argentina*, *Japão vs Estados Unidos*.
     - 🔥 **Resenha ou Ódio**: A edição oficial da resenha e treta do rolê.
     - 👑 **Clássica**: Cara ou Coroa imperial dourada.
     - ✨ **Criador de Moeda Personalizada**: Permite criar duelos próprios com qualquer tema (ex: Pizza vs Hambúrguer, Praia vs Cinema).
   - Filtros por categoria e campo de busca instantânea.

3. **Página de Resultado com Sorteio 3D e Contagem Regressiva**:
   - Abre diretamente ao selecionar uma moeda para jogar.
   - A moeda com o design escolhido surge no centro da tela girando em alta velocidade 3D.
   - **Contagem regressiva de três segundos (3, 2, 1)** na tela com animações e efeitos sonoros.
   - Ao finalizar a contagem:
     - A moeda desacelera com física realista e para exatamente na face sorteada (50% de chance para cada lado).
     - Revelação impactante do vencedor com banner comemorativo, frase de veredito, explosão de confetes e fanfarra.
     - Botão em destaque **Jogar Novamente** para repetir a rodada imediatamente.
     - Botões para **Trocar Moeda** e **Voltar ao Início**.
     - Placar dinâmico de vitórias da sessão.

4. **Identidade Visual com Degradê de Cores Quentes**:
   - Paleta rica composta por tons de vermelho fogo, laranja intenso, âmbar, amarelo dourado e carmesim.
   - Efeitos de profundidade com vidro fosco (glassmorphism), auras e iluminação dinâmica.

5. **Efeitos Sonoros Integrados (Web Audio API)**:
   - Síntese de áudio nativa direto no navegador (sem arquivos pesados ou problemas de carregamento):
     - Som de lançamento metálico da moeda.
     - Beep sincronizado da contagem regressiva (3... 2... 1...).
     - Som de aterrissagem e impacto no solo.
     - Fanfarra triunfal na vitória.
   - Botão para ativar/desativar o áudio no topo com preferência salva.

---

## 🛠️ Tecnologias Utilizadas

- **HTML5 Semântico**: Estruturação acessível e otimizada como Single Page Application (SPA).
- **CSS3 Avançado**: Transformações 3D (`perspective`, `transform-style: preserve-3d`, `rotateY`), degradês de cores quentes e animações fluidas a 60 FPS.
- **JavaScript Moderno (ES6+)**:
  - Máquina de estados para navegação instantânea.
  - Web Audio API para síntese sonora pura em tempo real.
  - Canvas 2D para efeitos de confetes dinâmicos.
  - Randomização justa de 50/50.

---

## 💻 Como Executar

Não requer instalação de Node, Python ou qualquer servidor complexo!

1. Basta dar um duplo clique no arquivo `index.html` para abrir diretamente em qualquer navegador moderno (Chrome, Edge, Firefox, Safari, Opera).
2. Ou utilize qualquer servidor local estático (como Live Server do VS Code) se preferir.

---

## 📄 Licença

Este projeto está sob a licença MIT - consulte o arquivo [LICENSE](LICENSE) para detalhes.
