**Operaciones DML con Amazon DynamoDB**
=======================================

* **PutItem**. Permite introducir un nuevo elemento o reemplazar un
elemento existente en una tabla. El siguiente ejemplo introduce un nuevo elemento en la tabla `curso` con los atributos especificados en el fichero `item.json`:

        aws dynamodb put-item --table-name curso --item file://operaciones/put-item/item.json

* **GetItem**. Permite obtener un elemento de una tabla a partir de
su clave. El siguiente ejemplo extrae un elemento de la tabla `curso` a partir de la clave almacenada en el archivo `clave.json` y proyecta la salida sobre los atributos `convocatoria` y `nota`:

        aws dynamodb get-item --table-name curso --key file://operaciones/get-item/clave.json --projection-expression "convocatoria, nota"

* **DeleteItem**. Permite eliminar un elemento de una tabla a
partir de su clave. El siguiente ejemplo elimina un elemento de la tabla `curso` a partir de la clave, especificada en el fichero `clave.json` y devuelve por la consola los atributos del elemento antes de su eliminación:

        aws dynamodb delete-item --table-name curso --key file://operaciones/delete-item/clave.json --return-values ALL_OLD

* **UpdateItem**. Permite editar los atributos de un elemento existente o añadir un nuevo elemento a la tabla si no existe. El siguiente ejemplo modifica un elemento de la tabla `curso` existente, identificado por su clave (en el archivo `clave.json`), incrementando uno de sus atributos y añadiendo un valor a otro atributo (lista), a partir de los parámetros indicados en el archivo `valores.json`

        aws dynamodb update-item --table-name curso --key file://operaciones/update-item/clave.json --update-expression "SET convocatoria = convocatoria + :inc, nota = list_append(nota, :n)" --expression-attribute-values file://operaciones/update-item/valores.json --return-values ALL_NEW

* **Scan**. Obtiene todos los elementos de una tabla que, opcionalmente,
cumplan una serie de condiciones. En el ejemplo siguiente se obtienen los módulos y las notas de un alumno especificado en el archivo `valores.json`:

        aws dynamodb scan --table-name curso --filter-expression "alumno = :al\" --expression-attribute-values file://operaciones/scan/valores.json --projection-expression "modulo,nota"

* **Query**. Obtiene todos los elementos de una partición de una tabla que, opcionalmente, cumplan una serie de condiciones. El siguiente ejemplo obtiene para un módulo concreto aquellos alumnos que lo han cursado en un año concreto y lo han aprobado en la primera convocatoria. Estos datos están especificados en el fichero `valores.json`:

        aws dynamodb query --table-name curso --key-condition-expression "modulo= :mod" --filter-expression "curso = :cur AND nota[0]>=:n" --expression-attribute-values file://operaciones/query/valores.json --projection-expression "alumno, nota"
