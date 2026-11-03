<?php
/**
 * Tela de Cadastro de Usuário
 * Requisitos:
 * - Tratar senhas de usuários com hash bcrypt
 * - Validações claras e Toasts responsivos
 * - MobileFirst e Tailwind CSS
 */

$pageTitle = 'Criar Nova Conta';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/auth.php';

if (estaAutenticado()) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-md mx-auto py-4 sm:py-8">
    <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-800">
        
        <!-- Cabeçalho do Card -->
        <div class="text-center space-y-2 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 mx-auto flex items-center justify-center text-2xl shadow-lg shadow-emerald-500/20">
                ✨
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Criar Conta</h1>
            <p class="text-xs text-slate-400">Cadastre-se para acompanhar seu histórico e auditoria de jogadas.</p>
        </div>

        <!-- Formulário de Cadastro -->
        <form action="<?php echo BASE_URL; ?>/actions/cadastro_process.php" method="POST" id="form-cadastro" class="space-y-4">
            
            <div>
                <label for="nome" class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                    Nome Completo
                </label>
                <div class="relative">
                    <input type="text" id="nome" name="nome" required minlength="3" placeholder="Ex: Seu Nome"
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900 border border-slate-700/80 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <span class="absolute left-3.5 top-3.5 text-slate-400 text-sm">👤</span>
                </div>
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                    E-mail
                </label>
                <div class="relative">
                    <input type="email" id="email" name="email" required placeholder="seu.email@exemplo.com"
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900 border border-slate-700/80 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <span class="absolute left-3.5 top-3.5 text-slate-400 text-sm">✉️</span>
                </div>
            </div>

            <div>
                <label for="senha" class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                    Senha (Mínimo 6 dígitos)
                </label>
                <div class="relative">
                    <input type="password" id="senha" name="senha" required minlength="6" placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900 border border-slate-700/80 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <span class="absolute left-3.5 top-3.5 text-slate-400 text-sm">🔒</span>
                </div>
            </div>

            <div>
                <label for="confirma_senha" class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                    Confirmar Senha
                </label>
                <div class="relative">
                    <input type="password" id="confirma_senha" name="confirma_senha" required minlength="6" placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900 border border-slate-700/80 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <span class="absolute left-3.5 top-3.5 text-slate-400 text-sm">🛡️</span>
                </div>
            </div>

            <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800 text-[11px] text-slate-400 flex items-start gap-2">
                <span class="text-emerald-400 text-sm mt-0.5">🔒</span>
                <p>Segurança Ativa: Todas as senhas são processadas com algoritmo seguro <strong>Bcrypt</strong> com custo dinâmico e salting automático.</p>
            </div>

            <button type="submit" class="w-full mt-2 inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 shadow-lg shadow-emerald-500/20 transform transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                <span>Concluir Cadastro</span>
                <span>✨</span>
            </button>

        </form>

        <!-- Rodapé do Card -->
        <div class="mt-6 pt-5 border-t border-slate-800/80 text-center text-xs text-slate-400">
            Já possui cadastro? 
            <a href="<?php echo BASE_URL; ?>/login.php" class="font-bold text-emerald-400 hover:text-emerald-300 transition-colors">
                Entrar na Conta
            </a>
        </div>

    </div>
</div>

<script>
    // Validação no front com interceptação clara via Toast
    document.getElementById('form-cadastro').addEventListener('submit', function(e) {
        const nome = document.getElementById('nome').value.trim();
        const email = document.getElementById('email').value.trim();
        const senha = document.getElementById('senha').value;
        const confirma = document.getElementById('confirma_senha').value;

        if (nome.length < 3) {
            e.preventDefault();
            window.mostrarToast({ tipo: 'error', titulo: 'Nome Curto', mensagem: 'O nome precisa ter pelo menos 3 caracteres.' });
            return;
        }

        if (senha.length < 6) {
            e.preventDefault();
            window.mostrarToast({ tipo: 'error', titulo: 'Senha Fraca', mensagem: 'A senha precisa ter pelo menos 6 caracteres.' });
            return;
        }

        if (senha !== confirma) {
            e.preventDefault();
            window.mostrarToast({ tipo: 'error', titulo: 'Senhas Diferentes', mensagem: 'A confirmação de senha não confere com a senha digitada.' });
            return;
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
