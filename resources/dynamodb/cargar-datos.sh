#!/bin/bash
aws dynamodb create-table --attribute-definitions file://tabla/atributos.json --table-name curso --key-schema file://tabla/esquema-claves.json --billing-mode PROVISIONED --provisioned-throughput file://tabla/capacidad.json
aws dynamodb wait table-exists --table-name curso
aws dynamodb batch-write-item --request-items file://elementos/items-1.json
aws dynamodb batch-write-item --request-items file://elementos/items-2b.json
