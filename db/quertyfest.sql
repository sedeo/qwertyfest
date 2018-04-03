------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id          bigserial       PRIMARY KEY
  , nombre      varchar(255)    NOT NULL
  , password    varchar(255)    NOT NULL
  , auth_key    varchar(255)
  , token_val   varchar(255)    UNIQUE
  , direccion   varchar(255)
  , fec_nac     date
  , telefono    numeric(9)
  , admin       boolean         DEFAULT false
  , created_at  timestamp(0)    NOT NULL
);

DROP TABLE IF EXISTS salas CASCADE;

CREATE TABLE salas
(
    id          bigserial       PRIMARY KEY
  , propietario bigint          REFERENCES usuarios (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , n_max       numeric(1)      NOT NULL
  , descripcion varchar(255)
  , usuarios    numeric(1)
  , created_at timestamp(0)     NOT NULL
);

DROP TABLE IF EXISTS informes CASCADE;

CREATE TABLE informes
(
    id          bigserial       PRIMARY KEY
  , id_recibe   bigint          REFERENCES usuarios (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , id_envia    bigint          REFERENCES usuarios (id)
                                ON DELETE NO ACTION
                                ON UPDATE CASCADE
  , motivo      varchar(255)    NOT NULL
  , descripcion varchar(255)
  , created_at  timestamp(0)    NOT NULL
);
