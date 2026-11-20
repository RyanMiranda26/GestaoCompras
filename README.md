# Gestão de Compras

Aplicação web em PHP e MySQL para gerir as compras de uma despensa (por exemplo, de um supermercado): controla as existências, recebe pedidos extra e gera automaticamente a lista de compras.

## Funcionalidades

- Login com dois perfis: administrador e utilizador geral
- Lista dos artigos da despensa, com a quantidade atual e a quantidade mínima de cada um
- **Utilizador geral:** atualiza as quantidades e faz pedidos extra à lista de compras
- **Administrador:** edita e apaga artigos, e aprova ou rejeita os pedidos extra
- Lista de compras gerada automaticamente com os artigos abaixo da quantidade mínima e os pedidos extra aprovados

## Tecnologias

- PHP 8 (PDO)
- MySQL / MariaDB
- HTML

## Como executar

1. Instalar o XAMPP (ou outro servidor com PHP e MySQL).
2. Copiar a pasta do projeto para `htdocs`.
3. Importar o ficheiro `gestaoCompras.sql` no phpMyAdmin.
4. Confirmar os dados de ligação à base de dados em `codigo.php` (o projeto usa a porta 3307).
5. Abrir `http://localhost/GestaoCompras/login.php`.

Contas de teste (incluídas no ficheiro SQL):

| Perfil | NIF | Palavra-passe |
|---|---|---|
| Administrador | 111111111 | admin123 |
| Utilizador geral | 222222222 | geral123 |

## Melhorias futuras

- Guardar as palavras-passe com hash (`password_hash`)
- Melhorar o aspeto visual da interface
