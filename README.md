# 📂 API de Controle de Estoque e Vendas

## 📝 Propósito  
Desenvolver uma API REST utilizando Laravel que gerencie um módulo simplificado de controle de estoque e vendas para um ERP.

## 🔹 Principais Features  
- Registrar entrada de produtos no estoque com suas respectivas quantidades e preços de custo
- Consultar o estoque atual com valores totais e lucro projetado
- Registrar uma venda com diversos itens, calculando automaticamente o a margem de lucro, valor total da venda e valor total de custo
- Consultar os detalhes de uma venda
- Testes unitários dos metodos das controllers

## 🛠️ Tecnologias Utilizadas 
- **Aplicação:** PHP 8.2 + Laravel 12
- **Database:** MySQL
- **Testes Unitários:** PHPUnit + SQLite  
- **Infraestrutura:** Docker/Docker Compose  


# 🚀 Setup e execução
---

📌 Esse setup presume que você tenha o Docker/Docker Compose instalado

Clone o repositório

```sh
git clone https://github.com/xSaraKemily/inventory-sales-control.git
```

Entrar na pasta do projeto

```sh
cd inventory-sales-control
```

Iniciar os container do projeto
---
```sh
docker-compose up -d
```

Criar arquivo .env
---
```sh
cp .env.example .env
```

Acessar o container do app
---
```sh
docker-compose exec app bash
```

Instalar as dependencias do projeto
---
```sh
composer install
```

Gerar a application key do laravel
---
```sh
php artisan key:generate
```

Rodar migrations
---
```sh
php artisan migrate
```

Rodar seeders
---
```sh
php artisan db:seed
```

# Conexão com o database

Host: localhost <br>
Port: 3300 <br>
User: username <br>
password: userpass <br>
database: laravel

# Testes unitários

Os testes devem ser rodados no terminal <mark> dentro do container do app </mark> (entrar em `docker-compose exec app bash` e, após isso, rodar o comando abaixo). 

---
```sh
php artisan test --env=testing
```

# Acessar API via Insomnia/Postman

URL base: http://localhost:8000

Utilizar os seguintes headers:
- Content-Type = application/json
- Accept = Accept: application/json


Rotas disponíveis:

- POST /api/inventory (Registrar entrada de produtos no estoque)
- GET /api/inventory (Obter estoques)
- POST /api/sales (Registrar uma nova venda)
- GET /api/sales/{id} (Obter detalhes de uma venda específica)

### Exemplo de requisições POST:

Criar varios inventários
```sh
{
    "data": [
        {
            "product_id": "3",
            "quantity": 10
        },
        {
            "product_id": "2",
            "quantity": 5
        }
    ]
}
```

Criar Venda com diversos itens:
```sh
{
    "items": [
        {
            "product_id": 1,
            "unit_price": 10,
            "unit_cost": 5,
            "quantity": 10
        },
        {
            "product_id": 2,
            "unit_price": 40,
            "unit_cost": 20,
            "quantity": 5
        }
    ]
}
```
  
