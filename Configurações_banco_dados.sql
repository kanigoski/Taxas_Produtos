/*
Configurações:

Nome do Banco de Dados: processo_seletivo
Usuário: postgres
Senha: postgres
*/

--Criação das 2 tabelas utilizadas
CREATE TABLE public.tipo_produto
(
  id_tipo_produto serial NOT NULL,
  descricao character varying NOT NULL,
  tributo double precision,
  registro_valido boolean NOT NULL,
  PRIMARY KEY (id_tipo_produto)
)

CREATE TABLE public.produto
(
  id_produto serial NOT NULL,
  id_tipo_produto integer NOT NULL,
  descricao character varying NOT NULL,
  valor double precision,
  registro_valido boolean NOT NULL,
  PRIMARY KEY (id_produto),
  FOREIGN KEY (id_tipo_produto) REFERENCES tipo_produto(id_tipo_produto)
)