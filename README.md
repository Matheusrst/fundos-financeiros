# Financial Funds Application

## Descrição

Este é um projeto de aplicação financeira para compra e venda de ações e fundos. O sistema permite a gestão de ativos financeiros, a visualização de gráficos históricos e a manutenção de um saldo em uma carteira.

## Funcionalidades

- **Gestão de Ações e Fundos**: Criação, edição e exclusão de ações e fundos financeiros.
- **Transações**: Realização de transações de compra e venda com registro histórico.
- **Gráficos**: Visualização de gráficos históricos de preços de ações e fundos.
- **Carteira**: Gerenciamento do saldo da carteira do usuário.

## Tecnologias Utilizadas

- **Laravel**: Framework PHP para desenvolvimento web.
- **Blade**: Motor de templates do Laravel.
- **MySQL**: Sistema de gerenciamento de banco de dados.
- **Tailwind CSS**: Framework de CSS para estilização.

## Instalação

1. **Clone o repositório**

   ```bash
   git clone https://github.com/seuusuario/nome-do-repositorio.git
   cd nome-do-repositorio
   ```

2. **Instale as dependências do PHP**

   ```bash
   composer install
   ```

3. **Configure o ambiente**

   Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente, especialmente as credenciais do banco de dados.

   ```bash
   cp .env.example .env
   ```

4. **Gere a chave de aplicativo**

   ```bash
   php artisan key:generate
   ```

5. **Execute as migrações do banco de dados**

   ```bash
   php artisan migrate
   ```

6. **Inicie o servidor**

   ```bash
   php artisan serve
   ```

## Uso

- **Dashboard**: Página inicial com visão geral das ações e fundos.
- **Stocks**: Página para visualizar, criar, editar e deletar ações.
- **Funds**: Página para visualizar, criar, editar e deletar fundos.
- **Transactions**: Página para visualizar o histórico de transações.
- **Graphs**: Página para visualizar gráficos históricos de preços.

## Rotas

- `GET /` - Dashboard
- `GET /stocks` - Lista de Ações
- `GET /stocks/create` - Criar Ação
- `GET /stocks/{id}/edit` - Editar Ação
- `POST /stocks` - Salvar nova Ação
- `PUT /stocks/{id}` - Atualizar Ação
- `DELETE /stocks/{id}` - Deletar Ação
- `GET /funds` - Lista de Fundos
- `GET /funds/create` - Criar Fundo
- `GET /funds/{id}/edit` - Editar Fundo
- `POST /funds` - Salvar novo Fundo
- `PUT /funds/{id}` - Atualizar Fundo
- `DELETE /funds/{id}` - Deletar Fundo
- `GET /transactions` - Histórico de Transações
- `GET /transactions/create` - Criar Transação
- `POST /transactions` - Salvar nova Transação
- `GET /graphs` - Gráficos de Preços

## Contribuição

Se você deseja contribuir com o projeto, siga os seguintes passos:

1. Fork o repositório.
2. Crie uma nova branch (`git checkout -b feature/nova-feature`).
3. Faça suas alterações e commit (`git commit -am 'Adiciona nova feature'`).
4. Faça o push para a branch (`git push origin feature/nova-feature`).
5. Abra um Pull Request.

## Licença

Este é um projeto open source de codigo e licença aberta sem nehuma finalidade de uso proficional ou industrial.
