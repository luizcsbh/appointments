# Appointments Manager

Este é um projeto desenvolvido em **Next.js** para gerenciar compromissos, que permite criar, editar, visualizar e deletar compromissos. A interface é responsiva e interativa, utilizando **Bootstrap** e **Bootstrap Icons** para os elementos visuais.

## Funcionalidades

- Visualização de compromissos agendados
- Criação de novos compromissos
- Edição de compromissos existentes
- Exclusão de compromissos com confirmação
- Modal para visualização detalhada de cada compromisso

## Tecnologias Utilizadas

- [Next.js](https://nextjs.org/) - Framework de React
- [Bootstrap 5](https://getbootstrap.com/) - Estilização e layout responsivo
- [Date-fns](https://date-fns.org/) - Biblioteca de manipulação de datas
- [API Symfony](https://symfony.com/) - Back-end com Symfony para gerenciamento de dados dos compromissos
- MariaDB - Banco de dados para armazenar compromissos

## Pré-requisitos

- Docker e Docker Compose instalados
- Node.js versão 18.x ou superior
- Composer versão 2.x ou superior

## Como rodar o projeto

### Clonar o repositório

```bash
git clone https://github.com/luizcsbh/appointments.git
cd appointments
```
### 1. Backend (Symfony)

####	1.1	Acesse o diretório api/ e instale as dependências:

```bash
cd api
composer install
```
####    1.2	Inicie o servidor do Symfony com Docker:
    
```bash
docker-compose up -d
```
####	1.3	O servidor Symfony estará disponível em http://localhost:8000.

### 2. Frontend (Next.js)

####	2.1	Acesse o diretório frontend/ e instale as dependências:

```bash
cd frontend
npm install
```
 ####   2.2	Inicie o servidor de desenvolvimento:

```bash
npm run dev
```
####    2.3	O frontend estará disponível em http://localhost:3000.

### Banco de Dados

O banco de dados MariaDB será iniciado automaticamente via Docker utilizando o arquivo docker-compose.yml. As credenciais são:

	•	Usuário: root
	•	Senha: rootadmin


#API Endpoints

A aplicação realiza chamadas para a API do Symfony para gerenciar compromissos. Os principais endpoints são:

	•	GET /api/appointments: Retorna a lista de compromissos.
	•	POST /api/appointments: Cria um novo compromisso.
	•	PATCH /api/appointments/{id}: Atualiza um compromisso existente.
	•	DELETE /api/appointments/{id}: Deleta um compromisso.

Confirmação de Exclusão

Antes de excluir um compromisso, o sistema exibe um modal de confirmação, evitando exclusões acidentais.

## Informações do Desenvolvedor

Desenvolvido por Luiz Santos.

LinkedIn: https://www.linkedin.com/in/luizcsbh/

GitHub: https://github.com/luizcsbh

E-mail: luizcsdev@gmail.com