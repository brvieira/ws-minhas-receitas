<?php

use Slim\Http\Request;
use Slim\Http\Response;

/* 
** Endpoints para /receitas.
*/

//Este endpoint retorna todas as receitas cadastradas no banco de dados, ordenando por id.
$app->get('/receitas', function ($request, $response) {
    $db = $this->db;

    try {
        $sth = $db->prepare('SELECT * FROM receitas ORDER BY id');
        $sth->execute();
        while ($linha = $sth->fetch()) {
            $retorno[] = $linha;
        }
    } catch (PDOException $e) {
        $retorno['erro'] = $e;
        $retorno['message'] = 'Erro na comunicação!';
    } finally {
        return $response->withJson($retorno);
    }
});

// Este endpoint retorno uma receita cadastrada no banco, buscando pelo id da mesma.
$app->get('/receitas/{id}', function ($request, $response, $args) {
    $db = $this->db;
    $id[] = $args['id'];
    $sth = $db->prepare('SELECT * FROM receitas WHERE id = ?');

    try {
        $sth->execute($id);
        $retorno[] =  $sth->fetch(PDO::FETCH_OBJ);
        
    } catch (PDOException $e) {
        $retorno['erro'] = $e;
        $retorno['message'] = 'Erro na comunicação!';
    } finally {
        return $response->withJson($retorno);
    }
});

//Este endpoint retorna todas as receitas cadastradas no banco de dados, ordenando por id.
$app->get('/categorias/receitas/{id}', function ($request, $response, $args) {
    $db = $this->db;
    $id[] = $args['id'];
    $sth = $db->prepare('SELECT * FROM receitas WHERE categoria_id = ? ORDER BY id');
    $retorno = [];
    try {
        $sth->execute($id);
        while ($linha = $sth->fetch()) {
            $retorno[] = $linha;
        }
    } catch (PDOException $e) {
        $retorno['erro'] = $e;
        $retorno['message'] = 'Erro na comunicação!';
    } finally {
        return $response->withJson($retorno);
    }
});

// Este endpoint é responsável por receber dados de uma receita e insere no banco de dados.
$app->post('/receitas', function ($request, $response) {
    $receita = $request->getParsedBody();

    $receitaInsert[] = $receita['titulo'];
    $receitaInsert[] = $receita['ingredientes'];
	$receitaInsert[] = $receita['como_fazer'];
	$receitaInsert[] = $receita['categoria_id'];

    $db = $this->db;

    $sth = $db->prepare("INSERT INTO receitas(titulo, ingredientes, como_fazer, categoria_id) VALUES (?, ?, ?, ?)");

    try {
        $sth->execute($receitaInsert);
    } catch (PDOException $e) {
        return $response->withStatus(404);
    }

    $lastInsertId = $db->lastInsertId();

    $sth = $db->prepare("SELECT * FROM receitas WHERE id = ?");

    try {
        $sth->execute(array($lastInsertId));
        $receitasDB = $sth->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        return $response->withStatus(404);
    }

    return $response->withJson($receitasDB);
});

// Este endpoint é responsável por remover uma receita do banco de dados, recebendo como parâmetro o id.
$app->delete('/receitas/{id}', function ($request, $response, $args) {
    $db = $this->db;

    $id[] = $args['id'];

    $sth = $db->prepare('DELETE FROM receitas WHERE id = ?');

    try {
        $sth->execute($id);
    } catch (PDOException $e) {
        return $response->withStatus(404);
    }

    return $response->withStatus(200);
});

// Este endpoint é responsável de atualizar uma receita no banco de dados.
$app->put('/receitas', function ($request, $response) {
    $db = $this->db;

    $receita = $request->getParsedBody();

    $sth = $db->prepare('UPDATE receitas SET titulo = ?, ingredientes = ?, como_fazer = ?, categoria_id = ? WHERE id = ?');

    $receitaInsert[] = $receita['titulo'];
    $receitaInsert[] = $receita['ingredientes'];
	$receitaInsert[] = $receita['como_fazer'];
	$receitaInsert[] = $receita['categoria_id'];
	$receitaInsert[] = $receita['id'];
	
    try {
        $sth->execute($receitaInsert);
    } catch (PDOException $e) {
        return $response->withStatus(404);
    }

    return $response->withStatus(200);
});

/*  
** Endpoints para /categorias
*/

//Este endpoint retorna todas as categorias cadastradas no banco de dados, ordenando por id.
$app->get('/categorias', function ($request, $response) {
    $db = $this->db;

    try {
        $sth = $db->prepare('SELECT * FROM categorias ORDER BY id');
        $sth->execute();
        while ($linha = $sth->fetch()) {
            $retorno[] = $linha;
        }
    } catch (PDOException $e) {
        $retorno['erro'] = $e;
        $retorno['message'] = 'Erro na comunicação!';
    } finally {
        return $response->withJson($retorno);
    }
});

// Este endpoint retorno uma categoria cadastrada no banco, buscando pelo id da mesma.
$app->get('/categorias/{id}', function ($request, $response, $args) {
    $db = $this->db;
    $id[] = $args['id'];
    $sth = $db->prepare('SELECT * FROM categorias WHERE id = ?');

    try {
        $sth->execute($id);
        $retorno[] =  $sth->fetch(PDO::FETCH_OBJ);
        
    } catch (PDOException $e) {
        $retorno['erro'] = $e;
        $retorno['message'] = 'Erro na comunicação!';
    } finally {
        return $response->withJson($retorno);
    }
});

// Este endpoint é responsável por receber dados de uma categoria e insere no banco de dados.
$app->post('/categorias', function ($request, $response) {
    $categoria = $request->getParsedBody();

    $categoriaInsert[] = $categoria['nome'];

    $db = $this->db;

    $sth = $db->prepare("INSERT INTO categorias(nome) VALUES (?)");

    try {
        $sth->execute($categoriaInsert);
    } catch (PDOException $e) {
        return $response->withStatus(404);
    }

    $lastInsertId = $db->lastInsertId();

    $sth = $db->prepare("SELECT * FROM categorias WHERE id = ?");

    try {
        $sth->execute(array($lastInsertId));
        $categoriasDB = $sth->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        return $response->withStatus(404);
    }

    return $response->withJson($categoriasDB);
});

// Este endpoint é responsável por remover uma categoria do banco de dados, recebendo como parâmetro o id.
$app->delete('/categorias/{id}', function ($request, $response, $args) {
    $db = $this->db;

    $id[] = $args['id'];

    $sth = $db->prepare('DELETE FROM categorias WHERE id = ?');

    try {
        $sth->execute($id);
    } catch (PDOException $e) {
        return $response->withStatus(404);
    }

    return $response->withStatus(200);
});

// Este endpoint é responsável de atualizar uma categoria no banco de dados.
$app->put('/categorias', function ($request, $response) {
    $db = $this->db;

    $categoria = $request->getParsedBody();

    $sth = $db->prepare('UPDATE categorias SET nome = ? WHERE id = ?');

    $categoriaInsert[] = $categoria['nome'];
	$categoriaInsert[] = $categoria['id'];
	
    try {
        $sth->execute($categoriaInsert);
    } catch (PDOException $e) {
        return $response->withStatus(404);
    }

    return $response->withStatus(200);
});