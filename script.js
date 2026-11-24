/**
 * RESENHA OU ÓDIO - JOGO DE CARA OU COROA 3D
 * Contagem regressiva, física de rotação 3D, síntese de áudio Web Audio API,
 * galeria com múltiplos designs temáticos e confetes.
 */

// ==========================================================================
// BANCO DE DADOS DE MOEDAS E DESIGNS
// ==========================================================================
const COINS_DATABASE = [
  // TEMA OFICIAL DO SITE
  {
    id: 'resenha-odio',
    category: 'resenha',
    name: 'Resenha ou Ódio',
    subtitle: 'O duelo supremo do fim de semana',
    sideA: {
      name: 'Resenha',
      badge: 'RESENHA',
      gradient: 'radial-gradient(circle at 35% 35%, #ffd54f 0%, #ff9800 60%, #e65100 100%)',
      borderColor: '#ffb300',
      textColor: '#2e1c0c',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#ffb74d" stroke="#f57c00" stroke-width="4"/>
          <!-- Óculos de sol Resenha -->
          <path d="M22 42 Q36 34 50 42 Q64 34 78 42 L74 54 Q64 62 52 56 Q50 55 48 56 Q36 62 26 54 Z" fill="#212121" stroke="#000" stroke-width="2"/>
          <line x1="28" y1="46" x2="38" y2="44" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
          <line x1="62" y1="46" x2="72" y2="44" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
          <!-- Sorriso maroto -->
          <path d="M34 68 Q50 82 66 68" fill="none" stroke="#212121" stroke-width="5" stroke-linecap="round"/>
          <circle cx="34" cy="67" r="3" fill="#ff7043"/>
          <circle cx="66" cy="67" r="3" fill="#ff7043"/>
        </svg>
      `,
      verdict: 'Hoje o dia é só RESENHA, alegria e churrasco liberado! 🍻😎'
    },
    sideB: {
      name: 'Ódio',
      badge: 'ÓDIO',
      gradient: 'radial-gradient(circle at 35% 35%, #ff5252 0%, #d50000 60%, #5c0000 100%)',
      borderColor: '#ff1744',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#d32f2f" stroke="#b71c1c" stroke-width="4"/>
          <!-- Chamas ao fundo -->
          <path d="M30 30 Q35 15 42 28 Q48 10 55 24 Q62 12 70 30" fill="none" stroke="#ffeb3b" stroke-width="3" stroke-linecap="round"/>
          <!-- Olhos de fúria -->
          <line x1="26" y1="38" x2="42" y2="48" stroke="#ffffff" stroke-width="5" stroke-linecap="round"/>
          <line x1="74" y1="38" x2="58" y2="48" stroke="#ffffff" stroke-width="5" stroke-linecap="round"/>
          <circle cx="35" cy="49" r="4" fill="#ffffff"/>
          <circle cx="65" cy="49" r="4" fill="#ffffff"/>
          <!-- Boca furiosa / dentes cerrados -->
          <rect x="32" y="64" width="36" height="14" rx="4" fill="#ffffff" stroke="#212121" stroke-width="2"/>
          <line x1="41" y1="64" x2="41" y2="78" stroke="#212121" stroke-width="2"/>
          <line x1="50" y1="64" x2="50" y2="78" stroke="#212121" stroke-width="2"/>
          <line x1="59" y1="64" x2="59" y2="78" stroke="#212121" stroke-width="2"/>
          <line x1="32" y1="71" x2="68" y2="71" stroke="#212121" stroke-width="2"/>
        </svg>
      `,
      verdict: 'O sangue ferveu! O resultado é puro ÓDIO e treta garantida! 🤬🔥'
    }
  },

  // CLÁSSICA CARA OU COROA
  {
    id: 'classica-ouro',
    category: 'classica',
    name: 'Cara ou Coroa Tradicional',
    subtitle: 'A moeda clássica de ouro imperador',
    sideA: {
      name: 'Cara',
      badge: 'CARA',
      gradient: 'radial-gradient(circle at 35% 35%, #fff2a1 0%, #ffd700 50%, #b8860b 85%, #7a5802 100%)',
      borderColor: '#d4af37',
      textColor: '#3e2723',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <!-- Efígie de perfil / busto clássico -->
          <circle cx="50" cy="50" r="42" fill="none" stroke="#b8860b" stroke-width="3" stroke-dasharray="3,3"/>
          <path d="M48 24 Q56 24 60 30 Q63 36 60 42 Q58 45 62 48 Q64 50 60 53 Q56 55 58 59 Q62 65 67 72 L38 72 Q38 60 42 50 Q43 45 42 40 Q40 32 48 24 Z" fill="#b8860b"/>
          <circle cx="48" cy="38" r="2.5" fill="#3e2723"/>
          <path d="M42 30 Q46 26 52 28" fill="none" stroke="#7a5802" stroke-width="2"/>
        </svg>
      `,
      verdict: 'Deu CARA! O destino clássico foi selado a seu favor. 👑'
    },
    sideB: {
      name: 'Coroa',
      badge: 'COROA',
      gradient: 'radial-gradient(circle at 35% 35%, #fff5ba 0%, #ffca28 50%, #c47c00 85%, #8c5300 100%)',
      borderColor: '#ffb300',
      textColor: '#3e2723',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="42" fill="none" stroke="#c47c00" stroke-width="3" stroke-dasharray="3,3"/>
          <!-- Coroa majestosa -->
          <path d="M25 65 L28 40 L40 52 L50 32 L60 52 L72 40 L75 65 Z" fill="#c47c00" stroke="#7a5802" stroke-width="2"/>
          <circle cx="28" cy="38" r="3.5" fill="#e65100"/>
          <circle cx="50" cy="30" r="4" fill="#d50000"/>
          <circle cx="72" cy="38" r="3.5" fill="#e65100"/>
          <rect x="25" y="65" width="50" height="7" rx="2" fill="#7a5802"/>
        </svg>
      `,
      verdict: 'Deu COROA! A realeza e o poder venceram essa rodada! 💎'
    }
  },

  // TIMES DE FUTEBOL - CLÁSSICOS BRASILEIROS E MUNDIAIS
  {
    id: 'flamengo-vasco',
    category: 'futebol',
    name: 'Flamengo vs Vasco',
    subtitle: 'O Clássico dos Milhões',
    sideA: {
      name: 'Flamengo',
      badge: 'MENGÃO',
      gradient: 'radial-gradient(circle at 35% 35%, #e53935 0%, #c62828 55%, #1b1b1b 95%)',
      borderColor: '#d32f2f',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#1b1b1b" stroke="#c62828" stroke-width="4"/>
          <!-- Listras horizontais rubro-negras -->
          <clipPath id="circle-clip-fla">
            <circle cx="50" cy="50" r="42"/>
          </clipPath>
          <g clip-path="url(#circle-clip-fla)">
            <rect x="0" y="10" width="100" height="20" fill="#c62828"/>
            <rect x="0" y="30" width="100" height="20" fill="#111111"/>
            <rect x="0" y="50" width="100" height="20" fill="#c62828"/>
            <rect x="0" y="70" width="100" height="20" fill="#111111"/>
          </g>
          <!-- Letras CRF Estilizadas -->
          <circle cx="50" cy="50" r="24" fill="rgba(0,0,0,0.65)" stroke="#fff" stroke-width="2"/>
          <text x="50" y="56" fill="#fff" font-size="16" font-weight="900" text-anchor="middle" font-family="Arial Black, sans-serif">CRF</text>
        </svg>
      `,
      verdict: 'Uma vez Flamengo, sempre Flamengo! Vitória rubro-negra! 🔴⚫'
    },
    sideB: {
      name: 'Vasco',
      badge: 'GIGANTE',
      gradient: 'radial-gradient(circle at 35% 35%, #424242 0%, #1c1c1c 65%, #000000 100%)',
      borderColor: '#e0e0e0',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#111111" stroke="#ffffff" stroke-width="3"/>
          <!-- Faixa Diagonal Branca -->
          <clipPath id="circle-clip-vas">
            <circle cx="50" cy="50" r="42"/>
          </clipPath>
          <g clip-path="url(#circle-clip-vas)">
            <polygon points="10,95 85,10 100,10 15,100" fill="#ffffff"/>
          </g>
          <!-- Cruz de Malta Vermelha -->
          <path d="M50 32 L56 44 L68 50 L56 56 L50 68 L44 56 L32 50 L44 44 Z" fill="#d50000" stroke="#b71c1c" stroke-width="1.5"/>
          <circle cx="50" cy="50" r="3" fill="#ffffff"/>
        </svg>
      `,
      verdict: 'O Gigante da Colina triunfou! A Cruz de Malta reina soberana! ⚪⚫'
    }
  },

  {
    id: 'corinthians-palmeiras',
    category: 'futebol',
    name: 'Corinthians vs Palmeiras',
    subtitle: 'O Derby Paulista Centenário',
    sideA: {
      name: 'Corinthians',
      badge: 'TIMÃO',
      gradient: 'radial-gradient(circle at 35% 35%, #ffffff 0%, #eeeeee 50%, #212121 95%)',
      borderColor: '#ffffff',
      textColor: '#111111',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#ffffff" stroke="#111" stroke-width="4"/>
          <!-- Remos e Âncora -->
          <path d="M30 30 L70 70 M70 30 L30 70" stroke="#d50000" stroke-width="4" stroke-linecap="round"/>
          <path d="M50 25 L50 75 M38 65 Q50 78 62 65" fill="none" stroke="#d50000" stroke-width="4" stroke-linecap="round"/>
          <!-- Escudo Central -->
          <circle cx="50" cy="50" r="22" fill="#111111" stroke="#fff" stroke-width="2"/>
          <text x="50" y="55" fill="#fff" font-size="13" font-weight="900" text-anchor="middle" font-family="Arial Black">SCCP</text>
        </svg>
      `,
      verdict: 'Vai Corinthians! O Bando de Loucos comemora a vitória! 🏴🏳️'
    },
    sideB: {
      name: 'Palmeiras',
      badge: 'VERDÃO',
      gradient: 'radial-gradient(circle at 35% 35%, #2e7d32 0%, #1b5e20 60%, #003300 100%)',
      borderColor: '#4caf50',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#1b5e20" stroke="#ffffff" stroke-width="4"/>
          <!-- Escudo Palmeiras P com Estrelas -->
          <circle cx="50" cy="50" r="32" fill="#ffffff"/>
          <circle cx="50" cy="50" r="28" fill="#1b5e20"/>
          <text x="50" y="62" fill="#ffffff" font-size="34" font-weight="900" text-anchor="middle" font-family="Arial Black">P</text>
          <!-- Estrela dourada no topo -->
          <polygon points="50,14 53,22 62,22 55,27 58,35 50,30 42,35 45,27 38,22 47,22" fill="#ffd700"/>
        </svg>
      `,
      verdict: 'Palmeiras venceu! O Maior Campeão do Brasil leva essa! 🟢⚪'
    }
  },

  {
    id: 'real-madrid-barcelona',
    category: 'futebol',
    name: 'Real Madrid vs Barcelona',
    subtitle: 'El Clásico Mundial',
    sideA: {
      name: 'Real Madrid',
      badge: 'MADRID',
      gradient: 'radial-gradient(circle at 35% 35%, #ffffff 0%, #f5f5f5 55%, #cfd8dc 100%)',
      borderColor: '#ffd700',
      textColor: '#1a237e',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#ffffff" stroke="#ffd700" stroke-width="4"/>
          <!-- Coroa Real -->
          <path d="M35 34 L40 24 L50 30 L60 24 L65 34 Z" fill="#ffd700" stroke="#ff8f00" stroke-width="1.5"/>
          <!-- Faixa Lilás -->
          <line x1="26" y1="36" x2="74" y2="68" stroke="#5c6bc0" stroke-width="7"/>
          <circle cx="50" cy="52" r="22" fill="none" stroke="#ffd700" stroke-width="3"/>
          <text x="50" y="58" fill="#1a237e" font-size="15" font-weight="900" text-anchor="middle">RMCF</text>
        </svg>
      `,
      verdict: '¡Hala Madrid y nada más! Vitória merengue incontestável! ⚪👑'
    },
    sideB: {
      name: 'Barcelona',
      badge: 'BARÇA',
      gradient: 'radial-gradient(circle at 35% 35%, #004d98 0%, #a50044 60%, #1a0010 100%)',
      borderColor: '#edbb00',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#004d98" stroke="#edbb00" stroke-width="4"/>
          <!-- Escudo Blaugrana dividido -->
          <clipPath id="circle-barca">
            <circle cx="50" cy="50" r="40"/>
          </clipPath>
          <g clip-path="url(#circle-barca)">
            <rect x="10" y="10" width="40" height="40" fill="#ffffff"/>
            <line x1="30" y1="10" x2="30" y2="50" stroke="#a50044" stroke-width="8"/>
            <line x1="10" y1="30" x2="50" y2="30" stroke="#a50044" stroke-width="8"/>
            <rect x="50" y="10" width="40" height="40" fill="#ffd700"/>
            <line x1="60" y1="10" x2="60" y2="50" stroke="#d50000" stroke-width="4"/>
            <line x1="75" y1="10" x2="75" y2="50" stroke="#d50000" stroke-width="4"/>
            <!-- Faixas inferiores Blaugrana -->
            <rect x="10" y="50" width="80" height="40" fill="#004d98"/>
            <rect x="25" y="50" width="16" height="40" fill="#a50044"/>
            <rect x="58" y="50" width="16" height="40" fill="#a50044"/>
          </g>
        </svg>
      `,
      verdict: '¡Visca el Barça! O espetáculo blaugrana garantiu a vitória! 🔵🔴'
    }
  },

  // JOGOS / GAMES
  {
    id: 'minecraft-roblox',
    category: 'jogos',
    name: 'Minecraft vs Roblox',
    subtitle: 'A Batalha dos Mundos de Blocos',
    sideA: {
      name: 'Minecraft',
      badge: 'CRAFT',
      gradient: 'radial-gradient(circle at 35% 35%, #4caf50 0%, #2e7d32 60%, #1b5e20 100%)',
      borderColor: '#81c784',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#388e3c" stroke="#2e7d32" stroke-width="4"/>
          <!-- Rosto Pixelado do Creeper -->
          <rect x="24" y="24" width="52" height="52" fill="#4caf50" stroke="#1b5e20" stroke-width="2"/>
          <!-- Olhos -->
          <rect x="32" y="36" width="12" height="12" fill="#1b1b1b"/>
          <rect x="56" y="36" width="12" height="12" fill="#1b1b1b"/>
          <!-- Nariz e Boca -->
          <rect x="44" y="48" width="12" height="16" fill="#1b1b1b"/>
          <rect x="38" y="56" width="6" height="18" fill="#1b1b1b"/>
          <rect x="56" y="56" width="6" height="18" fill="#1b1b1b"/>
        </svg>
      `,
      verdict: 'Sss... BOOM! Minecraft construiu a vitória bloco a bloco! 🟩⛏️'
    },
    sideB: {
      name: 'Roblox',
      badge: 'BLOX',
      gradient: 'radial-gradient(circle at 35% 35%, #e0e0e0 0%, #424242 60%, #1e1e1e 100%)',
      borderColor: '#e53935',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#212121" stroke="#e53935" stroke-width="4"/>
          <!-- Bloco Inclinado de Roblox -->
          <g transform="rotate(-15 50 50)">
            <rect x="28" y="28" width="44" height="44" rx="6" fill="#e53935" stroke="#ffffff" stroke-width="3"/>
            <rect x="42" y="42" width="16" height="16" fill="#212121"/>
          </g>
        </svg>
      `,
      verdict: 'Oof! Roblox conquistou o servidor com sucesso! 🟥'
    }
  },

  {
    id: 'mario-sonic',
    category: 'jogos',
    name: 'Mario vs Sonic',
    subtitle: 'O Maior Duelo da História dos Videogames',
    sideA: {
      name: 'Mario',
      badge: 'MARIO',
      gradient: 'radial-gradient(circle at 35% 35%, #ff5252 0%, #d50000 65%, #8b0000 100%)',
      borderColor: '#ffd700',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#d50000" stroke="#ffd700" stroke-width="4"/>
          <!-- Boné do M -->
          <circle cx="50" cy="50" r="28" fill="#ffffff"/>
          <text x="50" y="60" fill="#d50000" font-size="34" font-weight="900" text-anchor="middle" font-family="Arial Black">M</text>
        </svg>
      `,
      verdict: 'It\'s-a me, Mario! Vitória com direito a Super Cogumelo! 🍄🌟'
    },
    sideB: {
      name: 'Sonic',
      badge: 'SONIC',
      gradient: 'radial-gradient(circle at 35% 35%, #42a5f5 0%, #1565c0 65%, #0d47a1 100%)',
      borderColor: '#ffd700',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#1565c0" stroke="#ffd700" stroke-width="4"/>
          <!-- Anel de Ouro do Sonic -->
          <circle cx="50" cy="50" r="28" fill="none" stroke="#ffd700" stroke-width="9"/>
          <circle cx="50" cy="50" r="28" fill="none" stroke="#fff9c4" stroke-width="2"/>
          <text x="50" y="58" fill="#ffffff" font-size="20" font-weight="900" text-anchor="middle" font-family="Arial Black">S</text>
        </svg>
      `,
      verdict: 'Gotta go fast! O Ouriço Azul passou voando e venceu! 🦔💍'
    }
  },

  {
    id: 'playstation-xbox',
    category: 'jogos',
    name: 'PlayStation vs Xbox',
    subtitle: 'A Guerra dos Consoles',
    sideA: {
      name: 'PlayStation',
      badge: 'SONY',
      gradient: 'radial-gradient(circle at 35% 35%, #2979ff 0%, #003791 70%, #001e52 100%)',
      borderColor: '#00d2ff',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#003791" stroke="#00d2ff" stroke-width="4"/>
          <!-- Símbolos PlayStation: Triângulo, Círculo, X, Quadrado -->
          <polygon points="50,22 42,36 58,36" fill="none" stroke="#00e676" stroke-width="3"/>
          <circle cx="72" cy="50" r="8" fill="none" stroke="#ff1744" stroke-width="3"/>
          <line x1="44" y1="64" x2="56" y2="76" stroke="#2979ff" stroke-width="3"/>
          <line x1="56" y1="64" x2="44" y2="76" stroke="#2979ff" stroke-width="3"/>
          <rect x="20" y="42" width="16" height="16" fill="none" stroke="#ff80ab" stroke-width="3"/>
        </svg>
      `,
      verdict: 'Play Has No Limits! Vitória do PlayStation! 🎮🟦'
    },
    sideB: {
      name: 'Xbox',
      badge: 'XBOX',
      gradient: 'radial-gradient(circle at 35% 35%, #4caf50 0%, #107c10 65%, #053b05 100%)',
      borderColor: '#76ff03',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#107c10" stroke="#76ff03" stroke-width="4"/>
          <!-- Logo Esfera Xbox X -->
          <circle cx="50" cy="50" r="30" fill="#000000"/>
          <path d="M30 30 Q50 48 70 30 Q54 50 70 70 Q50 52 30 70 Q46 50 30 30 Z" fill="#76ff03"/>
        </svg>
      `,
      verdict: 'Power Your Dreams! Vitória consagrada do Xbox! 🟢🔋'
    }
  },

  // SUPER-HERÓIS
  {
    id: 'batman-coringa',
    category: 'herois',
    name: 'Batman vs Coringa',
    subtitle: 'A Lenda de Gotham City',
    sideA: {
      name: 'Batman',
      badge: 'BATMAN',
      gradient: 'radial-gradient(circle at 35% 35%, #424242 0%, #1a1a1a 65%, #000000 100%)',
      borderColor: '#ffd700',
      textColor: '#ffd700',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#111111" stroke="#ffd700" stroke-width="4"/>
          <!-- Bat-Sinal Oval Amarelo -->
          <ellipse cx="50" cy="50" rx="34" ry="22" fill="#ffd700"/>
          <!-- Morcego Negro -->
          <path d="M50 36 C48 40 45 42 41 42 C35 38 28 42 24 48 C28 56 36 58 42 54 C46 56 48 64 50 64 C52 64 54 56 58 54 C64 58 72 56 76 48 C72 42 65 38 59 42 C55 42 52 40 50 36 Z" fill="#111111"/>
        </svg>
      `,
      verdict: 'I am Batman! A justiça prevaleceu na noite escura! 🦇🖤'
    },
    sideB: {
      name: 'Coringa',
      badge: 'JOKER',
      gradient: 'radial-gradient(circle at 35% 35%, #ab47bc 0%, #6a1b9a 65%, #38006b 100%)',
      borderColor: '#76ff03',
      textColor: '#76ff03',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#4a148c" stroke="#76ff03" stroke-width="4"/>
          <!-- Sorriso Macabro HAHAHA -->
          <path d="M22 45 Q50 78 78 45" fill="none" stroke="#d50000" stroke-width="8" stroke-linecap="round"/>
          <path d="M28 50 Q50 68 72 50" fill="none" stroke="#ffffff" stroke-width="4" stroke-dasharray="6,3"/>
          <!-- Cabelo Verde e HAHA -->
          <text x="50" y="36" fill="#76ff03" font-size="16" font-weight="900" text-anchor="middle" font-family="Impact">HA HA HA!</text>
        </svg>
      `,
      verdict: 'Why so serious? O caos do Coringa tomou conta de tudo! 🃏💜'
    }
  },

  {
    id: 'homem-aranha-venom',
    category: 'herois',
    name: 'Homem-Aranha vs Venom',
    subtitle: 'O Herói Amigão vs O Simbionte Letal',
    sideA: {
      name: 'Homem-Aranha',
      badge: 'SPIDER',
      gradient: 'radial-gradient(circle at 35% 35%, #ff5252 0%, #c62828 65%, #8e0000 100%)',
      borderColor: '#0288d1',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#c62828" stroke="#0288d1" stroke-width="4"/>
          <!-- Teias -->
          <circle cx="50" cy="50" r="22" fill="none" stroke="#111" stroke-width="1.5"/>
          <line x1="10" y1="50" x2="90" y2="50" stroke="#111" stroke-width="1.5"/>
          <line x1="50" y1="10" x2="50" y2="90" stroke="#111" stroke-width="1.5"/>
          <!-- Olhos Grandes Brancos com Borda Negra -->
          <path d="M26 38 Q38 34 46 48 Q36 58 24 50 Z" fill="#ffffff" stroke="#111" stroke-width="3"/>
          <path d="M74 38 Q62 34 54 48 Q64 58 76 50 Z" fill="#ffffff" stroke="#111" stroke-width="3"/>
        </svg>
      `,
      verdict: 'O Amigão da Vizinhança salvou o dia com estilo! 🕷️🕸️'
    },
    sideB: {
      name: 'Venom',
      badge: 'VENOM',
      gradient: 'radial-gradient(circle at 35% 35%, #263238 0%, #101518 70%, #000000 100%)',
      borderColor: '#ffffff',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#000000" stroke="#ffffff" stroke-width="4"/>
          <!-- Olhos Pontiagudos Simbiontes -->
          <path d="M24 32 Q38 34 44 48 Q32 50 22 40 Z" fill="#ffffff"/>
          <path d="M76 32 Q62 34 56 48 Q68 50 78 40 Z" fill="#ffffff"/>
          <!-- Dentes Afiados -->
          <path d="M28 62 L32 56 L36 62 L40 56 L44 62 L48 56 L52 62 L56 56 L60 62 L64 56 L68 62 L72 56" fill="none" stroke="#ffffff" stroke-width="2.5"/>
        </svg>
      `,
      verdict: 'Nós somos Venom! O poder supremo do simbionte dominou! 🖤👅'
    }
  },

  // PAÍSES
  {
    id: 'brasil-argentina',
    category: 'paises',
    name: 'Brasil vs Argentina',
    subtitle: 'A Maior Rivalidade das Américas',
    sideA: {
      name: 'Brasil',
      badge: 'BRASIL',
      gradient: 'radial-gradient(circle at 35% 35%, #ffd54f 0%, #fbc02d 60%, #f57f17 100%)',
      borderColor: '#2e7d32',
      textColor: '#1b5e20',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#2e7d32" stroke="#ffd600" stroke-width="4"/>
          <!-- Losango Amarelo -->
          <polygon points="50,18 84,50 50,82 16,50" fill="#ffd600"/>
          <!-- Círculo Azul Celeste com Faixa Branca -->
          <circle cx="50" cy="50" r="18" fill="#0d47a1"/>
          <path d="M33 53 Q50 44 67 49" fill="none" stroke="#ffffff" stroke-width="3"/>
          <!-- Estrelas do Cruzeiro -->
          <circle cx="50" cy="56" r="1.5" fill="#ffffff"/>
          <circle cx="46" cy="52" r="1.5" fill="#ffffff"/>
          <circle cx="54" cy="52" r="1.5" fill="#ffffff"/>
        </svg>
      `,
      verdict: 'É o Brasil! O país do futebol e da alegria levou a melhor! 🇧🇷⚽'
    },
    sideB: {
      name: 'Argentina',
      badge: 'ARGENTINA',
      gradient: 'radial-gradient(circle at 35% 35%, #e1f5fe 0%, #81d4fa 60%, #0288d1 100%)',
      borderColor: '#ffd54f',
      textColor: '#01579b',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#ffffff" stroke="#0288d1" stroke-width="4"/>
          <!-- Faixas Albiceleste -->
          <clipPath id="circle-arg">
            <circle cx="50" cy="50" r="40"/>
          </clipPath>
          <g clip-path="url(#circle-arg)">
            <rect x="0" y="0" width="100" height="33" fill="#81d4fa"/>
            <rect x="0" y="33" width="100" height="34" fill="#ffffff"/>
            <rect x="0" y="67" width="100" height="33" fill="#81d4fa"/>
          </g>
          <!-- Sol de Mayo Dourado -->
          <circle cx="50" cy="50" r="12" fill="#ffd54f" stroke="#f57f17" stroke-width="1.5"/>
          <circle cx="47" cy="48" r="1.5" fill="#e65100"/>
          <circle cx="53" cy="48" r="1.5" fill="#e65100"/>
          <path d="M47 54 Q50 56 53 54" fill="none" stroke="#e65100" stroke-width="1.5"/>
        </svg>
      `,
      verdict: '¡Muchachos! Vitória albiceleste consagrada com glória! 🇦🇷🏆'
    }
  },

  {
    id: 'japao-eua',
    category: 'paises',
    name: 'Japão vs Estados Unidos',
    subtitle: 'Tradição Oriental vs Potência Ocidental',
    sideA: {
      name: 'Japão',
      badge: 'JAPÃO',
      gradient: 'radial-gradient(circle at 35% 35%, #ffffff 0%, #f5f5f5 70%, #e0e0e0 100%)',
      borderColor: '#d50000',
      textColor: '#b71c1c',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#ffffff" stroke="#d50000" stroke-width="4"/>
          <!-- Sol Nascente Carmesim -->
          <circle cx="50" cy="50" r="24" fill="#d50000"/>
          <text x="50" y="56" fill="#ffffff" font-size="14" font-weight="900" text-anchor="middle">日本</text>
        </svg>
      `,
      verdict: 'Nippon! O espírito samurai e a precisão japonesa venceram! 🇯🇵⛩️'
    },
    sideB: {
      name: 'EUA',
      badge: 'EUA',
      gradient: 'radial-gradient(circle at 35% 35%, #1565c0 0%, #0d47a1 65%, #002171 100%)',
      borderColor: '#d50000',
      textColor: '#ffffff',
      icon: `
        <svg viewBox="0 0 100 100" width="80" height="80">
          <circle cx="50" cy="50" r="44" fill="#0d47a1" stroke="#d50000" stroke-width="4"/>
          <!-- Estrelas e Listras -->
          <polygon points="50,22 53,30 62,30 55,36 58,44 50,39 42,44 45,36 38,30 47,30" fill="#ffffff"/>
          <circle cx="32" cy="54" r="3.5" fill="#ffffff"/>
          <circle cx="68" cy="54" r="3.5" fill="#ffffff"/>
          <!-- Listras inferiores -->
          <rect x="25" y="66" width="50" height="5" fill="#d50000"/>
          <rect x="25" y="73" width="50" height="5" fill="#ffffff"/>
        </svg>
      `,
      verdict: 'Land of the Free! Os Estados Unidos levaram a melhor! 🇺🇸🦅'
    }
  }
];

// ==========================================================================
// SISTEMA DE ÁUDIO SINTETIZADO (Web Audio API)
// Não requer arquivos mp3 externos, toca instantaneamente e sem latência
// ==========================================================================
class SoundSystem {
  constructor() {
    this.ctx = null;
    this.isMuted = localStorage.getItem('resenha_muted') === 'true';
  }

  init() {
    if (!this.ctx) {
      const AudioCtx = window.AudioContext || window.webkitAudioContext;
      if (AudioCtx) {
        this.ctx = new AudioCtx();
      }
    }
    if (this.ctx && this.ctx.state === 'suspended') {
      this.ctx.resume();
    }
  }

  toggleMute() {
    this.isMuted = !this.isMuted;
    localStorage.setItem('resenha_muted', this.isMuted);
    return this.isMuted;
  }

  // Som de moeda girando / subindo no ar (tilintar metálico)
  playCoinToss() {
    if (this.isMuted) return;
    this.init();
    if (!this.ctx) return;

    const now = this.ctx.currentTime;
    
    // Oscilador 1: Som metálico fino
    const osc1 = this.ctx.createOscillator();
    const gain1 = this.ctx.createGain();
    osc1.type = 'sine';
    osc1.frequency.setValueAtTime(1400, now);
    osc1.frequency.exponentialRampToValueAtTime(700, now + 0.35);

    gain1.gain.setValueAtTime(0.28, now);
    gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.35);

    osc1.connect(gain1);
    gain1.connect(this.ctx.destination);
    osc1.start(now);
    osc1.stop(now + 0.35);

    // Oscilador 2: Ressonância dourada
    const osc2 = this.ctx.createOscillator();
    const gain2 = this.ctx.createGain();
    osc2.type = 'triangle';
    osc2.frequency.setValueAtTime(2200, now);
    osc2.frequency.exponentialRampToValueAtTime(1100, now + 0.25);

    gain2.gain.setValueAtTime(0.18, now);
    gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.25);

    osc2.connect(gain2);
    gain2.connect(this.ctx.destination);
    osc2.start(now);
    osc2.stop(now + 0.25);
  }

  // Beep de contagem regressiva (3, 2, 1)
  playCountdownBeep(number) {
    if (this.isMuted) return;
    this.init();
    if (!this.ctx) return;

    const now = this.ctx.currentTime;
    const osc = this.ctx.createOscillator();
    const gain = this.ctx.createGain();

    osc.type = 'sine';
    // Frequência sobe conforme se aproxima do 0: 3 -> 440Hz, 2 -> 554Hz, 1 -> 659Hz
    const freqs = { 3: 480, 2: 580, 1: 720 };
    const freq = freqs[number] || 500;

    osc.frequency.setValueAtTime(freq, now);
    gain.gain.setValueAtTime(0.25, now);
    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.22);

    osc.connect(gain);
    gain.connect(this.ctx.destination);
    osc.start(now);
    osc.stop(now + 0.22);
  }

  // Beep final quando a moeda para
  playLandImpact() {
    if (this.isMuted) return;
    this.init();
    if (!this.ctx) return;

    const now = this.ctx.currentTime;
    
    // Impacto grave
    const osc = this.ctx.createOscillator();
    const gain = this.ctx.createGain();
    osc.type = 'triangle';
    osc.frequency.setValueAtTime(180, now);
    osc.frequency.exponentialRampToValueAtTime(45, now + 0.28);
    gain.gain.setValueAtTime(0.4, now);
    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.28);

    osc.connect(gain);
    gain.connect(this.ctx.destination);
    osc.start(now);
    osc.stop(now + 0.28);
  }

  // Fanfarra triunfal quando o resultado é revelado!
  playFanfare() {
    if (this.isMuted) return;
    this.init();
    if (!this.ctx) return;

    const notes = [523.25, 659.25, 783.99, 1046.50]; // Acorde Maior C5, E5, G5, C6
    const now = this.ctx.currentTime;

    notes.forEach((note, idx) => {
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      const noteTime = now + (idx * 0.08);

      osc.type = 'sine';
      osc.frequency.setValueAtTime(note, noteTime);

      gain.gain.setValueAtTime(0, noteTime);
      gain.gain.linearRampToValueAtTime(0.22, noteTime + 0.02);
      gain.gain.exponentialRampToValueAtTime(0.001, noteTime + 0.55);

      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start(noteTime);
      osc.stop(noteTime + 0.55);
    });
  }
}

// ==========================================================================
// SISTEMA DE CONFETES (Canvas 2D Puro)
// ==========================================================================
class ConfettiCannon {
  constructor(canvasId) {
    this.canvas = document.getElementById(canvasId);
    this.ctx = (this.canvas && typeof this.canvas.getContext === 'function') ? this.canvas.getContext('2d') : null;
    this.particles = [];
    this.animId = null;

    if (this.ctx) {
      this.resize();
      window.addEventListener('resize', () => this.resize());
    }
  }

  resize() {
    if (!this.canvas) return;
    this.canvas.width = window.innerWidth;
    this.canvas.height = window.innerHeight;
  }

  blast() {
    if (!this.ctx) return;
    this.resize();

    const colors = ['#ff3d00', '#ff9100', '#ffd700', '#ff1744', '#ffffff', '#ffab00', '#ff6d00'];
    const particleCount = 120;

    for (let i = 0; i < particleCount; i++) {
      this.particles.push({
        x: window.innerWidth * 0.5 + (Math.random() * 80 - 40),
        y: window.innerHeight * 0.45,
        vx: (Math.random() - 0.5) * 16,
        vy: -Math.random() * 14 - 6,
        size: Math.random() * 8 + 5,
        color: colors[Math.floor(Math.random() * colors.length)],
        rotation: Math.random() * 360,
        vRot: (Math.random() - 0.5) * 10,
        gravity: 0.45,
        drag: 0.96,
        opacity: 1
      });
    }

    if (!this.animId) {
      this.render();
    }
  }

  render() {
    if (!this.ctx) return;
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

    for (let i = this.particles.length - 1; i >= 0; i--) {
      const p = this.particles[i];
      p.x += p.vx;
      p.y += p.vy;
      p.vy += p.gravity;
      p.vx *= p.drag;
      p.rotation += p.vRot;
      p.opacity -= 0.009;

      if (p.opacity <= 0 || p.y > this.canvas.height) {
        this.particles.splice(i, 1);
        continue;
      }

      this.ctx.save();
      this.ctx.translate(p.x, p.y);
      this.ctx.rotate((p.rotation * Math.PI) / 180);
      this.ctx.globalAlpha = Math.max(0, p.opacity);
      this.ctx.fillStyle = p.color;
      this.ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.6);
      this.ctx.restore();
    }

    if (this.particles.length > 0) {
      this.animId = requestAnimationFrame(() => this.render());
    } else {
      this.animId = null;
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
  }
}

// ==========================================================================
// GERENCIADOR PRINCIPAL DO APLICATIVO
// ==========================================================================
class ResenhaApp {
  constructor() {
    this.sounds = new SoundSystem();
    this.confetti = new ConfettiCannon('confetti-canvas');

    // Estado da Aplicação
    this.currentScreen = 'home';
    this.selectedCoin = COINS_DATABASE[0]; // Padrão: Resenha ou Ódio
    this.currentCategory = 'todas';
    this.isSpinning = false;
    this.countdownTimer = null;
    this.currentRotationY = 0;

    // Placar da Sessão
    this.sessionScore = {
      sideA: 0,
      sideB: 0
    };

    // Elementos DOM
    this.dom = {
      // Telas
      screenHome: document.getElementById('screen-home'),
      screenSelection: document.getElementById('screen-selection'),
      screenGame: document.getElementById('screen-game'),

      // Botões de Navegação
      btnGoToSelection: document.getElementById('btn-play-hero'),
      btnMuteAudio: document.getElementById('btn-sound-toggle'),
      btnOpenCustomModal: document.getElementById('btn-open-custom-modal'),
      btnCloseCustomModal: document.getElementById('btn-close-custom-modal'),
      customModalBackdrop: document.getElementById('modal-custom-coin'),
      customCoinForm: document.getElementById('custom-coin-form'),

      // Galeria e Filtros
      coinsGrid: document.getElementById('coins-grid'),
      filterButtons: document.querySelectorAll('.btn-filter'),
      searchInput: document.getElementById('coin-search-input'),

      // Palco do Jogo / Resultado
      gameCoinStage: document.getElementById('game-coin-stage'),
      gameCoinElement: document.getElementById('game-coin-3d'),
      gameFaceFront: document.getElementById('game-face-front'),
      gameFaceBack: document.getElementById('game-face-back'),
      countdownOverlay: document.getElementById('countdown-overlay'),
      countdownNumber: document.getElementById('countdown-number'),
      currentMatchName: document.getElementById('current-match-name'),
      currentMatchCategory: document.getElementById('current-match-category'),

      // Resultado
      resultContainer: document.getElementById('result-display-container'),
      resultWinnerTitle: document.getElementById('result-winner-title'),
      resultVerdictQuote: document.getElementById('result-verdict-quote'),
      btnPlayAgain: document.getElementById('btn-play-again'),
      btnChangeCoin: document.getElementById('btn-change-coin'),
      btnBackHome: document.getElementById('btn-back-home'),

      // Placar
      scoreLabelA: document.getElementById('score-label-a'),
      scoreValueA: document.getElementById('score-value-a'),
      scoreLabelB: document.getElementById('score-label-b'),
      scoreValueB: document.getElementById('score-value-b')
    };

    this.init();
  }

  init() {
    this.bindEvents();
    this.updateSoundIcon();
    this.renderCoinsGrid();
    this.setupHomeCoinInteractivePreview();
    
    // Tratamento de URL hash caso o usuário recarregue a página
    window.addEventListener('popstate', () => this.handleRouting());
    this.handleRouting();
  }

  // Navegação entre Telas
  navigateTo(screenName) {
    this.currentScreen = screenName;
    window.location.hash = screenName;

    // Remove classe ativa de todas
    [this.dom.screenHome, this.dom.screenSelection, this.dom.screenGame].forEach(screen => {
      if (screen) screen.classList.remove('active');
    });

    if (screenName === 'home') {
      this.dom.screenHome.classList.add('active');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    } else if (screenName === 'selecao') {
      this.dom.screenSelection.classList.add('active');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    } else if (screenName === 'jogo') {
      this.dom.screenGame.classList.add('active');
      window.scrollTo({ top: 0, behavior: 'smooth' });
      // Inicia a rodada automaticamente
      this.startCoinTossRound();
    }
  }

  handleRouting() {
    const hash = window.location.hash.replace('#', '');
    if (hash === 'selecao') {
      this.navigateTo('selecao');
    } else if (hash === 'jogo') {
      this.navigateTo('jogo');
    } else {
      this.navigateTo('home');
    }
  }

  // Interatividade na Moeda da Tela Inicial (clicar nela dá um giro rápido com som)
  setupHomeCoinInteractivePreview() {
    const homeCoin = document.getElementById('home-coin-3d');
    if (homeCoin) {
      homeCoin.addEventListener('click', () => {
        this.sounds.playCoinToss();
        homeCoin.style.transition = 'transform 0.8s cubic-bezier(0.18, 0.89, 0.32, 1.28)';
        homeCoin.style.transform = `rotateY(${Math.random() > 0.5 ? 720 : 900}deg)`;
        setTimeout(() => {
          homeCoin.style.transition = '';
          homeCoin.style.transform = '';
        }, 1200);
      });
    }
  }

  // Renderização da Galeria de Moedas
  renderCoinsGrid() {
    if (!this.dom.coinsGrid) return;
    const filter = this.currentCategory;
    const search = (this.dom.searchInput ? this.dom.searchInput.value : '').toLowerCase().trim();

    const filtered = COINS_DATABASE.filter(coin => {
      const matchCat = filter === 'todas' || coin.category === filter;
      const matchSearch = coin.name.toLowerCase().includes(search) || 
                          coin.subtitle.toLowerCase().includes(search) ||
                          coin.sideA.name.toLowerCase().includes(search) ||
                          coin.sideB.name.toLowerCase().includes(search);
      return matchCat && matchSearch;
    });

    if (filtered.length === 0) {
      this.dom.coinsGrid.innerHTML = `
        <div style="grid-column: 1 / -1; padding: 3rem; text-align: center; color: #ffab91;">
          <p style="font-size: 1.4rem; margin-bottom: 0.5rem;">🔍 Nenhuma moeda encontrada</p>
          <p style="font-size: 0.95rem; opacity: 0.8;">Tente buscar por outro termo ou escolha outra categoria acima.</p>
        </div>
      `;
      return;
    }

    this.dom.coinsGrid.innerHTML = filtered.map(coin => {
      return `
        <div class="coin-card" data-coin-id="${coin.id}">
          <span class="card-category-badge">${this.getCategoryLabel(coin.category)}</span>
          <h3 class="card-title">${coin.name}</h3>
          <p class="card-subtitle">${coin.subtitle}</p>

          <div class="card-preview-area">
            <!-- Face A -->
            <div class="preview-face-container">
              <div class="mini-face" style="background: ${coin.sideA.gradient}; border-color: ${coin.sideA.borderColor}">
                ${coin.sideA.icon}
              </div>
              <span class="preview-face-name" style="color: ${coin.sideA.borderColor}">${coin.sideA.name}</span>
            </div>

            <span class="preview-vs-divider">VS</span>

            <!-- Face B -->
            <div class="preview-face-container">
              <div class="mini-face" style="background: ${coin.sideB.gradient}; border-color: ${coin.sideB.borderColor}">
                ${coin.sideB.icon}
              </div>
              <span class="preview-face-name" style="color: ${coin.sideB.borderColor}">${coin.sideB.name}</span>
            </div>
          </div>

          <button class="btn-select-coin" onclick="window.resenhaApp.selectCoinAndPlay('${coin.id}')">
            <span>Jogar com Esta Moeda</span>
            <span>🪙</span>
          </button>
        </div>
      `;
    }).join('');
  }

  getCategoryLabel(cat) {
    const labels = {
      'resenha': '🔥 Oficial',
      'futebol': '⚽ Futebol',
      'jogos': '🎮 Jogos',
      'herois': '🦸 Heróis',
      'paises': '🌍 Países',
      'classica': '👑 Clássica'
    };
    return labels[cat] || cat;
  }

  // Usuário seleciona uma moeda para jogar
  selectCoinAndPlay(coinId) {
    const found = COINS_DATABASE.find(c => c.id === coinId);
    if (found) {
      this.selectedCoin = found;
      // Reseta placar para este confronto
      this.sessionScore.sideA = 0;
      this.sessionScore.sideB = 0;
      this.navigateTo('jogo');
    }
  }

  // Prepara as faces da moeda no jogo com o design selecionado
  applyCoinDesignToGame() {
    const coin = this.selectedCoin;

    // Atualiza cabeçalho do jogo
    this.dom.currentMatchName.textContent = coin.name;
    this.dom.currentMatchCategory.textContent = this.getCategoryLabel(coin.category);

    // Face A (Frontal)
    this.dom.gameFaceFront.style.background = coin.sideA.gradient;
    this.dom.gameFaceFront.style.borderColor = coin.sideA.borderColor;
    this.dom.gameFaceFront.innerHTML = `
      <div class="coin-inner-design">
        <div class="coin-icon">${coin.sideA.icon}</div>
        <span class="coin-text-label" style="color: ${coin.sideA.textColor}">${coin.sideA.badge}</span>
      </div>
    `;

    // Face B (Traseira)
    this.dom.gameFaceBack.style.background = coin.sideB.gradient;
    this.dom.gameFaceBack.style.borderColor = coin.sideB.borderColor;
    this.dom.gameFaceBack.innerHTML = `
      <div class="coin-inner-design">
        <div class="coin-icon">${coin.sideB.icon}</div>
        <span class="coin-text-label" style="color: ${coin.sideB.textColor}">${coin.sideB.badge}</span>
      </div>
    `;

    // Atualiza Placar
    this.dom.scoreLabelA.textContent = coin.sideA.name;
    this.dom.scoreValueA.textContent = this.sessionScore.sideA;
    this.dom.scoreLabelB.textContent = coin.sideB.name;
    this.dom.scoreValueB.textContent = this.sessionScore.sideB;
  }

  // Inicia a rodada com contagem regressiva de 3 segundos
  startCoinTossRound() {
    if (this.isSpinning) return;
    this.isSpinning = true;

    // Configura o visual da moeda
    this.applyCoinDesignToGame();

    // Esconde o container de resultado anterior
    this.dom.resultContainer.classList.remove('revealed');

    // Mostra overlay de contagem regressiva
    this.dom.countdownOverlay.classList.remove('hidden');

    // Remove transições prévias e inicia giro rápido
    const coinElem = this.dom.gameCoinElement;
    coinElem.style.transition = 'none';

    // Inicia rotação contínua rápida via requestAnimationFrame
    let spinAngle = this.currentRotationY % 360;
    let keepSpinning = true;

    const spinRapidLoop = () => {
      if (!keepSpinning) return;
      spinAngle += 28; // Rotação veloz durante a contagem
      coinElem.style.transform = `rotateY(${spinAngle}deg)`;
      requestAnimationFrame(spinRapidLoop);
    };
    requestAnimationFrame(spinRapidLoop);

    // Som de lançamento inicial
    this.sounds.playCoinToss();

    // Contagem Regressiva de 3 Segundos: 3 -> 2 -> 1
    let secondsLeft = 3;
    this.dom.countdownNumber.textContent = secondsLeft;
    this.sounds.playCountdownBeep(secondsLeft);

    clearInterval(this.countdownTimer);
    this.countdownTimer = setInterval(() => {
      secondsLeft--;

      if (secondsLeft > 0) {
        this.dom.countdownNumber.textContent = secondsLeft;
        this.sounds.playCountdownBeep(secondsLeft);
      } else {
        // Chegou ao fim dos 3 segundos!
        clearInterval(this.countdownTimer);
        this.dom.countdownOverlay.classList.add('hidden');
        keepSpinning = false;

        // Determina o vencedor aleatoriamente (50% de chance para cada lado)
        const isSideA = Math.random() < 0.5;
        this.finishCoinSpin(spinAngle, isSideA);
      }
    }, 1000);
  }

  // Desaceleração suave e parada na face sorteada
  finishCoinSpin(currentAngle, isSideA) {
    const coinElem = this.dom.gameCoinElement;
    const coin = this.selectedCoin;

    // 0deg = Face A (Frontal), 180deg = Face B (Traseira)
    // Calcula o próximo múltiplo para uma aterrissagem realista
    const baseRotations = 6 * 360; // 6 voltas adicionais de desaceleração
    const targetFaceAngle = isSideA ? 0 : 180;
    
    // Normaliza para continuar girando no mesmo sentido
    const currentFullTurns = Math.ceil(currentAngle / 360) * 360;
    const finalAngle = currentFullTurns + baseRotations + targetFaceAngle;
    this.currentRotationY = finalAngle;

    // Aplica curva de desaceleração realista (cubic-bezier)
    coinElem.style.transition = 'transform 1.4s cubic-bezier(0.12, 0.85, 0.28, 1)';
    coinElem.style.transform = `rotateY(${finalAngle}deg)`;

    // Quando a moeda parar de girar
    setTimeout(() => {
      this.isSpinning = false;
      this.sounds.playLandImpact();

      // Tremor de tela e impacto tátil
      this.dom.gameCoinStage.classList.add('shake');
      setTimeout(() => this.dom.gameCoinStage.classList.remove('shake'), 400);

      // Atualiza placar
      if (isSideA) {
        this.sessionScore.sideA++;
        this.dom.scoreValueA.textContent = this.sessionScore.sideA;
      } else {
        this.sessionScore.sideB++;
        this.dom.scoreValueB.textContent = this.sessionScore.sideB;
      }

      // Mostra o resultado com efeitos visuais e sonoros
      this.showResultDisplay(isSideA);
    }, 1450);
  }

  // Exibição do Resultado
  showResultDisplay(isSideA) {
    const coin = this.selectedCoin;
    const winner = isSideA ? coin.sideA : coin.sideB;

    this.dom.resultWinnerTitle.textContent = `${winner.name.toUpperCase()}!`;
    this.dom.resultVerdictQuote.textContent = winner.verdict;

    // Som de fanfarra e confetes!
    this.sounds.playFanfare();
    this.confetti.blast();

    // Revela container de ações
    this.dom.resultContainer.classList.add('revealed');
  }

  // Atualização do Ícone de Som
  updateSoundIcon() {
    if (!this.dom.btnMuteAudio) return;
    this.dom.btnMuteAudio.innerHTML = this.sounds.isMuted ? '🔇' : '🔊';
    this.dom.btnMuteAudio.title = this.sounds.isMuted ? 'Ativar som' : 'Desativar som';
  }

  // Vinculação de Eventos
  bindEvents() {
    // Botão Jogar na Home
    if (this.dom.btnGoToSelection) {
      this.dom.btnGoToSelection.addEventListener('click', () => {
        this.sounds.playCoinToss();
        this.navigateTo('selecao');
      });
    }

    // Logo do Cabeçalho (Voltar para a Home)
    const brandLogo = document.querySelector('.brand-logo');
    if (brandLogo) {
      brandLogo.addEventListener('click', (e) => {
        e.preventDefault();
        this.navigateTo('home');
      });
    }

    // Botão de Áudio
    if (this.dom.btnMuteAudio) {
      this.dom.btnMuteAudio.addEventListener('click', () => {
        this.sounds.toggleMute();
        this.updateSoundIcon();
      });
    }

    // Filtros de Categoria
    this.dom.filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        this.dom.filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        this.currentCategory = btn.getAttribute('data-category');
        this.renderCoinsGrid();
      });
    });

    // Campo de Busca
    if (this.dom.searchInput) {
      this.dom.searchInput.addEventListener('input', () => {
        this.renderCoinsGrid();
      });
    }

    // Ações do Jogo
    if (this.dom.btnPlayAgain) {
      this.dom.btnPlayAgain.addEventListener('click', () => {
        this.startCoinTossRound();
      });
    }

    if (this.dom.btnChangeCoin) {
      this.dom.btnChangeCoin.addEventListener('click', () => {
        this.navigateTo('selecao');
      });
    }

    if (this.dom.btnBackHome) {
      this.dom.btnBackHome.addEventListener('click', () => {
        this.navigateTo('home');
      });
    }

    // Modal de Moeda Personalizada
    if (this.dom.btnOpenCustomModal) {
      this.dom.btnOpenCustomModal.addEventListener('click', () => {
        this.dom.customModalBackdrop.classList.add('active');
      });
    }

    if (this.dom.btnCloseCustomModal) {
      this.dom.btnCloseCustomModal.addEventListener('click', () => {
        this.dom.customModalBackdrop.classList.remove('active');
      });
    }

    if (this.dom.customModalBackdrop) {
      this.dom.customModalBackdrop.addEventListener('click', (e) => {
        if (e.target === this.dom.customModalBackdrop) {
          this.dom.customModalBackdrop.classList.remove('active');
        }
      });
    }

    // Formulário de Criação de Moeda Customizada
    if (this.dom.customCoinForm) {
      this.dom.customCoinForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const duelName = document.getElementById('custom-duel-name').value.trim() || 'Duelo Personalizado';
        const sideAName = document.getElementById('custom-side-a').value.trim() || 'Opção A';
        const sideBName = document.getElementById('custom-side-b').value.trim() || 'Opção B';

        const customCoin = {
          id: 'custom-' + Date.now(),
          category: 'resenha',
          name: duelName,
          subtitle: `${sideAName} vs ${sideBName}`,
          sideA: {
            name: sideAName,
            badge: sideAName.substring(0, 10).toUpperCase(),
            gradient: 'radial-gradient(circle at 35% 35%, #ffd54f 0%, #ff9800 60%, #e65100 100%)',
            borderColor: '#ffb300',
            textColor: '#2e1c0c',
            icon: `<span style="font-size: 2.8rem;">✨</span>`,
            verdict: `A decisão foi tomada: ${sideAName.toUpperCase()} é a escolha vencedora! 🎉`
          },
          sideB: {
            name: sideBName,
            badge: sideBName.substring(0, 10).toUpperCase(),
            gradient: 'radial-gradient(circle at 35% 35%, #ff5252 0%, #d50000 60%, #5c0000 100%)',
            borderColor: '#ff1744',
            textColor: '#ffffff',
            icon: `<span style="font-size: 2.8rem;">⚡</span>`,
            verdict: `A decisão foi tomada: ${sideBName.toUpperCase()} é a escolha vencedora! 🔥`
          }
        };

        COINS_DATABASE.unshift(customCoin);
        this.dom.customModalBackdrop.classList.remove('active');
        this.dom.customCoinForm.reset();
        this.renderCoinsGrid();
        this.selectCoinAndPlay(customCoin.id);
      });
    }
  }
}

// Inicializa a aplicação assim que o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
  window.resenhaApp = new ResenhaApp();
});
