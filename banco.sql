create table usuarios(

    id_usuario INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    senha  VARCHAR(50) NOT NULL,
    nivel  VARCHAR(50) NOT NULL
);


create table categorias(
    id_categoria INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    data date NOT NULL,
    id_usuario int,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)

);


create table postagem(

    id_postagem INTEGER PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT NOT NULL,
    imagem VARCHAR(250) NULL,
    data date NOT NULL,
    id_usuario int,
    id_categoria int,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);