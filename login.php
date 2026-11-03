<?php
/**
 * Tela de Login
 * Requisitos:
 * - Autenticação com senhas hash bcrypt
 * - Sessões nativas do PHP
 * - Retorno de erros via Toast
 * - MobileFirst e Tailwind CSS
 */

$pageTitle = 'Entrar na Conta';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/auth.php';

// Se já estiver logado, redireciona para a página principal
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
                🔐
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Acesse sua Conta</h1>
            <p class="text-xs text-slate-400">Entre para registrar suas jogadas no histórico com seu perfil.</p>
        </div>

        <!-- Formulário de Login -->
        <form action="<?php echo BASE_URL; ?>/actions/login_process.php" method="POST" id="form-login" class="space-y-4">
            
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
                <div class="flex items-center justify-between mb-1.5">
                    <label for="senha" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">
                        Senha (Bcrypt)
                    </label>
                </div>
                <div class="relative">
                    <input type="password" id="senha" name="senha" required placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900 border border-slate-700/80 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <span class="absolute left-3.5 top-3.5 text-slate-400 text-sm">🔒</span>
                </div>
            </div>

            <button type="submit" class="w-full mt-2 inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 shadow-lg shadow-emerald-500/20 transform transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                <span>Entrar no Sistema</span>
                <span>→</span>
            </button>

        </form>

        <!-- Dica de Acesso Rápido / Demo -->
        <div class="mt-6 p-3.5 rounded-2xl bg-slate-900/60 border border-slate-800 text-[11px] text-slate-400">
            <span class="font-bold text-amber-400">💡 Conta Demo (database.sql):</span>
            <div class="font-mono mt-1 text-slate-300">
                Email: <span class="text-emerald-400">admin@resenha.com</span> | Senha: <span class="text-emerald-400">admin123</span>
            </div>
        </div>

        <!-- Rodapé do Card -->
        <div class="mt-6 pt-5 border-t border-slate-800/80 text-center text-xs text-slate-400">
            Não tem uma conta ainda? 
            <a href="<?php echo BASE_URL; ?>/cadastro.php" class="font-bold text-emerald-400 hover:text-emerald-300 transition-colors">
                Criar Conta Grátis
            </a>
        </div>

    </div>
</div>

<script>
    // Validação Mobile-First no Client-side com Toasts claros
    document.getElementById('form-login').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value.trim();
        const senha = document.getElementById('senha').value.trim();

        if (!email || !senha) {
            e.preventDefault();
            window.mostrarToast({
                tipo: 'warning',
                titulo: 'Atenção',
                mensagem: 'Preencha todos os campos para fazer login.'
            });
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
