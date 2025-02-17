<?php
// Configurações e conexão com o banco de dados
include_once 'config.php';

class Database extends Config {

    // Método para buscar os dados
    public function fetch($id = 0) {
        try {
            $sql = 'SELECT * FROM usuarios';
            $params = [];

            if ($id != 0) {
                $sql .= ' WHERE id = :id';
                $params['id'] = $id;
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll();

            // Retorna os resultados no formato JSON
            echo json_encode($rows);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // Método para inserir dados
    public function insert() {
        try {
            // Leitura do corpo da requisição
            $data = json_decode(file_get_contents('php://input'), true);

            // Verifica se os dados foram recebidos corretamente
            if (!$data) {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao decodificar JSON']);
                exit();
            }

            // Prepara a query de inserção
            $sql = 'INSERT INTO usuarios (nome, email, endereco, cpf, data_nascimento, telefone, escola) 
                    VALUES (:nome, :email, :endereco, :cpf, :data_nascimento, :telefone, :escola)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'nome' => $data['nome'],
                'email' => $data['email'],
                'endereco' => $data['endereco'],
                'cpf' => $data['cpf'],
                'data_nascimento' => $data['data_nascimento'],
                'telefone' => $data['telefone'],
                'escola' => $data['escola']
            ]);

            // Retorna resposta no formato JSON após inserção bem-sucedida
            echo json_encode(['status' => 'success', 'message' => 'Dados inseridos com sucesso!']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit();
    }
}

// Verifica se a requisição é POST (para inserção de dados)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $database->insert();
} else {
    // Se for GET, retorna os dados
    $database = new Database();
    $database->fetch();
}
?>
