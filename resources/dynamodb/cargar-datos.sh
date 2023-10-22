#!/bin/bash
echo "Cargando datos..."
aws dynamodb batch-write-item --request-items file://elementos/items-1.json
aws dynamodb batch-write-item --request-items file://elementos/items-2.json
echo "¡Datos cargados!"
