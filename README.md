
# 📦 Sistema de Produtos — Laravel + Livewire 3 + Breeze + TailwindCSS

Este projeto é um CRUD completo de produtos utilizando **Laravel 12.x**, **Livewire 3**, **TailwindCSS**, **Laravel Breeze** (autenticação) e arquitetura com **Repository + Service Pattern**.

O sistema inclui:
- Login e Registro (Laravel Breeze)
- Dashboard com CRUD de produtos
- Componentes Livewire desacoplados
- Mensagens de sucesso com eventos Livewire 3
- Exportação PDF
- API REST para Produtos (Laravel Resource)
- Layout moderno usando Tailwind

---

## 🚀 Tecnologias utilizadas

- **PHP 8.2+**
- **Laravel 12.x**
- **MySQL / MariaDB**
- **Laravel Breeze**
- **Livewire 3**
- **TailwindCSS**
- **Vite**
- **Repository / Service Pattern**
- **API Resource (Transformers)**

---

## 📂 Pré-requisitos

Certifique-se de ter instalado:

- PHP **8.2 ou superior**
- Composer
- MySQL ou MariaDB
- Node.js **18+**
- NPM ou Yarn

---

🧩 Componentes Principais
✔ Livewire 3

ProdutosDashboard — CRUD completo no Dashboard
Produtos — CRUD simples
Eventos Livewire 3 ($this->dispatch('notify'))

✔ API REST

GET /api/produtos

POST /api/produtos

PUT /api/produtos/{id}

DELETE /api/produtos/{id}

Transformações via ProdutoResource


## 🔧 Instalação e configuração

### 1️⃣ Clone o repositório

```bash
git clone https://github.com/tonguedes/teste_entrevista.git
cd seu-projeto

2️⃣ Instale as dependências do PHP
composer install

3️⃣ Copie o arquivo de ambiente e gere a chave
cp .env.example .env
php artisan key:generate

4️⃣ Configure o banco de dados no arquivo .env

Exemplo:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teste_produtos
DB_USERNAME=root
DB_PASSWORD=

5️⃣ Rode as migrações
php artisan migrate

6️⃣ Inicie o servidor Laravel
php artisan serve

7️⃣ Instale dependências do frontend
npm install

8️⃣ Inicie o Vite
npm run dev

Acesse o projeto:

http://localhost:8000

Ao acessar o projeto será redirecionado para a tela de registro, ai só cadastrar um usuário já ira para o dashboard quando fizer o login.
------------------------------------------------------------------------------------------------------------------------------------
Script SQL (crie teste_entrevista.sql)
CREATE DATABASE IF NOT EXISTS `teste_entrevista` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `teste_entrevista`;
CREATE TABLE `produtos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(150) NOT NULL,
  `preco` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

