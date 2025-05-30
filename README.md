# Desafio Técnico - [ Marcos C. Netto Almeida - ( Perfect Pay + Asaas ) ]

Este repositório contém a solução para o desafio técnico utilizando **Laravel 12**.

## 🚀 Tecnologias Utilizadas

- PHP 8.x
- Laravel 12.x
- MySQL
- Composer
- Asaas API (Sandbox)

## ⚙️ Requisitos

Antes de começar, você precisará ter instalado:

- PHP 8.x
- Composer
- MySQL
- Git

## 🔧 Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/marcoscnettoa/perfectpay-desafio.git
   
2. Instale as dependências do Laravel:
   ```bash
   composer install

3. Copie o arquivo .env.example para .env caso necessário:
   ```bash
   .env.example .env

4. Gere a chave da aplicação:
   ```bash
   php artisan key:generate

5. Configure as variáveis de ambiente no .env:
   ```bash
   ASAAS_API_KEY=""
   ASAAS_BASE_URL="https://sandbox.asaas.com/api/v3"

6. Preparar o banco de dados:
   ```bash
   php artisan migrate
   ou
   importar o database.sql disponível no root 

7. Executando o Projeto
   ```bash
   php artisan serve

## 🔧 Observações

- A integração com o Asaas está preparada para o ambiente sandbox.
- Certifique-se de informar uma chave de API válida na variável ASAAS_API_KEY.
- O arquivo .env.example e o database.sql podem ser usados para uma configuração mais direta do ambiente.

## ⚠️ Atenção

- Este repositório tem caráter **estritamente avaliativo** e está sendo disponibilizado **temporariamente** como parte de um desafio técnico.
- O projeto pode conter **imagens, nomes ou referências** relacionadas à empresa representada no teste.
- O repositório está **público apenas para fins de avaliação** e será **removido após o processo seletivo**.
- **Não deve ser reutilizado ou distribuído** fora desse contexto.
