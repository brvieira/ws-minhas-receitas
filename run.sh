#!bin/bash

echo "Iniciando API ws-minhas-receitas..."

read -p "Informe o IP que deseja utilizar: " ipAddress

read -p "Informe a porta que deseja utilizar: " port

command="php -S $ipAddress:$port -t public index.php"

eval $command

