<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Sobre o desafio

Esse projeto tem como objetivo resolver o seguinte desafio:

- Criar um CRUD de rotas de API para o cadastro de bolos.
- Os bolos deverão ter Nome, Peso (em gramas), Valor, Quantidade disponível e uma lista de e-mail de interessados.
- Após o cadastro de e-mails interessados, caso haja bolo disponível, o sistema deve enviar um e-mail para os interessados sobre a disponibilidade do bolo.

### Casos a avaliar:

Pode ocorrer de 50.000 clientes se cadastrarem e o processo de envio de emails não deve ser algo impeditivo.

## Instalação e Configuração

### Requisitos
Para instalar o projeto em sua máquina são necessários as seguintes ferramentas:

- PHP 7.4
- Composer
- MySQL
- Docker

### Instalação
Primeiramente clone o repositório com o seguinte comando:

<code>git clone https://github.com/JoaoVictorViana/clickfacil-backend-teste.git</code>


Em seguida, entre na pasta do projeto

<code>cd clickfacil-backend-teste</code>

E então instale todas as dependências:

<code>composer install</code>

### Configuração

Quando finalizar a instalação, crie o arquivo .env com base no arquivo .env.example e coloque as configurações do seu banco de dados.

<code>cp .env.example .env</code>

>*Atenção: A fins de otimização e de teste, está sendo utilizando o Redis para as queues e Mailhog para o envio de e-mails.*

Em seguida rode o seguinte comando para gerar a API_KEY:

<code>php artisan key:generate</code>

>*Atenção: A fins de otimização e de teste, está sendo utilizando o Redis para as queues e Mailhog para o envio de e-mails. Caso não tenham essas ferramentas em sua máquina, foi incluido neste projeto, as imagens em Docker necessárias, basta executar o comando: <code>docker-compose up -d</code>*

Execute também os seguintes comandos para limpar a cache:

<code>php artisan cache:clear</code>
<code>php artisan config:cache</code>


### Banco de dados

Depois de ter feito todas as configurações será necessário criar o banco de dados em sua máquina e em seguida roda o comando:

<code>php artisan migrate</code>

Pronto agora o projeto está pronto para ser testado!

## API

Para resolve o desafio foi construido uma API. Segue as lista de todas as endpoints, assim como também o que é esperado como entrada e seu respectivo retorno:

### Endpoints de Bolo:

- (GET) "/api/cake": Retorna todos os bolos cadastrados.
    - Retorno: HTTP/1.1 200 OK
    - <code>["data": [[cake_id": 1, "name": 'Teste', "weight": 300, "price": 180.00, "quantity": 10, "emails": []]]]</code> 

- (POST) "/api/cake": Cadastra um novo bolo.
    - Data: <code>["name": 'Teste', "weight": 300, "price": 180.00, "quantity": 10, "list_emails": []]</code>
    - Retorno: HTTP/1.1 201 OK
    - <code>["data": ["cake_id": 1, "name": 'Teste', "weight": 300, "price": 180.00, "quantity": 10, "emails": []]]</code>

- (GET) "/api/cake/{id}": Busca por um específico bolo.
    - Retorno: HTTP/1.1 200 OK
    - <code>["data": ["cake_id": 1, "name": 'Teste', "weight": 300, "price": 180.00, "quantity": 10, "emails": []]]</code>

- (PUT) "/api/cake/{id}": Atualiza um específico bolo.
    - Data: <code>["name": 'Teste Edit']</code>
    - Retorno: HTTP/1.1 200 OK
    - <code>["message": "Bolo atualizado com sucesso!"]</code>

- (DELETE) "/api/cake/{id}": Remove um específico bolo.
    - Retorno: HTTP/1.1 200 OK
    - <code>["message": "Bolo deletado com sucesso!"]</code>


### Endpoints de Email:

- (GET) "/api/email": Retorna todos os emails cadastrados.
    - Retorno: HTTP/1.1 200 OK
    - <code>["data": ["email_interested_cake_id": 1,
            "cake_id_fk": 1,
            "email": "teste@gmail.com"]]</code> 

- (POST) "/api/email": Cadastra um novo e-mail.
    - Data: <code>["cake_id_fk": 1, "email": "teste@gmail"]</code>
    - Retorno: HTTP/1.1 201 OK
    - <code>["data": []]</code>

- (POST) "/api/email/list": Cadastra uma lista de e-mails.
    - Data: <code>["cake_id_fk": 1, "list_emails": ["teste@gmail"]]</code>
    - Retorno: HTTP/1.1 200 OK
    - <code>["data": []]</code>

- (GET) "/api/email/{id}": Busca por um específico email.
    - Retorno: HTTP/1.1 200 OK
    - <code>["data": ["email_interested_cake_id": 1,
            "cake_id_fk": 1,
            "email": "teste@gmail.com"]]</code>

- (PUT) "/api/email/{id}": Atualiza um específico e-mail.
    - Data: <code>["email": 'teste@teste']</code>
    - Retorno: HTTP/1.1 200 OK
    - <code>["message": "E-mail atualizado com sucesso!"]</code>

- (DELETE) "/api/email/{id}": Remove um específico bolo.
    - Retorno: HTTP/1.1 200 OK
    - <code>["message": "E-mail deletado com sucesso!"]</code>

## Testes

Antes de realizar todos os testes, fique atento a essas duas observações:
- Está sendo utilizado o Redis para processar a Queue, portanto, para testar os envios de e-mails, será necessário executar alguns dos seguintes comandos ou instale o <a href="http://supervisord.org" targe="_blank">supervisor</a>:
    - Antes de executar os testes: <code>php artisan queue:listen</code>
    - Depois de executar os testes: <code>php artisan queue:work</code>
- Como está sendo utilizado o Redis para executar a Queue de forma asyncrona, é necessário armazenar a queue, portanto não está sendo utilizando o RefreshDatabase do Laravel. Com isso é necessário rodar o seguinte comando antes e depois de executar os testes: <code>php artisan migrate:fresh</code>

E para realizar todos os testes, utilize o comando:

<code>php artisan test</code>

Caso tenha instalado e configurado tudo de forma correta, espera-se que todos os testes sejam concluidos com sucesso!

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
