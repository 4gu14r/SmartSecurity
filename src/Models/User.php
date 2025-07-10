<?php

namespace SmartSecurity\Models;

class User extends BaseModel
{
    protected string $table = 'usuario';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'nome',
        'sobrenome',
        'dt_nascimento',
        'sexo',
        'cpf',
        'email',
        'senha',
        'endereco',
        'perfil_cod'
    ];
    
    public function findByEmail(string $email): ?array
    {
        return $this->findBy('email', $email);
    }
    
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['senha'])) {
            return $user;
        }
        
        return null;
    }
    
    public function createUser(array $data): int
    {
        // Hash da senha
        if (isset($data['senha'])) {
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }
        
        // Define perfil padrão como usuário (2) se não especificado
        if (!isset($data['perfil_cod'])) {
            $data['perfil_cod'] = 2;
        }
        
        return $this->create($data);
    }
    
    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['senha' => $hashedPassword]);
    }
    
    public function getUserWithProfile(int $userId): ?array
    {
        $sql = "
            SELECT u.*, p.perfil 
            FROM usuario u 
            LEFT JOIN perfil p ON u.perfil_cod = p.cod 
            WHERE u.id = ?
        ";
        
        $stmt = $this->query($sql, [$userId]);
        $result = $stmt->fetch();
        
        return $result ?: null;
    }
    
    public function getAllUsersWithProfile(): array
    {
        $sql = "
            SELECT u.*, p.perfil 
            FROM usuario u 
            LEFT JOIN perfil p ON u.perfil_cod = p.cod 
            ORDER BY u.nome, u.sobrenome
        ";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function searchUsers(string $search): array
    {
        $sql = "
            SELECT u.*, p.perfil 
            FROM usuario u 
            LEFT JOIN perfil p ON u.perfil_cod = p.cod 
            WHERE u.nome LIKE ? OR u.sobrenome LIKE ? OR u.email LIKE ?
            ORDER BY u.nome, u.sobrenome
        ";
        
        $searchTerm = "%{$search}%";
        $stmt = $this->query($sql, [$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function getUserStats(): array
    {
        $sql = "
            SELECT 
                COUNT(*) as total_users,
                COUNT(CASE WHEN perfil_cod = 1 THEN 1 END) as admins,
                COUNT(CASE WHEN perfil_cod = 2 THEN 1 END) as regular_users
            FROM usuario
        ";
        
        $stmt = $this->query($sql);
        return $stmt->fetch();
    }
}

