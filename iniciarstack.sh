#!/bin/bash

set -x

#!/bin/bash

# Directorio que se va a verificar
directorio="magento"

# Verificar si el directorio existe
if [ ! -d "$directorio" ]; then
  # Crear el directorio si no existe
  mkdir -p "$directorio"
  echo "Se creó el directorio: $directorio"
else
  echo "El directorio ya existe: $directorio"
fi

docker compose up -d

./mutagen.sh
