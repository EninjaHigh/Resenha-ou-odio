# Resenha ou Ódio

## Objetivos
Jogar uma moeda e definir um resultado à partir de uma chance de 50% vindo das faces dela, onde a cara = resenha; coroa = ódio

### Stack Tecnológico
- Backend: PHP estruturado com sessões nativas
- Banco de dados: MySQL (PDO para segurança)
- Frontend: HTML5, PHP, CSS, Tailwind CSS

#### Regras de negócio (CORE)
Tratar senhas de usuários com hash bcrypt
O sistema deve ter uma página de históricos e manter sempre os logs de qualquer alteração feita por qualquer usuário, para auditorias futuras.

##### Regras Globais
- Use sempre PDO para conexão e queries no MySQL para evitar SQL Injections
- Mantenha o código limpo e comente apenas lógicas complexas.
- Separe os arquivos de forma lógica: um arquivo para conexão com a base (bd.php) e scripts de backend isolados e views em HTML5/PHP, nunca faça o sistema como um monolito, deixe sempre separados todas as regras para facilitar os futuros upgrades.
- Estilize as telas em Tailwind de forma responsiva priorizando o MobileFirst.
- Retorne sempre as mensagens de erros de forma claras na interface para o usuário (TOAST)
- Sempre trate as mensagens de caixa de mensagens nativas do navegador em um MODAL
