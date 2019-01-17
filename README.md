# biblia
projeto usando FatFree framework (PHP)
biblia versão João Ferreira de Almeida, em Português

Bible
project using FatFree framework (PHP)
bible version João Ferreira de Almeida, in Portuguese

Baseado no tutorial : https://takacsmark.com/fat-free-php-framework-tutorial-1-basics/

Esta app foi construída usando a solução de gerenciamento de pacotes 'Composer' (link para instalacao: https://getcomposer.org/doc/00-intro.md)

Depois de instalar o 'Composer', você precisa adicionar o 'Fat-Free' ao seu projeto usando o 'Composer'. Portanto, crie seu diretório de projetos no seu computador, caso ainda não o tenha feito, e abra o local no terminal. Vá até a pasta do seu projeto e digite o seguinte comando:

> compositor init

Seguindo as instruções do processo de iniciação do projeto do 'Composer', ao concluir, você deverá ter um novo arquivo na sua pasta de projeto chamado:

'composer.json'

O conteúdo será similar a este:

>{
>    "name": "biblia",
>    "description": "acesso ao bd com a biblia por versiculos",
>    "authors": [
>        {
>            "name": "ricardo",
>            "email": "email@empresa.com.br"
>        }
>    ],
>    "require": {
>    		"bcosca/fatfree" : "^3.6"
>	}
>}


Para tornar isso efetivo, por favor, digite o seguinte comando abaixo, na pasta do seu projeto no terminal.

> composer update


Depois de concluir essa etapa, uma nova pasta chamada 'vendor' deve aparecer na pasta do projeto. A pasta 'vendor' contém as bibliotecas de terceiros instaladas pelo 'Composer'.

Para ver o resultado no navegador, você precisa executar um servidor da Web em sua máquina. Se você quer fazer um teste rápido, o servidor web do PHP é uma ótima opção (a partir do PHP 5.4.0). Você pode iniciá-lo emitindo o seguinte comando do seu terminal quando estiver no diretório do seu projeto:

> php -S localhost:8088 -t .

ou 

> sudo php -S localhost:80 -t .



