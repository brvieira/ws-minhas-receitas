#!bin/bash

echo "Iniciando API ws-minhas-receitas..."

ipAddress=$(echo `hostname -I`)

echo "Endereço IP: $ipAddress"

read -p "Informe a porta que deseja utilizar: " port

command="php -S $ipAddress:$port -t public index.php"

eval $command

