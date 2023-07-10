# Gerenciamento de Condomínios
Este é um projeto desenvolvido para uma rede de condomínios, com o objetivo de gerenciar os moradores, síndicos e condomínios da rede. O sistema foi desenvolvido utilizando o Laravel, e utiliza o banco de dados MySQL .

# Requisitos
- PHP 8.1
- Laravel
- Composer
- Node
- MySQL

# Configuração
Siga as etapas abaixo para configurar o projeto em seu ambiente local:

- Clone este repositório para o seu diretório local.
- Navegue até o diretório do projeto através do terminal.
- Execute os comandos:
  - `composer install` 
  - `npm install` 

- Crie um arquivo de ambiente `.env` na raiz do projeto e configure as informações do banco de dados.
- Execute o comando `php artisan key:generate` para gerar a chave da aplicação.
- Execute o comando `php artisan migrate --seed` para criar as tabelas no banco de dados.
- Execute o comando `npm run dev` para iniciar o o CSS e o servidor de desenvolvimento.
- Agora você pode acessar o projeto através do seu navegador em http://localhost:8000.

# Acesso 
  ### usuário Admin:
  - email: `admin@test.com`
  - senha: `asdasd`

  ### usuário Sindico:
  - email: `sindico@test.com`
  - senha: `asdasd`
   