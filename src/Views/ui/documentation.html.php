<div class="content-documentation">   
    <h1>GUIA</h1>
    <p>A continuación se presenta la documentación de la API 
    </p>
    <p>
        Todos los datos se representan como archivos json por ejemplo:
        <blockquote class="consola json">
            <pre>
                {
                   "agentes" : [
                        {
                            "id": "12340",
                            "nombre": "Juan Barragan",
                        } ...
                    ]
                }
            </pre>
        </blockquote> 
    </p>
    <article>
        <h2>Obtener los datos de los Agentes Municipales en android se puede realizar la solicitud con la libreria Volley utilizando JsonArrayRequest</h2>
        <section>
            <h3 class="title3">Recurso</h3>
            <blockquote class="consola url">
                <span>
                https://<?=$_ENV['SERVER_DIRECCION'];?>/api/agentes-municipales
                </span>
            </blockquote>
            <h3 class="title3">Resultado</h3>
            <blockquote class="consola json">
                <pre>
                    [   {
                            
                            "id": "...",
                            "nombre": "...",
                            "clave": "...(encriptada)"
                            "permisos": "..."
                        },
                        {
                            
                            "id": "...",
                            "nombre": "...",
                            "clave": "...(encriptada)"
                            "permisos": "..."
                        }

                    ]
                </pre>
            </blockquote>
        </section>
    </article>      
    <article>
        <h2>Obtener los datos de los locales comerciales</h2>
        <section>
            <h3 class="title3">Recurso</h3>
            <blockquote class="consola url">
                <span>
                https://<?= $_ENV['SERVER_DIRECCION'] ?>/api/locales-comerciales
                </span>
            </blockquote>
            <h3 class="title3">Resultado</h3>
            <blockquote class="consola json">
                <pre>
                [
                        {
                            "id": "...",
                            "nombre": "...",
                            "tipo": "...",
                            "sector": "...",
                            "ruc": "...",
                            "imagen": "...(codificada en BASE 64)",
                            "id_locacion": "...",
                            "id_propietario": "...",
                            "id_usuario": "...",
                            "id":"...",(Hace referencia al id del propietario que es auto incrmental)
                            "cedula": "..."
                            "nombre_propietario":"...",
                            "ruc": "...",
                            "anonimo": "...",
                            "contabilidad": "...",
                            "celular":"..."(Numero Telefonico)
                        },
                        ...
                ]
                
                </pre>
            </blockquote>
        </section>
    </article>
    <article>
        <h2>Obtener los datos de un local comercial</h2>
        <section>
            <h3 class="title3">Recurso</h3>
            <blockquote class="consola url">
                <span>
                https://<?= $_ENV['SERVER_DIRECCION'] ?>/api/locales-comerciales?id=valor
                </span>
            </blockquote>
            <h3 class="title3">Resultado</h3>
            <blockquote class="consola json">
                <pre>
                    {
                        "id": "...",
                        "nombre": "...",
                        "tipo": "...",
                        "sector": "...",
                        "ruc": "...",
                        "imagen": "... (codificada en BASE 64)",
                        "id_locacion": "...",
                        "id_propietario": "...",
                        "id_usuario": "...",
                        "id":"...",(Hace referencia al id del propietario que es auto incrmental)
                        "cedula": "..."
                        "nombre_propietario":"...",
                        "ruc": "...",
                        "anonimo": "..." ,
                        "contabilidad": "...",
                        "celular":"..."(Numero Telefonico)
                    }
                </pre>
            </blockquote>
        </section>
    </article>  
    <article>
        <h2>Insertar datos de un local comercial por medio del metodo POST</h2>
        <section>
            <h3 class="title3">Recurso</h3>
            <blockquote class="consola url">
                <span>
                https://<?= $_ENV['SERVER_DIRECCION'] ?>/api/locales-comerciales
                </span>
            </blockquote>
            <blockquote class="info">
                <p>
                    Se debe enviar por medio de solicitud POST los siguientes arguentos
                    <ul>
                        <li>
                            <span class="clave">cedula_propietario</span> = <span class="valor">(string[ 10 ]) ➡ Es la cédula del dueño del establecimiento </span>
                        </li>
                        <li>
                            <span class="clave">nombre_propietario</span> = <span class="valor">(string) ➡ Es el nombre del dueño ejemplo Juan Perez </span>
                        </li>
                        <li>
                            <span class="clave">ruc</span> = <span class="valor">(string)</span>
                        </li>
                        <li>
                            <span class="clave">id_local</span> = <span class="valor">(string[ ejemplo = ALP-001 ]) ➡ Es el identificador alfanumerico único de ese establecimiento  separado por - </span>
                        </li>
                        <li>
                            <span class="clave">nombre_local</span> = <span class="valor">(string) ➡ Es el nombre del establecimiento </span>
                        </li>
                        <li>
                            <span class="clave">tipo</span> = <span class="valor">(string) ➡ Es el tipo de local por ejemplo farmacias o ferreterias </span>
                        </li>
                        <li>
                            <span class="clave">imagen</span> = <span class="valor">(string (codificada en BASE 64)) ➡ Es la imagen del establecimiento codificada en BASE 64 </span>
                        </li>
                        <li>
                            <span class="clave">celular</span> = <span class="valor">(string ➡ Es el número teléfono del propietario </span>
                        </li>
                        <li>
                            <span class="clave">contabilidad</span> = <span class="valor">(string ➡ Son las palabras SI o NO</span>
                        </li>
                        <li>
                            <span class="clave">id_usuario</span> = <span class="valor">(string) ➡ Es el  número de cédula del agente municipal </span>
                        </li>
                    </ul>
                </p>
            </blockquote>
            <h3 class="title3">Resultado</h3>
            <blockquote class="consola json">
                    <pre>
                        {"res":"Se inserto correctamente el local comercial","ident": 1,"error":""} 
                        || 
                        {"res":"Error no se inserto el local comercial","ident": 0,"error": "El error que muestra la base de datos"}
                    </pre>
            </blockquote>
        </section>
    </article> 
    <article>
        <h2>Obtener la información de las locaciones en android se puede realizar la solicitud con la libreria Volley utilizando JsonArrayRequest</h2>
        <section>
            <h3 class="title3">Recurso</h3>
            <blockquote class="consola url">
                <span>
                https://<?= $_ENV['SERVER_DIRECCION'] ?>/api/locaciones
                </span>
            </blockquote>
            <h3 class="title3">Resultado</h3>
            <blockquote class="consola json">
                <pre>
                [
                        {
                            "id": "...",
                            "nombre": "...",
                            "link": "..."
                        },
                        ...
                ]
                
                </pre>
            </blockquote>
        </section>
    </article>    
    <article>
        <h2>Obtener los datos de la ubicación</h2>
        <section>
            <h3 class="title3">Recurso</h3>
            <blockquote class="consola url">
                <span>
                https://<?= $_ENV['SERVER_DIRECCION'] ?>/api/locaciones?id=valor
                </span>
            </blockquote>
            <h3 class="title3">Resultado</h3>
            <blockquote class="consola json">
                <pre>
                    {
                        "id": "...",
                        "nombre": "..."
                        "link": "..."
                    }
                </pre>
            </blockquote>
        </section>
        <article>
        <h2>Insertar los datos de la ubicación por medio del metodo POST</h2>
        <section>
            <h3 class="title3">Recurso</h3>
            <blockquote class="consola url">
                <span>
                https://<?= $_ENV['SERVER_DIRECCION'] ?>/api/locaciones
                </span>
            </blockquote>
            <blockquote class="info">
                <p>
                    Se debe enviar por medio de solicitud POST los siguientes arguentos
                    <ul>
                        <li>
                            <span class="clave">id</span> = <span class="valor">(string) ➡ Es un string de las primeras letras en mayuscula preferente ejemplo ALP (ALPACHACA)</span>
                        </li>
                        <li>
                            <span class="clave">nombre</span> = <span class="valor">(string) ➡ Es el nombre del sector por ejemplo ALPACHACA</span>
                        </li>
                        <li>
                            <span class="clave">link</span> = <span class="valor">(string)</span>
                        </li>
                    </ul>
                </p>
            </blockquote>
            <h3 class="title3">Resultado</h3>
            <blockquote class="consola json">
                    <pre>
                        {"res":"Se inserto correctamente el sector","ident": 1,"error":""} 
                        || 
                        {"res":"Error no se inserto correctamente el sector","ident": 0,"error": "El error que muestra la base de datos"}
                    </pre>
            </blockquote>
        </section>
    </article>  
    <br>
    <p> Esto constituye todo lo puede realizar el sistema con la API Comercios del Gad de Guaranda</p>
    <br>
    <br>
    <p> El sistema SIGUPAC-GDA fue desarrollado por: Cristina Caluña, Viviana Gualli, Gabriel Guerrero y Jefferson Isla</p>
    <br>
    <br>
</div>