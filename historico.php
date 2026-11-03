<?php
/**
 * Página de Histórico & Logs de Auditoria
 * Requisito:
 * - O sistema deve ter uma página de históricos e manter sempre os logs de qualquer
 *   alteração feita por qualquer usuário, para auditorias futuras.
 * - Mobile-First, Tailwind CSS e PDO contra SQL Injection
 */

$pageTitle = 'Histórico & Logs de Auditoria';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/bd.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';

$usuarioAtual = obterUsuarioLogado();
$abaAtiva = $_GET['aba'] ?? 'jogadas'; // 'jogadas' ou 'auditoria'
$filtroResultado = $_GET['resultado'] ?? 'todos';
$filtroAcao = $_GET['acao'] ?? 'todos';
$busca = trim($_GET['busca'] ?? '');

$jogadas = [];
$logsAuditoria = [];
$totalJogadas = 0;
$totalResenhas = 0;
$totalOdios = 0;

if ($pdo) {
    try {
        // Estatísticas para os cards
        $stmtStats = $pdo->query("SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN resultado = 'resenha' THEN 1 ELSE 0 END) as resenhas,
            SUM(CASE WHEN resultado = 'odio' THEN 1 ELSE 0 END) as odios
        FROM jogadas");
        $stats = $stmtStats->fetch() ?: [];
        $totalJogadas = (int)($stats['total'] ?? 0);
        $totalResenhas = (int)($stats['resenhas'] ?? 0);
        $totalOdios = (int)($stats['odios'] ?? 0);

        // 1. Consulta de Jogadas com filtros seguros via PDO
        $sqlJogadas = "SELECT j.*, u.nome as usuario_nome, u.email as usuario_email 
                       FROM jogadas j 
                       LEFT JOIN usuarios u ON j.usuario_id = u.id 
                       WHERE 1=1";
        $paramsJogadas = [];

        if (in_array($filtroResultado, ['resenha', 'odio'])) {
            $sqlJogadas .= " AND j.resultado = ?";
            $paramsJogadas[] = $filtroResultado;
        }

        if (!empty($busca)) {
            $sqlJogadas .= " AND (u.nome LIKE ? OR j.ip LIKE ?)";
            $paramsJogadas[] = "%{$busca}%";
            $paramsJogadas[] = "%{$busca}%";
        }

        $sqlJogadas .= " ORDER BY j.criado_em DESC LIMIT 100";
        $stmtJ = $pdo->prepare($sqlJogadas);
        $stmtJ->execute($paramsJogadas);
        $jogadas = $stmtJ->fetchAll();

        // 2. Consulta de Logs de Auditoria para fiscalização
        $sqlAudit = "SELECT * FROM logs_auditoria WHERE 1=1";
        $paramsAudit = [];

        if (!empty($filtroAcao) && $filtroAcao !== 'todos') {
            $sqlAudit .= " AND acao = ?";
            $paramsAudit[] = $filtroAcao;
        }

        if (!empty($busca)) {
            $sqlAudit .= " AND (usuario_nome LIKE ? OR descricao LIKE ? OR ip LIKE ?)";
            $paramsAudit[] = "%{$busca}%";
            $paramsAudit[] = "%{$busca}%";
            $paramsAudit[] = "%{$busca}%";
        }

        $sqlAudit .= " ORDER BY criado_em DESC LIMIT 100";
        $stmtA = $pdo->prepare($sqlAudit);
        $stmtA->execute($paramsAudit);
        $logsAuditoria = $stmtA->fetchAll();

    } catch (PDOException $e) {
        error_log("[HISTORICO ERROR] " . $e->getMessage());
    }
}
?>

<div class="space-y-6 sm:space-y-8">

    <!-- Cabeçalho da Página -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-emerald-400 uppercase tracking-wider mb-1">
                <span>🛡️ Auditoria & Rastreabilidade</span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                Histórico & Logs de Auditoria
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1 max-w-xl">
                Registros transparentes de lançamentos da moeda e auditoria completa de qualquer alteração de dados no sistema.
            </p>
        </div>

        <!-- Botões de Exportação -->
        <div class="flex items-center gap-2">
            <a href="<?php echo BASE_URL; ?>/actions/exportar_auditoria.php?formato=csv" 
               class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-700 hover:border-emerald-500/50 text-xs font-semibold text-slate-200 transition-all shadow-sm">
                <span>📥</span> Exportar CSV (Excel)
            </a>
            <a href="<?php echo BASE_URL; ?>/actions/exportar_auditoria.php?formato=json" 
               class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-700 hover:border-sky-500/50 text-xs font-semibold text-slate-200 transition-all shadow-sm">
                <span>📋</span> Exportar JSON
            </a>
        </div>
    </div>

    <!-- Cards de Métricas Rápidas -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <div class="glass-card rounded-2xl p-4 text-center">
            <span class="text-[10px] sm:text-xs font-semibold text-slate-400 uppercase">Total Jogadas</span>
            <p class="text-xl sm:text-2xl font-black text-white mt-1"><?php echo $totalJogadas; ?></p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center bg-emerald-950/20 border-emerald-500/30">
            <span class="text-[10px] sm:text-xs font-semibold text-emerald-400 uppercase">😎 Resenhas</span>
            <p class="text-xl sm:text-2xl font-black text-emerald-400 mt-1"><?php echo $totalResenhas; ?></p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center bg-rose-950/20 border-rose-500/30">
            <span class="text-[10px] sm:text-xs font-semibold text-rose-400 uppercase">😡 Ódios</span>
            <p class="text-xl sm:text-2xl font-black text-rose-400 mt-1"><?php echo $totalOdios; ?></p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center">
            <span class="text-[10px] sm:text-xs font-semibold text-slate-400 uppercase">Logs Registrados</span>
            <p class="text-xl sm:text-2xl font-black text-sky-400 mt-1"><?php echo count($logsAuditoria); ?></p>
        </div>
    </div>

    <!-- Navegação em Abas (Mobile-Friendly Segmented Control) -->
    <div class="flex items-center p-1.5 rounded-2xl bg-slate-900/90 border border-slate-800 max-w-md">
        <a href="?aba=jogadas" 
           class="flex-1 text-center py-2 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all <?php echo $abaAtiva === 'jogadas' ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-slate-400 hover:text-white'; ?>">
            🪙 Histórico de Moedas
        </a>
        <a href="?aba=auditoria" 
           class="flex-1 text-center py-2 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all <?php echo $abaAtiva === 'auditoria' ? 'bg-emerald-500 text-slate-950 shadow-md font-bold' : 'text-slate-400 hover:text-white'; ?>">
            🛡️ Logs de Auditoria
        </a>
    </div>

    <!-- Barra de Filtros e Busca -->
    <div class="glass-card rounded-2xl p-4 border border-slate-800">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="hidden" name="aba" value="<?php echo htmlspecialchars($abaAtiva); ?>">

            <div class="flex-1 relative">
                <input type="text" name="busca" value="<?php echo htmlspecialchars($busca); ?>" 
                       placeholder="Pesquisar por usuário, IP ou descrição..." 
                       class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-900/90 border border-slate-700/80 text-xs sm:text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔍</span>
            </div>

            <?php if ($abaAtiva === 'jogadas'): ?>
                <select name="resultado" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs sm:text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    <option value="todos" <?php echo $filtroResultado === 'todos' ? 'selected' : ''; ?>>Todos os Resultados</option>
                    <option value="resenha" <?php echo $filtroResultado === 'resenha' ? 'selected' : ''; ?>>😎 Somente Resenha</option>
                    <option value="odio" <?php echo $filtroResultado === 'odio' ? 'selected' : ''; ?>>😡 Somente Ódio</option>
                </select>
            <?php else: ?>
                <select name="acao" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs sm:text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    <option value="todos" <?php echo $filtroAcao === 'todos' ? 'selected' : ''; ?>>Todas as Ações</option>
                    <option value="JOGADA_MOEDA" <?php echo $filtroAcao === 'JOGADA_MOEDA' ? 'selected' : ''; ?>>🪙 Jogadas da Moeda</option>
                    <option value="CADASTRO_USUARIO" <?php echo $filtroAcao === 'CADASTRO_USUARIO' ? 'selected' : ''; ?>>👤 Cadastros</option>
                    <option value="LOGIN_SUCESSO" <?php echo $filtroAcao === 'LOGIN_SUCESSO' ? 'selected' : ''; ?>>🔑 Logins de Sucesso</option>
                    <option value="LOGIN_FALHA" <?php echo $filtroAcao === 'LOGIN_FALHA' ? 'selected' : ''; ?>>⚠️ Falhas de Login</option>
                    <option value="ALTERACAO_PERFIL" <?php echo $filtroAcao === 'ALTERACAO_PERFIL' ? 'selected' : ''; ?>>✏️ Alterações de Perfil</option>
                    <option value="LOGOUT" <?php echo $filtroAcao === 'LOGOUT' ? 'selected' : ''; ?>>🚪 Logouts</option>
                </select>
            <?php endif; ?>

            <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-bold text-xs sm:text-sm transition-all">
                Filtrar
            </button>
            <?php if (!empty($busca) || $filtroResultado !== 'todos' || $filtroAcao !== 'todos'): ?>
                <a href="?aba=<?php echo $abaAtiva; ?>" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs sm:text-sm flex items-center justify-center">
                    Limpar
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- CONTEÚDO DA ABA 1: HISTÓRICO DE JOGADAS -->
    <?php if ($abaAtiva === 'jogadas'): ?>
        <div class="glass-card rounded-3xl overflow-hidden border border-slate-800 shadow-xl">
            <div class="p-5 border-b border-slate-800/80 flex items-center justify-between">
                <h3 class="text-sm sm:text-base font-bold text-white flex items-center gap-2">
                    <span>🪙</span> Lançamentos Registrados
                </h3>
                <span class="text-xs text-slate-400 font-mono"><?php echo count($jogadas); ?> registros</span>
            </div>

            <?php if (empty($jogadas)): ?>
                <div class="text-center py-12 px-4">
                    <span class="text-4xl">🪙</span>
                    <p class="text-sm font-semibold text-slate-300 mt-2">Nenhum lançamento encontrado</p>
                    <p class="text-xs text-slate-500 mt-1">Ajuste os filtros ou lance uma nova moeda na página inicial.</p>
                </div>
            <?php else: ?>
                <!-- Tabela Responsiva Desktop -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-900/80 text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-800">
                            <tr>
                                <th class="p-4">ID</th>
                                <th class="p-4">Resultado</th>
                                <th class="p-4">Face</th>
                                <th class="p-4">Usuário</th>
                                <th class="p-4">IP</th>
                                <th class="p-4">Probabilidade</th>
                                <th class="p-4">Data e Hora</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 font-sans">
                            <?php foreach ($jogadas as $j): 
                                $isResenha = ($j['resultado'] === 'resenha');
                            ?>
                                <tr class="hover:bg-slate-900/40 transition-colors">
                                    <td class="p-4 font-mono text-slate-500">#<?php echo $j['id']; ?></td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full font-bold uppercase text-[11px] <?php echo $isResenha ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30'; ?>">
                                            <?php echo $isResenha ? '😎 Resenha' : '😡 Ódio'; ?>
                                        </span>
                                    </td>
                                    <td class="p-4 font-mono uppercase text-slate-300"><?php echo htmlspecialchars($j['face']); ?></td>
                                    <td class="p-4 font-medium text-slate-200">
                                        <?php echo htmlspecialchars($j['usuario_nome'] ?: 'Visitante'); ?>
                                    </td>
                                    <td class="p-4 font-mono text-slate-400"><?php echo htmlspecialchars($j['ip']); ?></td>
                                    <td class="p-4 font-mono text-slate-400"><?php echo number_format($j['probabilidade'], 0); ?>%</td>
                                    <td class="p-4 text-slate-400 font-mono"><?php echo date('d/m/Y H:i:s', strtotime($j['criado_em'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Visualização em Cards (Mobile First) -->
                <div class="md:hidden divide-y divide-slate-800/80">
                    <?php foreach ($jogadas as $j): 
                        $isResenha = ($j['resultado'] === 'resenha');
                    ?>
                        <div class="p-4 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full font-bold uppercase text-xs <?php echo $isResenha ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400'; ?>">
                                    <?php echo $isResenha ? '😎 Resenha' : '😡 Ódio'; ?>
                                </span>
                                <span class="text-[11px] font-mono text-slate-400"><?php echo date('d/m/Y H:i', strtotime($j['criado_em'])); ?></span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-slate-300">
                                <span>Por: <strong class="text-white"><?php echo htmlspecialchars($j['usuario_nome'] ?: 'Visitante'); ?></strong></span>
                                <span class="font-mono text-slate-400">Face: <?php echo $j['face']; ?></span>
                            </div>
                            <div class="text-[10px] text-slate-500 font-mono flex items-center justify-between">
                                <span>IP: <?php echo htmlspecialchars($j['ip']); ?></span>
                                <span>Prob: 50%</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    <!-- CONTEÚDO DA ABA 2: LOGS DE AUDITORIA DO SISTEMA -->
    <?php else: ?>
        <div class="glass-card rounded-3xl overflow-hidden border border-slate-800 shadow-xl">
            <div class="p-5 border-b border-slate-800/80 flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-white flex items-center gap-2">
                        <span>🛡️</span> Registros Imutáveis de Auditoria
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Rastreamento de todas as alterações feitas no sistema.</p>
                </div>
                <span class="text-xs text-slate-400 font-mono"><?php echo count($logsAuditoria); ?> registros</span>
            </div>

            <?php if (empty($logsAuditoria)): ?>
                <div class="text-center py-12 px-4">
                    <span class="text-4xl">📜</span>
                    <p class="text-sm font-semibold text-slate-300 mt-2">Nenhum registro de auditoria encontrado</p>
                    <p class="text-xs text-slate-500 mt-1">Nenhum evento corresponde aos filtros informados.</p>
                </div>
            <?php else: ?>
                <!-- Tabela de Auditoria Desktop -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-900/80 text-slate-400 uppercase font-mono text-[10px] tracking-wider border-b border-slate-800">
                            <tr>
                                <th class="p-4">ID</th>
                                <th class="p-4">Data/Hora</th>
                                <th class="p-4">Ação</th>
                                <th class="p-4">Responsável</th>
                                <th class="p-4">Descrição do Evento</th>
                                <th class="p-4">IP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 font-sans">
                            <?php foreach ($logsAuditoria as $l): ?>
                                <tr class="hover:bg-slate-900/40 transition-colors">
                                    <td class="p-4 font-mono text-slate-500">#<?php echo $l['id']; ?></td>
                                    <td class="p-4 text-slate-300 font-mono whitespace-nowrap">
                                        <?php echo date('d/m/Y H:i:s', strtotime($l['criado_em'])); ?>
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[10px] font-bold uppercase bg-slate-800 text-amber-300 border border-amber-500/20">
                                            <?php echo htmlspecialchars($l['acao']); ?>
                                        </span>
                                    </td>
                                    <td class="p-4 font-semibold text-white">
                                        <?php echo htmlspecialchars($l['usuario_nome'] ?: 'Visitante'); ?>
                                    </td>
                                    <td class="p-4 text-slate-300 max-w-sm break-words">
                                        <?php echo htmlspecialchars($l['descricao']); ?>
                                    </td>
                                    <td class="p-4 font-mono text-slate-400"><?php echo htmlspecialchars($l['ip']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Visualização em Cards Mobile -->
                <div class="md:hidden divide-y divide-slate-800/80">
                    <?php foreach ($logsAuditoria as $l): ?>
                        <div class="p-4 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded-md font-mono text-[10px] font-bold uppercase bg-slate-800 text-amber-300 border border-amber-500/20">
                                    <?php echo htmlspecialchars($l['acao']); ?>
                                </span>
                                <span class="text-[10px] font-mono text-slate-400">
                                    <?php echo date('d/m/Y H:i:s', strtotime($l['criado_em'])); ?>
                                </span>
                            </div>
                            <p class="text-xs text-slate-200">
                                <strong class="text-white"><?php echo htmlspecialchars($l['usuario_nome'] ?: 'Visitante'); ?>:</strong>
                                <?php echo htmlspecialchars($l['descricao']); ?>
                            </p>
                            <div class="text-[10px] text-slate-500 font-mono">
                                IP: <?php echo htmlspecialchars($l['ip']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
