<?php
/**
 * Tela de Perfil e Segurança do Usuário
 * Requisitos:
 * - Autenticação protegida
 * - Manter sempre os logs de qualquer alteração feita por qualquer usuário
 * - Tratamento de senhas com bcrypt
 * - MobileFirst e Tailwind CSS
 */

$pageTitle = 'Meu Perfil & Segurança';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/bd.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';

exigirAutenticacao();

$usuario = obterUsuarioLogado();
$usuarioId = (int)$usuario['id'];

// Carrega estatísticas do usuário
$totalMinhasJogadas = 0;
$totalMinhasResenhas = 0;
$totalMeusOdios = 0;
$meusLogs = [];

if ($pdo) {
    try {
        $stmtStats = $pdo->prepare("SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN resultado = 'resenha' THEN 1 ELSE 0 END) as resenhas,
            SUM(CASE WHEN resultado = 'odio' THEN 1 ELSE 0 END) as odios
        FROM jogadas WHERE usuario_id = ?");
        $stmtStats->execute([$usuarioId]);
        $minhasStats = $stmtStats->fetch() ?: [];

        $totalMinhasJogadas = (int)($minhasStats['total'] ?? 0);
        $totalMinhasResenhas = (int)($minhasStats['resenhas'] ?? 0);
        $totalMeusOdios = (int)($minhasStats['odios'] ?? 0);

        // Últimas atividades do usuário no log de auditoria
        $stmtLogs = $pdo->prepare("SELECT * FROM logs_auditoria WHERE usuario_id = ? ORDER BY criado_em DESC LIMIT 10");
        $stmtLogs->execute([$usuarioId]);
        $meusLogs = $stmtLogs->fetchAll();
    } catch (PDOException $e) {
        error_log("[PERFIL QUERY ERROR] " . $e->getMessage());
    }
}
?>

<div class="max-w-4xl mx-auto space-y-6 sm:space-y-8">

    <!-- Card de Boas-vindas do Perfil -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 border border-slate-800 flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-emerald-600 flex items-center justify-center text-white text-3xl font-extrabold shadow-xl shadow-emerald-500/20 uppercase">
            <?php echo mb_substr($usuario['nome'], 0, 1, 'UTF-8'); ?>
        </div>
        <div class="flex-1 space-y-1">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                <h1 class="text-2xl font-black text-white"><?php echo htmlspecialchars($usuario['nome']); ?></h1>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                    Usuário Ativo
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-400 font-mono"><?php echo htmlspecialchars($usuario['email']); ?></p>
            <p class="text-[11px] text-slate-500 pt-1">
                Membro desde <?php echo date('d/m/Y', strtotime($usuario['criado_em'])); ?> • Auditoria ativa
            </p>
        </div>
    </div>

    <!-- Estatísticas Pessoais -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="glass-card rounded-2xl p-4 text-center">
            <span class="text-xs font-semibold text-slate-400 uppercase">Suas Moedas Jogadas</span>
            <p class="text-2xl font-black text-white mt-1"><?php echo $totalMinhasJogadas; ?></p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center bg-emerald-950/20 border-emerald-500/30">
            <span class="text-xs font-semibold text-emerald-400 uppercase">😎 Suas Resenhas</span>
            <p class="text-2xl font-black text-emerald-400 mt-1"><?php echo $totalMinhasResenhas; ?></p>
        </div>
        <div class="glass-card rounded-2xl p-4 text-center bg-rose-950/20 border-rose-500/30">
            <span class="text-xs font-semibold text-rose-400 uppercase">😡 Seus Ódios</span>
            <p class="text-2xl font-black text-rose-400 mt-1"><?php echo $totalMeusOdios; ?></p>
        </div>
    </div>

    <!-- Formulário de Atualização Cadastral e Segurança -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 border border-slate-800">
        <h2 class="text-lg font-bold text-white mb-2 flex items-center gap-2">
            <span>⚙️</span> Alterar Dados & Senha
        </h2>
        <p class="text-xs text-slate-400 mb-6">
            Qualquer alteração efetuada aqui será gravada no histórico de auditoria para fins de segurança.
        </p>

        <form action="<?php echo BASE_URL; ?>/actions/perfil_process.php" method="POST" id="form-perfil" class="space-y-5">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nome" class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                        Nome Completo
                    </label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required minlength="3"
                           class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700/80 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                        E-mail (Identificador Único)
                    </label>
                    <input type="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" disabled
                           class="w-full px-4 py-3 rounded-xl bg-slate-900/50 border border-slate-800 text-sm text-slate-500 cursor-not-allowed">
                </div>
            </div>

            <!-- Divisor para Troca de Senha -->
            <div class="pt-4 border-t border-slate-800/80 space-y-4">
                <div class="flex items-center gap-2">
                    <span class="text-sm">🔑</span>
                    <h3 class="text-xs font-bold text-slate-200 uppercase tracking-wider">
                        Segurança & Troca de Senha (Opcional)
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="senha_atual" class="block text-[11px] font-semibold text-slate-400 mb-1 uppercase">
                            Senha Atual
                        </label>
                        <input type="password" id="senha_atual" name="senha_atual" placeholder="Atual"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 text-xs sm:text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    </div>
                    <div>
                        <label for="nova_senha" class="block text-[11px] font-semibold text-slate-400 mb-1 uppercase">
                            Nova Senha (Bcrypt)
                        </label>
                        <input type="password" id="nova_senha" name="nova_senha" minlength="6" placeholder="Mínimo 6 chars"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 text-xs sm:text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    </div>
                    <div>
                        <label for="confirma_nova_senha" class="block text-[11px] font-semibold text-slate-400 mb-1 uppercase">
                            Confirmar Nova Senha
                        </label>
                        <input type="password" id="confirma_nova_senha" name="confirma_nova_senha" placeholder="Repetir nova senha"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-700/80 text-xs sm:text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
                <p class="text-[11px] text-slate-500">
                    ⚠️ A alteração da senha exigirá a confirmação do hash bcrypt da senha anterior.
                </p>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 shadow-md shadow-emerald-500/20 transition-all active:scale-95">
                    Salvar Alterações
                </button>
            </div>

        </form>
    </div>

    <!-- Histórico de Auditoria do Próprio Usuário -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 border border-slate-800">
        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
            <span>📋</span> Minhas Últimas Atividades Auditadas
        </h3>
        
        <?php if (empty($meusLogs)): ?>
            <p class="text-xs text-slate-500">Nenhum evento registrado ainda.</p>
        <?php else: ?>
            <div class="space-y-2.5">
                <?php foreach ($meusLogs as $ml): ?>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/60 border border-slate-800 text-xs">
                        <div class="space-y-0.5">
                            <span class="px-2 py-0.5 rounded font-mono text-[10px] font-bold uppercase bg-slate-800 text-amber-300">
                                <?php echo htmlspecialchars($ml['acao']); ?>
                            </span>
                            <p class="text-slate-300 text-xs mt-1"><?php echo htmlspecialchars($ml['descricao']); ?></p>
                        </div>
                        <div class="text-right font-mono text-[10px] text-slate-500">
                            <?php echo date('d/m/Y H:i', strtotime($ml['criado_em'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
    // Validação com Modal de Confirmação conforme requisito
    document.getElementById('form-perfil').addEventListener('submit', async function(e) {
        e.preventDefault();
        const nome = document.getElementById('nome').value.trim();
        const novaSenha = document.getElementById('nova_senha').value;
        const confirmaNovaSenha = document.getElementById('confirma_nova_senha').value;
        const senhaAtual = document.getElementById('senha_atual').value;

        if (nome.length < 3) {
            window.mostrarToast({ tipo: 'error', titulo: 'Nome Inválido', mensagem: 'O nome precisa de pelo menos 3 caracteres.' });
            return;
        }

        if (novaSenha) {
            if (!senhaAtual) {
                window.mostrarToast({ tipo: 'warning', titulo: 'Senha Atual Exigida', mensagem: 'Informe a senha atual para autorizar a troca.' });
                return;
            }
            if (novaSenha.length < 6) {
                window.mostrarToast({ tipo: 'error', titulo: 'Senha Curta', mensagem: 'A nova senha precisa ter no mínimo 6 caracteres.' });
                return;
            }
            if (novaSenha !== confirmaNovaSenha) {
                window.mostrarToast({ tipo: 'error', titulo: 'Senhas Diferentes', mensagem: 'A confirmação não confere com a nova senha.' });
                return;
            }
        }

        const confirmou = await window.confirmModal(
            'Deseja realmente aplicar e auditar as alterações no seu perfil?',
            'Confirmar Atualização de Dados'
        );

        if (confirmou) {
            this.submit();
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
