<?php
/**
 * Página Principal: Jogo da Moeda 3D
 * "Resenha ou Ódio"
 * Requisitos:
 * - Jogar uma moeda e definir um resultado à partir de uma chance de 50% vindo das faces dela
 * - Cara = Resenha; Coroa = Ódio
 * - MobileFirst e estilizado com Tailwind CSS
 */

$pageTitle = 'Jogar a Moeda (50% Chance)';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/bd.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';

// Consulta estatísticas acumuladas do banco MySQL
$totalJogadas = 0;
$totalResenhas = 0;
$totalOdios = 0;
$percResenha = 50.0;
$percOdio = 50.0;
$jogadasRecentes = [];

if ($pdo) {
    try {
        $stmtStats = $pdo->query("SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN resultado = 'resenha' THEN 1 ELSE 0 END) as resenhas,
            SUM(CASE WHEN resultado = 'odio' THEN 1 ELSE 0 END) as odios
        FROM jogadas");
        $stats = $stmtStats->fetch() ?: [];

        $totalJogadas = (int)($stats['total'] ?? 0);
        $totalResenhas = (int)($stats['resenhas'] ?? 0);
        $totalOdios = (int)($stats['odios'] ?? 0);

        if ($totalJogadas > 0) {
            $percResenha = round(($totalResenhas / $totalJogadas) * 100, 1);
            $percOdio = round(($totalOdios / $totalJogadas) * 100, 1);
        }

        // Últimas 5 jogadas para exibir na tela inicial
        $stmtRecentes = $pdo->query("SELECT j.*, u.nome as usuario_nome 
                                     FROM jogadas j 
                                     LEFT JOIN usuarios u ON j.usuario_id = u.id 
                                     ORDER BY j.criado_em DESC 
                                     LIMIT 5");
        $jogadasRecentes = $stmtRecentes->fetchAll();
    } catch (PDOException $e) {
        error_log("[INDEX QUERY ERROR] " . $e->getMessage());
    }
}
?>

<div class="max-w-4xl mx-auto space-y-8 sm:space-y-12">

    <!-- Hero Section Mobile-First -->
    <div class="text-center space-y-3 pt-2">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-xs font-semibold text-slate-300 shadow-sm">
            <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>Probabilidade Imparcial: 50% / 50%</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white">
            Hoje vai dar <span class="bg-gradient-to-r from-emerald-400 to-teal-300 bg-clip-text text-transparent">Resenha</span> ou <span class="bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">Ódio</span>?
        </h1>
        <p class="text-sm sm:text-base text-slate-400 max-w-xl mx-auto">
            Jogue a moeda e deixe o destino decidir. Cara dá <strong class="text-emerald-400">Resenha</strong> (festa, chopp e paz) e Coroa dá <strong class="text-rose-400">Ódio</strong> (trabalho acumulado e estresse).
        </p>
    </div>

    <!-- Palco da Moeda 3D e Controles Interativos -->
    <div class="glass-card rounded-3xl p-6 sm:p-10 text-center relative overflow-hidden shadow-2xl">
        
        <!-- Botão Flutuante de Controle de Áudio -->
        <div class="absolute top-4 right-4 z-20">
            <button type="button" id="btn-toggle-som" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900/80 hover:bg-slate-800 border border-slate-700/80 text-xs font-medium text-slate-300 transition-all focus:outline-none" title="Ativar/Desativar Sons">
                <span id="icone-som">🔊</span>
                <span id="texto-som" class="hidden sm:inline">Som Ativo</span>
            </button>
        </div>

        <!-- Palco de Perspectiva 3D da Moeda -->
        <div class="coin-stage flex flex-col items-center justify-center my-4 sm:my-6 min-h-[260px] sm:min-h-[300px]">
            
            <div id="moeda-3d" class="coin-3d coin-idle group" title="Clique ou toque para girar a moeda!">
                
                <!-- Face CARA = RESENHA 😎 -->
                <div class="coin-face coin-face-cara">
                    <div class="coin-shine"></div>
                    <div class="text-4xl sm:text-5xl mb-1 transform group-hover:scale-110 transition-transform">😎</div>
                    <div class="text-lg sm:text-xl font-black tracking-wider uppercase drop-shadow-md">RESENHA</div>
                    <div class="text-[10px] tracking-widest text-emerald-200/80 font-mono mt-1 font-bold">50% CHANCE • CARA</div>
                    <div class="text-xs mt-1 text-emerald-100 opacity-90">🍺🎉🍹</div>
                </div>

                <!-- Face COROA = ÓDIO 😡 -->
                <div class="coin-face coin-face-coroa">
                    <div class="coin-shine"></div>
                    <div class="text-4xl sm:text-5xl mb-1 transform group-hover:scale-110 transition-transform">😡</div>
                    <div class="text-lg sm:text-xl font-black tracking-wider uppercase drop-shadow-md">ÓDIO</div>
                    <div class="text-[10px] tracking-widest text-rose-200/80 font-mono mt-1 font-bold">50% CHANCE • COROA</div>
                    <div class="text-xs mt-1 text-rose-100 opacity-90">🔥💥💣</div>
                </div>

            </div>

            <!-- Sombra Dinâmica -->
            <div class="coin-shadow"></div>

        </div>

        <!-- Dica de Interatividade Mobile -->
        <p class="text-xs text-slate-400 mb-6 flex items-center justify-center gap-1.5">
            <span>👆</span> Toque na moeda ou clique no botão abaixo para lançar
        </p>

        <!-- Botão Principal de Lançamento (Mobile-First) -->
        <div class="max-w-xs mx-auto">
            <button type="button" id="btn-jogar-moeda" class="w-full inline-flex items-center justify-center gap-3 px-6 py-4 rounded-2xl text-base sm:text-lg font-bold text-white bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-400 hover:via-teal-400 hover:to-emerald-500 shadow-xl shadow-emerald-500/25 transform transition-all active:scale-95 focus:outline-none focus:ring-4 focus:ring-emerald-500/30">
                <span>🪙</span>
                <span>Jogar Moeda Agora!</span>
            </button>
        </div>

        <!-- Fallback Tradicional Form POST (caso JavaScript esteja desativado) -->
        <noscript>
            <form action="<?php echo BASE_URL; ?>/actions/jogar.php" method="POST" class="mt-4">
                <button type="submit" class="px-5 py-3 rounded-xl bg-emerald-600 text-white font-bold text-sm">
                    Lançar Moeda (Modo Seguro sem JS)
                </button>
            </form>
        </noscript>

        <!-- Card de Resultado (Exibido Dinamicamente) -->
        <div id="resultado-box" class="hidden mt-8 max-w-md mx-auto">
            <span id="resultado-badge" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider"></span>
            <h2 id="resultado-titulo" class="text-2xl sm:text-3xl font-extrabold text-white mt-2"></h2>
            <p id="resultado-frase" class="text-sm text-slate-300 mt-1 leading-relaxed"></p>
        </div>

    </div>

    <!-- Estatísticas Globais em Tempo Real -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <div class="glass-card rounded-2xl p-5 border border-slate-800 text-center">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total de Jogadas</p>
            <p id="stat-total" class="text-2xl sm:text-3xl font-black text-white mt-1"><?php echo $totalJogadas; ?></p>
            <p class="text-[11px] text-slate-500 mt-1">Registradas no MySQL</p>
        </div>

        <div class="glass-card rounded-2xl p-5 border border-emerald-500/30 text-center bg-emerald-950/20">
            <p class="text-xs font-medium text-emerald-400 uppercase tracking-wider">😎 Total Resenhas</p>
            <p id="stat-resenhas" class="text-2xl sm:text-3xl font-black text-emerald-400 mt-1">
                <?php echo $totalResenhas; ?> (<?php echo $percResenha; ?>%)
            </p>
            <p class="text-[11px] text-emerald-500/80 mt-1">Resultado: Cara</p>
        </div>

        <div class="glass-card rounded-2xl p-5 border border-rose-500/30 text-center bg-rose-950/20">
            <p class="text-xs font-medium text-rose-400 uppercase tracking-wider">😡 Total Ódios</p>
            <p id="stat-odios" class="text-2xl sm:text-3xl font-black text-rose-400 mt-1">
                <?php echo $totalOdios; ?> (<?php echo $percOdio; ?>%)
            </p>
            <p class="text-[11px] text-rose-500/80 mt-1">Resultado: Coroa</p>
        </div>

    </div>

    <!-- Barra de Distribuição de Probabilidade -->
    <div class="glass-card rounded-2xl p-4 sm:p-5 border border-slate-800 space-y-2">
        <div class="flex items-center justify-between text-xs font-semibold">
            <span class="text-emerald-400 flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span> Resenha
            </span>
            <span class="text-slate-400 font-mono text-[11px]">Equilíbrio de 50%</span>
            <span class="text-rose-400 flex items-center gap-1.5">
                Ódio <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span>
            </span>
        </div>
        <div class="w-full h-3 rounded-full bg-slate-800 overflow-hidden flex">
            <div id="stat-barra-resenha" class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 transition-all duration-700" style="width: <?php echo $percResenha; ?>%;"></div>
            <div id="stat-barra-odio" class="h-full bg-gradient-to-r from-rose-500 to-red-600 transition-all duration-700" style="width: <?php echo $percOdio; ?>%;"></div>
        </div>
    </div>

    <!-- Histórico Recente no Feed da Home -->
    <div class="glass-card rounded-3xl p-5 sm:p-6 border border-slate-800">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <span>⏱️</span> Últimos Lançamentos
            </h3>
            <a href="<?php echo BASE_URL; ?>/historico.php" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 transition-colors">
                Ver Histórico Completo & Auditoria →
            </a>
        </div>

        <div id="lista-jogadas-recentes" class="space-y-2.5">
            <?php if (empty($jogadasRecentes)): ?>
                <p id="historico-vazio-msg" class="text-xs text-slate-500 text-center py-6">
                    Nenhuma jogada registrada ainda. Seja o primeiro a lançar a moeda! 🪙
                </p>
            <?php else: ?>
                <?php foreach ($jogadasRecentes as $jr): 
                    $isResenha = ($jr['resultado'] === 'resenha');
                ?>
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-900/80 border border-slate-800/80 text-xs">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl"><?php echo $isResenha ? '😎' : '😡'; ?></span>
                            <div>
                                <span class="font-bold <?php echo $isResenha ? 'text-emerald-400' : 'text-rose-400'; ?> uppercase">
                                    <?php echo $isResenha ? 'Resenha' : 'Ódio'; ?>
                                </span>
                                <span class="text-slate-400 block text-[10px]">
                                    Por <?php echo htmlspecialchars($jr['usuario_nome'] ?: 'Visitante'); ?> (Face: <?php echo $jr['face']; ?>)
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono <?php echo $isResenha ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300'; ?>">
                                <?php echo date('H:i:s', strtotime($jr['criado_em'])); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- Script do Motor da Moeda -->
<script src="<?php echo BASE_URL; ?>/assets/js/coin.js"></script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
