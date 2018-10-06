CREATE TABLE categorias (
	id int NOT NULL AUTO_INCREMENT,
    nome varchar(255),
    PRIMARY KEY(id)
);

CREATE TABLE receitas (
  	id int NOT NULL AUTO_INCREMENT,
    titulo varchar(255),
    ingredientes varchar(600),
    como_fazer varchar(600),
    categoria_id int,
    PRIMARY KEY(id),
    FOREIGN KEY(categoria_id) REFERENCES categorias(id)
);

INSERT INTO categorias(nome) VALUES ("Salgadas");
INSERT INTO categorias(nome) VALUES ("Doces");
INSERT INTO categorias(nome) VALUES ("Bebidas");

INSERT INTO receitas(titulo, ingredientes, como_fazer, categoria_id) VALUES ("Bolo de Chocolate", " 4 ovos 4 colheres (sopa) de chocolate em po 2 colheres (sopa) de manteiga 3 xicaras (cha) de farinha de trigo 2 xicaras (cha) de acucar 2 colheres (sopa) de fermento 1 xicara (cha) de leite", " Em um liquidificador adicione os ovos, o chocolate em po, a manteiga, a farinha de trigo, o acucar e o leite, depois bata por 5 minutos Adicione o fermento e misture com uma espatula delicadamente Em uma forma untada, despeje a massa e asse em forno medio 180 oC, preaquecido por cerca de 40 minutos", 2)