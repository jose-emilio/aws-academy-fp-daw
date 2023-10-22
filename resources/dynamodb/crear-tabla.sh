#!/bin/bash
echo "Creando tabla..."
aws dynamodb create-table --attribute-definitions file://tabla/atributos.json --table-name curso --key-schema file://tabla/esquema-claves.json --billing-mode PROVISIONED --provisioned-throughput file://tabla/capacidad.json
aws dynamodb wait table-exists --table-name curso
echo "¡Tabla creada con éxito!"
